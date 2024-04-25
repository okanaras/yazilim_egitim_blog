<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Article;
use Illuminate\Http\Request;

class VisitedArticleMiddleware
{
    public function __construct(public Article $article)
    {
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $article = $this->article::query()
            ->with([
                "user.articleLike",
                "comments" => function ($query) {
                    $query->where("status", 1)
                        ->where("approve_status", 1)
                        ->whereNull("parent_id");
                },
                "comments.commentLikes",

                "comments.user",
                "comments.children" => function ($query) {
                    $query->where("status", 1)
                        ->where("approve_status", 1);
                },
                "comments.children.user",
                "comments.children.commentLikes"
            ])
            ->where("slug", $request->article)
            ->first();

        // ziyaret edilen makale id
        $visitedArticles = session()->get("visited_articles", []);
        $visitedArticles[] = $article->id;
        session()->put('visited_articles', $visitedArticles);
        session()->put('last_article', $article);

        return $next($request);
    }
}