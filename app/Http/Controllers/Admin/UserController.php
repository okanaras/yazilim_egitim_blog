<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $list = User::paginate(10);
        return view("admin.users.list", compact("list"));
    }
    public function create()
    {
        return view("admin.users.create-update");
    }

    public function store(Request $request)
    {
        $data = $request->except("_token");
        $data['password'] = bcrypt($data['password']);
        User::create($data);

        alert()
            ->success('Basarili', "Kullanici Olusturuldu!")
            ->showConfirmButton('Tamam', '#3085d6')
            ->autoClose(5000);

        return redirect()->route("user.index");
    }

    public function edit(Request $request)
    {
        // dd($request->all());

        $user = User::findOrFail($request->id);
        return view("admin.users.create-update", compact("user"));
    }

    public function update(Request $request)
    {
        dd($request->all());
    }

    public function delete(Request $request)
    {
        dd($request->all());
    }

}