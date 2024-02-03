<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailTheme;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    public function themes()
    {
        $list = EmailTheme::with("user")->paginate(10);

        return view("admin.email.list", compact("list"));
    }
    public function create()
    {
        return view("admin.email.create-update");
    }
    public function store(Request $request)
    {
        $request->validate([
            'theme_type' => ['required'],
            'process' => ['required'],
        ]);

        $themeType = $request->theme_type;

        // themeType'i 1 ise eger
        if ($themeType == 1) {
            $data = $request->except(['_token', 'passwordResetMail']);
            $data['body'] = json_encode($data['custom_content']);
            unset($data['custom_content']);
        } else if ($themeType == 2) {
            $data = $request->except(['_token', 'custom_content']);
            $data['body'] = json_encode($data['passwordResetMail']);
            unset($data['passwordResetMail']);

        }

        $data['user_id'] = auth()->id();

        EmailTheme::create($data);

        alert()
            ->success('Basarili', "Email Temasi Olusturuldu !")
            ->showConfirmButton('Tamam', '#3085d6')
            ->autoClose(5000);

        return redirect()->route("admin.email-themes");
    }

    public function edit()
    {
        // Your code here
    }
    public function update()
    {
        // Your code here
    }
}
