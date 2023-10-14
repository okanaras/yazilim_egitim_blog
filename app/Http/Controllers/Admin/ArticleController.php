<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleFilterRequest;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use \Illuminate\Support\Facades\File;
use \Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File as FacadesFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index(ArticleFilterRequest $request)
    {
        $categories = Category::all();
        $users = User::all();
        $list = Article::query()
            ->with(["category", "user"])
            ->where(function ($query) use ($request) {
                $query->orWhere("title", "LIKE", "%" . $request->search_text . "%")
                    ->orWhere("slug", "LIKE", "%" . $request->search_text . "%")
                    ->orWhere("body", "LIKE", "%" . $request->search_text . "%")
                    ->orWhere("tags", "LIKE", "%" . $request->search_text . "%");
            })
            ->status($request->status)
            ->category($request->category_id)
            ->user($request->user_id)
            ->publishDate($request->publish_date)
            ->where(function ($query) use ($request) {
                if ($request->min_view_count) {
                    $query->where('view_count', ">=", (int) $request->min_view_count);
                }
                if ($request->max_view_count) {
                    $query->where('view_count', "<=", (int) $request->max_view_count);
                }
                if ($request->min_like_count) {
                    $query->where('like_count', ">=", (int) $request->min_like_count);
                }
                if ($request->max_like_count) {
                    $query->where('like_count', "<=", (int) $request->max_like_count);
                }
            })
            ->paginate(5);

        return view("admin.articles.list", compact("categories", "users", "list"));
    }

    public function create()
    {
        $categories = Category::all();

        return view("admin.articles.create-update", compact('categories'));
    }

    public function store(Request $request)
    {
        if (!is_null($request->image)) {
            $imageFile = $request->file("image"); // alacagim dosya inputtaki name
            $originalName = $imageFile->getClientOriginalName(); // original name
            $originalExtension = $imageFile->getClientOriginalExtension(); // original extension
            // $originalExtension = $imageFile->extension();
            $explodeName = explode(".", $originalName)[0]; // burada 0. indisi gondererek explode ile sadece adini aliyoruz
            $fileName = Str::slug($explodeName) . "." . $originalExtension; // slug ile bosluklari temizleyip sonuna uzantisini ekliyoruz

            $folder = "articles";
            $publicPath = "storage/" . $folder;


            if (file_exists(public_path($publicPath . $fileName))) {
                return redirect()->back()->withErrors([
                    'image' => "Ayni gorsel daha once yuklenmistir"
                ]);
            }
        }
        $data = $request->except("_token"); // requestten gelen token disindaki verileri al
        $slug = $data['slug'] ?? $data['title']; // slug kontrolu
        $slug = Str::slug($slug); // sluglama islemi
        $slugTitle = Str::slug($data["title"]);

        $checkSlug = $this->slugCheck($slug);

        if (!is_null($checkSlug)) {
            $checkTitleSlug = $this->slugCheck($slugTitle);
            if (!is_null($checkTitleSlug)) {
                $slug = Str::slug($slug . time());
            } else {
                $slug = $slugTitle;
            }
        }
        $data["slug"] = $slug;

        if (!is_null($request->image)) {
            $data["image"] = $publicPath . "/" . $fileName;
        }
        $data["user_id"] = auth()->id();
        /*
        * 4 yontemde kaydeder
        $data["user_id"] = auth()->user()->id;
        $data["user_id"] = Auth::id();
        $data["user_id"] = Auth::->user()->id;
        */

        // dd($data);
        Article::create($data);
        if (!is_null($request->image)) {
            $imageFile->storeAs($folder, $fileName, "public"); // public in altina articles klasorune verdigimiz ad'daki sekilde atar ve local yerine public ozelliklerini kullanir
        }

        /*
        $imageFile->store("articles", "public");
         public in altina articles klasorune hashlanmis sekilde atar ve local yerine public ozelliklerini kullanir
         */

        alert()
            ->success('Basarili', "Makale Kaydedildi!")
            ->showConfirmButton('Tamam', '#3085d6')
            ->autoClose(5000);

        return redirect()->back();
    }

    public function edit(Request $request, int $articleID)
    {
        // $article = Article::find($articleID);
        // $article = Article::where("id", $articleID)->firstOrFail();
        $article = Article::query()
            ->where("id", $articleID)
            ->first();
        $categories = Category::all();
        $users = User::all();

        if (is_null($article)) {
            alert()
                ->error('Hata', "Makale Bulunamadi!")
                ->showConfirmButton('Tamam', '#3085d6')
                ->autoClose(5000);
            return redirect()->route('article.index');
        }

        return view("admin.articles.create-update", compact('article', 'categories', 'users'));
    }

    public function update(Request $request)
    {
        $data = $request->except("_token"); // requestten gelen token disindaki verileri al
        $slug = $data['slug'] ?? $data['title']; // slug kontrolu
        $slug = Str::slug($slug); // sluglama islemi
        $slugTitle = Str::slug($data["title"]);

        $checkSlug = $this->slugCheck($slug);

        if (!is_null($checkSlug)) {
            $checkTitleSlug = $this->slugCheck($slugTitle);
            if (!is_null($checkTitleSlug)) {
                $slug = Str::slug($slug . time());
            } else {
                $slug = $slugTitle;
            }
        }

        $data["slug"] = $slug;
        if (!is_null($request->image)) {
            $imageFile = $request->file("image"); // alacagim dosya inputtaki name
            $originalName = $imageFile->getClientOriginalName(); // original name
            $originalExtension = $imageFile->getClientOriginalExtension(); // original extension
            // $originalExtension = $imageFile->extension();
            $explodeName = explode(".", $originalName)[0]; // burada 0. indisi gondererek explode ile sadece adini aliyoruz
            $fileName = Str::slug($explodeName) . "." . $originalExtension; // slug ile bosluklari temizleyip sonuna uzantisini ekliyoruz

            $folder = "articles";
            $publicPath = "storage/" . $folder;

            if (file_exists(public_path($publicPath . $fileName))) {
                return redirect()->back()->withErrors([
                    'image' => "Ayni gorsel daha once yuklenmistir"
                ]);
            }

            $data["image"] = $publicPath . "/" . $fileName;

        }
        $data["user_id"] = auth()->id();

        $articleQuery = Article::query()
            ->where("id", $request->id);

        $articleFind = $articleQuery->first();

        $articleQuery->update($data);

        if (!is_null($request->image)) {

            if (file_exists(public_path($articleFind->image))) {

                File::delete(public_path($articleFind->image));
            }
            $imageFile->storeAs($folder, $fileName, "public");
        }

        alert()
            ->success('Basarili', "Makale Guncellendi!")
            ->showConfirmButton('Tamam', '#3085d6')
            ->autoClose(5000);

        return redirect()->route("article.index");
    }

    public function slugCheck(string $text)
    {
        return Article::where("slug", $text)->first();
    }
    public function changeStatus(Request $request): JsonResponse
    {
        $articleID = $request->articleID;
        $article = Article::query()
            ->where("id", $articleID)
            ->first();

        if ($article) {
            $article->status = $article->status ? 0 : 1;
            $article->save();
            return response()
                ->json(['status' => "success", "message" => "basarili", "data" => $article, "article_status" => $article->status])
                ->setStatusCode(200);
        }
        return response()
            ->json(['status' => "error", "message" => "makale bulunamadi"])
            ->setStatusCode(404);
    }

    public function delete(Request $request)
    {
        $articleID = $request->articleID; // requestteki id ajaxla gonderilen

        $article = Article::query()
            ->where("id", $articleID)
            ->first();

        if ($article) {
            $article->delete();
            return response()
                ->json(['status' => "success", "message" => "basarili"])
                ->setStatusCode(200);
        }
        return response()
            ->json(['status' => "error", "message" => "makale bulunamadi"])
            ->setStatusCode(404);
    }
}