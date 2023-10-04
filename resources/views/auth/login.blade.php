@extends('layouts.auth')

@section('title')
    Giris Yap
@endsection

@section('css') 
@endsection

@section('content')
<div class="app app-auth-sign-in align-content-stretch d-flex flex-wrap justify-content-end">
    <div class="app-auth-background"></div>
    <div class="app-auth-container">
        <div class="logo">
            <a href="index.html">Neptune</a>
        </div>
        <p class="auth-description">Please sign-in to your account and continue to the dashboard.<br>Don't have an
            account? <a href="sign-up.html">Sign Up</a></p>

            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger">{{$error}}</div>
                @endforeach
            @endif

        <form action="{{ route('login') }}" method="post">  
            @csrf
            <div class="auth-credentials m-b-xxl">
                <label for="signInEmail" class="form-label">Email</label>
                <input type="email" class="form-control m-b-md" id="signInEmail" aria-describedby="signInEmail"
                    placeholder="example@neptune.com" name="email" value="{{old('email')}}">

                <label for="signInPassword" class="form-label">Password</label>
                <input type="password" class="form-control" id="signInPassword" aria-describedby="signInPassword"
                    placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;" name="password">

                <div class="form-check mt-3">
                    <input class="form-check-input" type="checkbox" value="1" name="remember" id="remember" {{ old("remember") ? "checked" : ""}}>
                    <label class="form-check-label" for="remember">
                        Beni Hatirla
                    </label>
                </div>
            </div>
        
            <div class="auth-submit">
                <button type="submit" class="btn btn-primary">Giris Yap</button>
                <a href="#" class="auth-forgot-password float-end">Forgot password?</a>
            </div>
        </form>
        <div class="divider"></div>
        <div class="auth-alts">
            <a href="#" class="auth-alts-google"></a>
            <a href="#" class="auth-alts-facebook"></a>
            <a href="#" class="auth-alts-twitter"></a>
        </div>
    </div>
</div>
@endsection

@section('js') 
@endsection