{{--
    //Bilgi
    *Email icin external css kullanilamaz. Hepsi internal yani burada yazilmasi gerek!
--}}

<h1>Dogrulama Emaili</h1>

<span>
    Lutfen asagidaki linkten email adresinizi dogrulayiniz.
</span>

<br>

<a href="{{ route('verify-token', ['token' => $token]) }}">Mailimi dogrula</a>
