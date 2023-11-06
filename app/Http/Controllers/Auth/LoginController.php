<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserStoreRequest;
use App\Models\User;
use App\Models\UserVerify;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

use function PHPUnit\Framework\isNull;

class LoginController extends Controller
{
    public function showLogin()
    {
        return view("auth.login");
    }

    public function showLoginUser()
    {
        return view("front.auth.login");
    }

    public function showRegister()
    {
        return view("front.auth.register");
    }

    public function login(LoginRequest $request)
    {
        $email = $request->email;
        $password = $request->password;
        $remember = $request->remember;
        !is_null($remember) ? $remember = true : $remember = false;

        $user = User::where("email", $email)->first(); // ->where("status",1)

        if ($user && Hash::check($password, $user->password)) {
            Auth::login($user, $remember);
            $userIsAdmin = Auth::user()->is_admin;

            if (!$userIsAdmin) {
                return redirect()->route("home");
            }
            // Auth::loginUsingId($user->id);
            return redirect()->route("admin.index");
        } else {
            return redirect()
                ->route('login')
                ->withErrors([
                    'email' => "Verdiginiz bilgilerle eslesen bir kullanici bulunamadi"
                ])
                ->onlyInput("email", "remember");
        }

        // dd($request->all());
    }
    public function login2(LoginRequest $request)
    {
        $email = $request->email;
        $password = $request->password;
        $remember = $request->remember;

        !is_null($remember) ? $remember = true : $remember = false;

        if (Auth::attempt(['email' => $email, 'password' => $password], $remember)) {
            return redirect()->route("admin.index");
        } else {
            return redirect()
                ->route('login')
                ->withErrors([
                    'email' => "Verdiginiz bilgilerle eslesen bir kullanici bulunamadi"
                ])
                ->onlyInput("email", "remember");
        }
    }
    public function login3(LoginRequest $request)
    {
        $email = $request->email;
        $password = $request->password;
        $remember = $request->remember;

        !is_null($remember) ? $remember = true : $remember = false;

        if (Auth::attempt(['email' => $email, 'password' => $password, "status" => 1], $remember)) {
            return redirect()->route("admin.index");
        } else {
            return redirect()
                ->route('login')
                ->withErrors([
                    'email' => "Verdiginiz bilgilerle eslesen bir kullanici bulunamadi"
                ])
                ->onlyInput("email", "remember");
        }
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            $is_admin = Auth::user()->is_admin;
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            if (!$is_admin) {
                return redirect()->route("home");
            }

            return redirect()->route("login");
        }
    }


    public function register(UserStoreRequest $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);

        $user->status = 0;
        $user->save();

        $token = Str::random("60");

        // kayit sirasinda maili dogrulamak icin token olusturup userVerify'a ekliyoruz. daha sonra mail gondertiyoruz
        UserVerify::create([
            'user_id' => $user->id,
            'token' => $token
        ]);
        Mail::send("email.verify", compact('token'), function ($mail) use ($user) {
            $mail->to($user->email);
            $mail->subject('Dogrulama Emaili');
            //mail->from()
        });

        alert()
            ->success('Basarili', "Mail onayi icin adresinize link gonderildi. Posta kutunuzu kontrol ediniz!")
            ->showConfirmButton('Tamam', '#3085d6')
            ->autoClose(5000);

        return redirect()->back();
    }


    public function verify(Request $request, $token)
    {
        $verifyQuery = UserVerify::query()->where('token', $token);
        $find = $verifyQuery->first();

        if (!is_null($find)) {
            $user = $find->user;

            if (is_null($user->email_verified_at)) {
                $user->email_verified_at = now();
                $user->status = 1;
                $user->save();
                $verifyQuery->delete();
                $message = 'Emailiniz dogrulandi';
            } else {
                $message = 'Emailiniz zaten dogrulanmis! Giris yapabilirsiniz.';
            }

            alert()
                ->success('Basarili', $message)
                ->showConfirmButton('Tamam', '#3085d6')
                ->autoClose(5000);
            return redirect()->route('login');

        } else {
            abort(404);
        }
    }


    public function socialLogin($driver)
    {
        return Socialite::driver($driver)->redirect();
    }

    public function socialVerify($driver)
    {
        $user = Socialite::driver($driver)->user();
        // user varsa login et kayderme
        $userCheck = User::where('email', $user->getEmail())->first();
        if (!is_null($userCheck)) {
            Auth::login($userCheck);
            return redirect()->route('home');
        }

        // user yoksa
        $username = Str::slug($user->getName());
        $userCreate = User::create([
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'password' => bcrypt(''),
            'username' => is_null($this->checkUsername($username)) ? $username : $username . uniqid(),
            'status' => 1,
            'email_verified_at' => now(),
            $driver . '_id' => $user->getId(),
        ]);

        // kaydi yapip user girisi yaptirdik ve home yonlendirdik
        Auth::login($userCreate);
        return redirect()->route('home');
    }

    public function checkUsername(string $username): null|object
    {
        return User::query()->where('username', $username)->first();
    }
}