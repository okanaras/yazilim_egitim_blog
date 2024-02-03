<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    public function verifyShow()
    {
        return view("admin.email.verify");
    }
    public function verify(Request $request)
    {
        dd($request->all());
    }
}