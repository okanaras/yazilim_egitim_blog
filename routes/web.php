<?php

use App\Http\Controllers\Admin\ArticalCommentController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\FrontController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix("admin")->middleware(["auth", "verified"])->group(function () {
    // admin role
    Route::middleware("isAdmin")->group(function () {
        Route::group(['prefix' => 'filemanager'], function () {
            \UniSharp\LaravelFilemanager\Lfm::routes();
        });

        Route::get('/', function () {
            return view('admin.index');
        })->name("admin.index");

        Route::get("articles", [ArticleController::class, "index"])->name("article.index");
        Route::get("articles/create", [ArticleController::class, "create"])->name("article.create");
        Route::post("articles/create", [ArticleController::class, "store"]);
        Route::get("articles/{id}/edit", [ArticleController::class, "edit"])->name("article.edit");
        Route::post("articles/{id}/edit", [ArticleController::class, "update"]);
        Route::post('article/change-status', [ArticleController::class, "changeStatus"])->name("article.changeStatus");
        Route::delete('article/delete', [ArticleController::class, "delete"])->name("article.delete");

        Route::get("article/pending-approval", [ArticalCommentController::class, "approvalList"])->name("artical.pending-approval");
        Route::get("article/comment-list", [ArticalCommentController::class, "list"])->name("artical.comment.list");
        Route::post("article/pending-approval/change-status", [ArticalCommentController::class, "changeStatus"])->name("artical.pending-approval.changeStatus");
        Route::delete("article/pending-approval/delete", [ArticalCommentController::class, "delete"])->name("artical.pending-approval.delete");
        Route::post("article/comment-restore", [ArticalCommentController::class, "restore"])->name("artical.comment.restore");

        Route::get("categories", [CategoryController::class, "index"])->name("category.index");
        Route::get("categories/create", [CategoryController::class, "create"])->name("category.create");
        Route::post("categories/create", [CategoryController::class, "store"]);
        Route::post('categories/change-status', [CategoryController::class, "changeStatus"])->name("categories.changeStatus");
        Route::post('categories/change-feature-status', [CategoryController::class, "changeFeatureStatus"])->name("categories.changeFeatureStatus");
        Route::post('categories/delete', [CategoryController::class, "delete"])->name("categories.delete");
        Route::get('categories/{id}/edit', [CategoryController::class, "edit"])->name("categories.edit")->whereNumber("id");
        Route::post('categories/{id}/edit', [CategoryController::class, "update"])->whereNumber("id");


        Route::get('settings', [SettingsController::class, "show"])->name("settings");
        Route::post('settings', [SettingsController::class, "update"]);


        Route::get("users/create", [UserController::class, "create"])->name("user.create");
        Route::post("users/create", [UserController::class, "store"]);
        Route::get("users", [UserController::class, "index"])->name("user.index");
        Route::post('users/change-status', [UserController::class, "changeStatus"])->name("user.changeStatus");
        Route::post('users/change-is-admin', [UserController::class, "changeIsAdmin"])->name("user.changeIsAdmin");
        Route::get('users/{user:username}/edit', [UserController::class, "edit"])->name("user.edit")->whereNumber("id");
        Route::post('users/{user:username}/edit', [UserController::class, "update"])->whereNumber("id");
        Route::delete('users/delete', [UserController::class, "delete"])->name("user.delete");
        Route::post('users/restore', [UserController::class, "restore"])->name("user.restore");
    });

    // user role
    Route::post('article/favorite', [ArticleController::class, "favorite"])->name("article.favorite");
    Route::post('article/comment-favorite', [ArticalCommentController::class, "favorite"])->name("article.comment.favorite");

});

Route::get("admin/login", [LoginController::class, "showLogin"])->name("login");
Route::post("admin/login", [LoginController::class, "login"]);


// front
Route::get('/', [FrontController::class, "home"])->name("home");
Route::get('/kategoriler/{category:slug}', [FrontController::class, "category"])->name("front.category");
Route::get('/@{user:username}/{article:slug}', [FrontController::class, "articleDetail"])->name("front.articleDetail");
Route::post("{article:id}/makale-yorum", [FrontController::class, "articleComment"])->name("article.comment");

// login

Route::post("/logout", [LoginController::class, "logout"])->name("logout");

// register
Route::get("/register", [LoginController::class, "showRegister"])->name("register");
Route::post("/register", [LoginController::class, "register"]);

Route::get("/login", [LoginController::class, "showLoginUser"])->name("user.login");
Route::post("/login", [LoginController::class, "loginUser"]);

// mail
Route::get("/auth/verify/{token}", [LoginController::class, "verify"])->name("verify-token");
// google
Route::get('auth/{driver}/callback', [LoginController::class, "socialVerify"])->name("socialVerify");
Route::get('auth/{driver}', [LoginController::class, "socialLogin"])->name("socialLogin");