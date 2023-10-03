<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryStoreRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;



class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with(["parentCategory:id,name", 'user'])
            ->orderBy("order", "DESC")
            ->paginate(5); //5er 5er veri gosterilmesi
        // ->get();

        return view("admin.categories.list", ['list' => $categories]);
    }

    public function create()
    {
        $categories = Category::all();

        return view("admin.categories.create-update", compact("categories"));
    }

    public function store(CategoryStoreRequest $request)
    {
        $slug = Str::slug($request->slug);
        try {
            $category = new Category;
            $category->name = $request->name;
            $category->slug = is_null($this->slugCheck($slug)) ? $slug : Str::slug($slug . time());
            $category->description = $request->description;
            $category->status = $request->status ? 1 : 0;
            $category->parent_id = $request->parent_id;
            $category->feature_status = $request->feature_status ? 1 : 0;
            $category->seo_keywords = $request->seo_keywords;
            $category->seo_description = $request->seo_description;
            $category->user_id = random_int(1, 10);
            $category->order = $request->order;
            $category->save();
        } catch (\Exception $exception) {
            abort(404, $exception->getMessage());
        }


        alert()
            ->success('Basarili', 'Kayit Kaydedildi!')
            ->showConfirmButton('Tamam', '#3085d6')
            ->autoClose(5000);
        return redirect()->back();
    }
    public function slugCheck(string $text)
    {
        return Category::where("id", $text)->first();
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
        $categories = Category::all();

        $categoryID = $request->id;

        $category = Category::where("id", $categoryID)->first();

        if (is_null($category)) {
            alert()
                ->error('Hata', "Kategori Bulunamadi!")
                ->showConfirmButton('Tamam', '#3085d6')
                ->autoClose(5000);
            return redirect()->route('category.index');
        }

        return view("admin.categories.create-update", compact("category", "categories"));
    }

    public function update(CategoryStoreRequest $request)
    {
        $slug = Str::slug($request->slug);
        $slugCheck = $this->slugCheck($slug);

        $category = Category::find($request->id);
        $category->name = $request->name;

        if ((!is_null($slugCheck) && $slugCheck->id == $category->id) || is_null($slugCheck)) {
            $category->slug = $slug;
        } elseif (!is_null($slugCheck) && $slugCheck->id != $category->id) {
            $category->slug = Str::slug($slug . time());
        } else {
            $category->slug = Str::slug($slug . time());
        }


        $category->slug = is_null($slugCheck) ? $slug : Str::slug($slug . time());
        $category->description = $request->description;
        $category->status = $request->status ? 1 : 0;
        $category->parent_id = $request->parent_id;
        $category->feature_status = $request->feature_status ? 1 : 0;
        $category->seo_keywords = $request->seo_keywords;
        $category->seo_description = $request->seo_description;
        $category->user_id = random_int(1, 10);
        // $category->order = $request->order;

        $category->save();

        alert()
            ->success('Basarili', 'Kayit Guncellendi!')
            ->showConfirmButton('Tamam', '#3085d6')
            ->autoClose(5000);
        return redirect()->route('category.index');
    }
}