<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;



class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with(["parentCategory:id,name", 'user'])
            ->orderBy("order", "DESC")
            ->paginate(5);
        // ->get();

        return view("admin.categories.list", ['list' => $categories]);
    }

    public function create()
    {
        return view("admin.categories.create-update");
    }

    public function changeStatus(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer', "exists:categories"]
        ]);

        $categoryID = $request->id;


        $category = Category::where("id", $categoryID)->first();

        $oldStatus = $category->status;

        $category->status = !$category->status;
        $category->save();

        $statusText = " statusu " . ($oldStatus == 1 ? " Aktif" : " Pasif") . "'ten " . ($category->status == 1 ? " Aktif" : " Pasif") . "'e ";

        alert()
            ->success('Basarili', $category->name . $statusText . ' guncellendi')
            ->showConfirmButton('Tamam', '#3085d6')
            ->autoClose(5000);

        return redirect()->route("category.index");

    }
    public function changeFeatureStatus(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer', "exists:categories"]
        ]);

        $categoryID = $request->id;


        $category = Category::where("id", $categoryID)->first();

        $oldStatus = $category->feature_status;

        $category->feature_status = !$category->feature_status;
        $category->save();

        $statusText = " feature status degeri " . ($oldStatus == 1 ? " Aktif" : " Pasif") . "'ten " . ($category->feature_status == 1 ? " Aktif" : " Pasif") . "'e ";

        alert()
            ->success('Basarili', $category->name . $statusText . ' guncellendi')
            ->showConfirmButton('Tamam', '#3085d6')
            ->autoClose(5000);

        return redirect()->route("category.index");

    }

    public function delete(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer', "exists:categories"]
        ]);

        $categoryID = $request->id;

        Category::where("id", $categoryID)->delete();

        $statusText = "Kategori silindi! ";

        alert()
            ->success('Basarili', $statusText)
            ->showConfirmButton('Tamam', '#3085d6')
            ->autoClose(5000);

        return redirect()->route("category.index");
    }

    public function edit(Request $request)
    {
        $categoryID = $request->id;

        $category = Category::where("id", $categoryID)->first();

        if (is_null($category)) {
            alert()
                ->error('Hata', "Kategori Bulunamadi!")
                ->showConfirmButton('Tamam', '#3085d6')
                ->autoClose(5000);
            return redirect()->route('category.index');
        }

        return view("admin.categories.create-update", compact("category"));
    }
}