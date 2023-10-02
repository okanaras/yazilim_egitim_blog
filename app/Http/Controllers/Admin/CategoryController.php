<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with(["parentCategory:id,name", 'user'])->orderBy("order", "DESC")->get();

        return view("admin.categories.list", ['list' => $categories]);
    }

    public function create()
    {
        return view("admin.categories.create-update");
    }
}