{{--
    //Bilgi
    *Email icin external css kullanilamaz. Hepsi internal yani burada yazilmasi gerek!
--}}

<h1>Dogrulama Emaili</h1>

<p>
    Merhaba {{ $user->name }}, hosgeldiniz.
</p>

<p>
    Lutfen asagidaki linkten email adresinizi dogrulayiniz.
</p>

<br>
<a href="{{ route('verify-token', ['token' => $token]) }}">Mailimi dogrula</a>
