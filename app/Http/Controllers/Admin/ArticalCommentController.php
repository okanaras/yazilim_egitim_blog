<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ArticleComment;
use App\Models\User;
use App\Models\UserLikeArticle;
use App\Models\UserLikeComment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ArticalCommentController extends Controller
{
    public function approvalList(Request $request)
    {
        $users = User::all();
        $comments = ArticleComment::query()
            ->with('user', 'article', 'children', 'article.user')
            ->approveStatus()
            ->user($request->user_id)
            ->createdDate($request->created_at)
            ->searchText($request->search_text)
            ->paginate(10);

        $page = "approval";

        return view("admin.articles.comment-list", compact("comments", "users", "page"));
    }

    public function list(Request $request)
    {
        $users = User::all();
        $comments = ArticleComment::query()
            ->withTrashed()
            ->with('user', 'article', 'children', 'article.user')
            ->status($request->status)
            ->user($request->user_id)
            ->createdDate($request->created_at)
            ->searchText($request->search_text)
            ->paginate(10);

        $page = "commentList";

        return view("admin.articles.comment-list", compact("comments", "users", "page"));
    }

    public function changeStatus(Request $request)
    {
        $comment = ArticleComment::findOrFail($request->id);
        $comment->status = $comment->status ? 0 : 1;
        $comment->save();

        return response()
            ->json(
                [
                    'status' => "succes",
                    "message" => "Basarili",
                    "data" => $comment,
                    "comment_status" => $comment->status
                ]
            )
            ->setStatusCode(200);
    }

    public function delete(Request $request)
    {
        $comment = ArticleComment::findOrFail($request->id);
        $comment->delete();

        return response()
            ->json(
                [
                    'status' => "succes",
                    "message" => "Basarili",
                    "data" => $comment,
                    "comment_status" => $comment->status
                ]
            )
            ->setStatusCode(200);
    }

    public function restore(Request $request)
    {
        $comment = ArticleComment::withTrashed()->findOrFail($request->id);
        $comment->restore();

        return response()
            ->json(
                [
                    'status' => "succes",
                    "message" => "Basarili",
                    "data" => $comment,
                ]
            )
            ->setStatusCode(200);
    }

    public function favorite(Request $request)
    {
        $comment = ArticleComment::query()
            ->with([
                "commentLikes" => function ($query) {
                    $query->where('user_id', auth()->id());
                }
            ])
            ->where("id", $request->id)
            ->firstOrFail();



        if ($comment->commentLikes->count()) {
            $comment->commentLikes()->delete();
            $comment->like_count--;
            $process = 0;
        } else {
            UserLikeComment::create([
                'user_id' => auth()->id(),
                'comment_id' => $comment->id
            ]);
            $comment->like_count++;
            $process = 1;
        }

        $comment->save();

        return response()
            ->json([
                'status' => "success",
                "message" => "basarili",
                "like_count" => $comment->like_count,
                "process" => $process

            ])
            ->setStatusCode(200);
    }
}