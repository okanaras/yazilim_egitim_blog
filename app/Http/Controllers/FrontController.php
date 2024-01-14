<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleComment;
use App\Models\Category;
use App\Models\Settings;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class FrontController extends Controller
{

    /*
        view share burada construct icine yazildigi icin her yerde direkt calisacak mesela articleCommentte olmadigi halde calisacak bu yuzden duruma gore composer(appprovider) veya share kullanilmali

        public function __construct()
        {
            $settings = Settings::first();
            $categories = Category::query()->where("status", 1)->get();

            View::share(["categories" => $categories, "settings" => $settings]);
        }
    */

    public function home()
    {
        // $settings = Settings::first();
        // $categories = Category::query()->where("status", 1)->get();

        return view("front.index");
    }

    public function category(Request $request, string $slug)
    {
        /*

        ders 83 te silinmisti.

        $category = Category::query()->with("articlesActive")->where("slug", $slug)->first();
        $articles = $category->articlesActive()->paginate(2);
        */

        $articles = Article::query()
            ->with(['category:id,name,slug', 'user:id,name,username'])
            ->whereHas("category", function ($query) use ($slug) {
                $query->where("slug", $slug);
            })
            ->paginate(21);

        $title = Category::query()->where("slug", $slug)->first()->name . " Kategorisine Ait Makaleler";
        return view("front.article-list", compact("articles", "title"));
    }

    public function articleDetail(Request $request, string $username, string $articleSlug)
    {
        $article = session()->get('last_article');
        $visitedArticles = session()->get('visited_articles');

        // session ile makale onerme
        // ziyaret edilen category id
        $visitedArticlesCategoryIds = [];
        $visitedArticleAuthorIds = [];
        $visitedInfo = Article::query()
            ->select("user_id", "category_id")
            ->whereIn("id", $visitedArticles)
            ->get();
        foreach ($visitedInfo as $item) {
            $visitedArticlesCategoryIds[] = $item->category_id;
            $visitedArticleAuthorIds[] = $item->user_id;
        }
        // dd($visitedArticlesCategoryIds, $visitedArticleAuthorIds);

        // oneride bulunan article whereNotIn=without visitedArticles!
        $suggestArticles = Article::query()
            ->with(['user', 'category'])
            ->where(function ($query) use ($visitedArticlesCategoryIds, $visitedArticleAuthorIds) {
                $query->whereIn("category_id", $visitedArticlesCategoryIds)
                    ->orWhereIn('user_id', $visitedArticleAuthorIds);
            })
            ->whereNotIn("id", $visitedArticles)
            ->limit(6)
            ->get();

        $userLike = $article
            ->articleLikes
            ->where("article_id", $article->id)
            ->where("user_id", auth()->id())
            ->first();

        // view count arttirma
        $article->increment("view_count");
        $article->save();

        return view('front.article-detail', compact("article", "userLike", "suggestArticles"));
    }

    public function articleComment(Request $request, Article $article)
    {
        $data = $request->except("_tokent");
        if (Auth::check()) {
            $data['user_id'] = Auth::id();
        }

        $data['article_id'] = $article->id;
        $data['ip'] = $request->ip();

        ArticleComment::create($data);

        alert()
            ->success('Basarili', "Yorumun gonderilmistir. Kontroller sonrasi yayinlanacaktir!")
            ->showConfirmButton('Tamam', '#3085d6')
            ->autoClose(5000);
        return redirect()->back();

    }

    public function authorArticles(Request $request, string $username)
    {
        $articles = Article::query()
            ->with(['category:id,name,slug', 'user:id,name,username'])
            ->whereHas("user", function ($query) use ($username) {
                $query->where("username", $username);
            })
            ->paginate(21);

        $title = User::query()->where("username", $username)->first()->name . " Makaleleri";

        return view("front.article-list", compact("articles", "title"));
    }

    // search
    public function search(Request $request)
    {
        $searchText = $request->q;
        $articles = Article::query()
            ->with(["user", "category"])
            ->whereHas("user", function ($query) use ($searchText) {
                $query->where('name', 'LIKE', "%" . $searchText . '%')
                    ->orWhere("username", "LIKE", "%" . $searchText . "%")
                    ->orWhere("about", "LIKE", "%" . $searchText . "%");
            })
            ->whereHas("category", function ($query) use ($searchText) {
                $query->orWhere('name', 'LIKE', "%" . $searchText . '%')
                    ->orWhere("description", "LIKE", "%" . $searchText . "%")
                    ->orWhere("slug", "LIKE", "%" . $searchText . "%");
            })
            ->orWhere("title", "LIKE", "%" . $searchText . "%")
            ->orWhere("slug", "LIKE", "%" . $searchText . "%")
            ->orWhere("body", "LIKE", "%" . $searchText . "%")
            ->orWhere("tags", "LIKE", "%" . $searchText . "%")
            ->paginate(30);

        $title = "\n' $searchText '\n" . " arama sonucu";

        return view("front.article-list", compact("articles", "title"));

    }
}