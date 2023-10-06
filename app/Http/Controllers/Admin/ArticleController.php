<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use \Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index()
    {
        return view("admin.articles.list");
    }

    public function create()
    {
        $categories = Category::all();

        return view("admin.articles.create-update", compact('categories'));
    }

    public function store(Request $request)
    {
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
        $data["image"] = $publicPath . "/" . $fileName;
        $data["user_id"] = auth()->id();
        /*
        * 4 yontemde kaydeder
        $data["user_id"] = auth()->user()->id;
        $data["user_id"] = Auth::id();
        $data["user_id"] = Auth::->user()->id;
        */

        // dd($data);
        Article::create($data);
        $imageFile->storeAs($folder, $fileName, "public"); // public in altina articles klasorune verdigimiz ad'daki sekilde atar ve local yerine public ozelliklerini kullanir

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

    public function slugCheck(string $text)
    {
        return Article::where("slug", $text)->first();
    }
}