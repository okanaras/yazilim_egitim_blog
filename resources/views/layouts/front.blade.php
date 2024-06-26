<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- ajax csrf token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @stack("meta")

    <title>@yield('title', 'Yazilim Egitim Blog')</title>

    <link rel="stylesheet" href="{{ asset('assets/front/css/bootstrap.min.css') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <link href="{{ asset('assets/front/material-icons/iconfont/material-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/front/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/front/swiper/swiper-bundle.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/front/aos/aos.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/highlight/styles/androidstudio.css') }}">

    {{-- <link rel="stylesheet" href="{{ asset('assets/front/css/highlighter-default.min.css') }}"> --}}

    <link rel="stylesheet" href="{{ asset('assets/front/css/style.css') }}">

    @yield('css')
</head>

<body>
    <!-- header -->
    <header class="bg-white shadow-sm">
        <div class="container">
            <div class="header-top d-flex justify-content-between align-items-center header-border header-h">
                <div class="header-logo">
                    <a href="{{ route('home') }}">
                        <img src="{{ isset($settings->logo) ? asset($settings->logo) : asset('assets/front/image/logo.png') }}"
                            class="logo-h img-fluid">
                    </a>
                </div>
                <div class="header-text d-none d-md-block">
                    @isset($settings)
                        {!! $settings->header_text !!}
                    @endisset
                    {{-- <p class="text-center text-secondary text-muted fst-italic">Lorem ipsum dolor sit amet consectetur
                        adipisicing.</p> --}}
                </div>
                <div class="header-search">
                    <span class="material-icons" id="searchIcon1">
                        search
                    </span>
                    <form action="{{ route('front.search') }}" class="position-relative" style="display: none;" id="searchForm">
                        <input type="text" name="q" id="search_text" placeholder="Ara...">
                        <span class="material-icons position-absolute" onclick="$(#searchForm).submit()" id="searchIcon2"
                            style="right: 0; top: 0; bottom: 0;">
                            search
                        </span>
                    </form>
                </div>
            </div>
            <div class="header-bottom">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link {{ Route::is('home') ? 'active' : '' }}" aria-current="page" href="{{ route('home') }}">Anasayfa</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Route::is('front.articleList') ? 'active' : '' }}" href="{{route('front.articleList')}}">Makaleler</a>
                            </li>
                        </ul>

                        {{-- kullanici auth kontrol --}}
                        @auth
                            {{-- Giris Kayit butonlari --}}
                            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                                <li class="nav-item">
                                    <a class="nav-link d-flex me-1 text-orange" href="javascript:void(0)">
                                        <i class="fa fa-user me-1 d-flex align-items-center "></i>
                                        {{ auth()->user()->username }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link d-flex me-1 text-orange" href="javascript:void(0)"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fa fa-close me-1 d-flex align-items-center "></i>
                                        Cikis Yap</a>
                                    <form action="{{ route('logout') }}" method="POST" id="logout-form">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        @else
                            {{-- Giris Kayit butonlari --}}
                            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                                <li class="nav-item">
                                    <a class="nav-link d-flex me-1 text-orange" href="{{ route('register') }}">
                                        <span class="material-icons">app_registration</span>
                                        Kayit
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link d-flex me-1 text-orange" href="{{ route('user.login') }}">
                                        <span class="material-icons">how_to_reg</span>
                                        Giris
                                    </a>
                                </li>
                            </ul>
                        @endauth

                    </div>
                </nav>
            </div>
        </div>
    </header>

    <!-- content -->
    <div class="container">

        @yield('container-top')

        <main class="mt-5">
            <div class="row">
                <!-- left aside -->
                <div class="col-md-9">
                    @yield('content')
                </div>

                <!-- right aside  -->
                <div class="col-md-3">
                    <!-- kategoriler -->
                    <section class="categories bg-white shadow-sm">
                        <h4 class="bg-light text-secondary p-3 border-bottom border-1 border-light">Kategoriler</h4>

                        <ul class="list-group m-0" id="categoryCollapse">
                            @foreach ($categories as $category)
                                @if($category->childCategories->count())
                                    <li class="px-3 py-3">
                                        <a href="javascript:void(0)" class="btn-category-accordion" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $category->id }}">
                                            {{ $category->name }}
                                            <span class="float-end me-3"><i class="fa fa-chevron-down"></i></span>
                                        </a>
                                    </li>

                                    <div id="collapse-{{ $category->id}}" data-bs-parent="#categoryCollapse" class="accordion-collapse collapse">
                                        @foreach ($category->childCategories as $childCategory)
                                            <li class="px-3 py-3 bg-sub-category">
                                                <a href="{{ route('front.categoryArticles', ['category' => $childCategory->slug]) }}">
                                                    {{ $childCategory->name }}
                                                    <span class="float-end me-3" style="color: {{ $childCategory->color }}">&#x25CF;</span>
                                                </a>
                                            </li>
                                        @endforeach
                                    </div>
                                    @else
                                        <li class="px-3 py-3">
                                            <a href="{{ route('front.categoryArticles', ['category' => $category->slug]) }}">
                                                {{ $category->name }}
                                                <span class="float-end me-3" style="color: {{ $category->color }}">&#x25CF;</span>
                                            </a>
                                        </li>
                                    @endif
                            @endforeach
                        </ul>
                    </section>

                    @if (isset($settings) && $settings->video_is_active)
                        <!-- youtube swiper -->
                        <section class="youtube-video">
                            <div class="swiper-youtube mt-4">
                                <h2 class="font-montserrat fw-semibold">Videolar</h2>
                                <div class="swiper-wrapper ">
                                    <!-- Slides -->
                                    <div class="swiper-slide">
                                        <iframe width="100%"
                                            src="https://www.youtube.com/embed/jFafxhyvG1g?list=PLUEXSxNAoEX_KLv9YTi5Gp4uZj1nZax0H"
                                            title="Laravel Dersleri: 57 - YEBP: Front-end Anasayfa Tasarımı : 5"
                                            frameborder="0"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                            allowfullscreen></iframe>

                                    </div>
                                    <div class="swiper-slide">
                                        <iframe width="100%"
                                            src="https://www.youtube.com/embed/jFafxhyvG1g?list=PLUEXSxNAoEX_KLv9YTi5Gp4uZj1nZax0H"
                                            title="Laravel Dersleri: 57 - YEBP: Front-end Anasayfa Tasarımı : 5"
                                            frameborder="0"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                            allowfullscreen></iframe>

                                    </div>
                                </div>

                                <!-- swiper next-back button -->
                                <div class="most-popular-swiper-navigation text-end">
                                    <span
                                        class="btn btn-secondary btn-sm  material-icons youtube-swiper-button-prev">arrow_back</span>
                                    <span
                                        class="btn btn-secondary btn-sm  material-icons youtube-swiper-button-next">arrow_forward</span>
                                </div>
                            </div>
                        </section>
                    @endif

                    @if (isset($settings) && $settings->author_is_active)
                        <!-- author swiper -->
                        <section class="authors mt-1">
                            <div class="swiper-authors">
                                <h2 class="font-montserrat fw-semibold">Yazarlar</h2>
                                <div class="swiper-wrapper ">
                                    <!-- Slides -->
                                    <div class="swiper-slide">
                                        <a href="#">
                                            <div
                                                style="
                                        background-image: url('https://via.placeholder.com/200x200');
                                        background-size: cover;
                                        background-repeat: no-repeat;
                                        background-position: center center;
                                        height: 200px;">
                                            </div>
                                            <div>Okan Aras</div>
                                        </a>
                                    </div>
                                    <div class="swiper-slide">
                                        <a href="#">
                                            <div
                                                style="
                                        background-image: url('https://via.placeholder.com/200x200');
                                        background-size: cover;
                                        background-repeat: no-repeat;
                                        background-position: center center;
                                        height: 200px;">
                                            </div>
                                            <div>Okan Aras</div>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- swiper next-back button -->
                            <div class="most-popular-swiper-navigation text-end">
                                <span
                                    class="btn btn-secondary btn-sm  material-icons authors-swiper-button-prev">arrow_back</span>
                                <span
                                    class="btn btn-secondary btn-sm  material-icons authors-swiper-button-next">arrow_forward</span>
                            </div>
                        </section>
                    @endif
                </div>
        </main>
    </div>

    <!-- footer -->
    <footer class="container-fluid mt-5 p-5 bg-white" style="border-top: 1px solid #eceff2;">
        <div class="container text-center">
            @php
                $text = '';
                if (isset($settings)) {
                    $text = str_replace('{copy}', '&copy', $settings->footer_text);
                    $text = str_replace('{copy}', date('Y'), $text);
                }
            @endphp
            <p>
                &copy 2023 Lorem ipsum dolor sit amet consectetur, adipisicing elit.
            </p>
        </div>
    </footer>

    <div class="position-fixed scroll-to-top btn btn-secondary btn-circle">
        <i class="fa fa-chevron-up"></i>
    </div>

    <!-- <script src="assets/front/js/bootstrap.bundle.min.js'"></script> -->
    <script src="{{ asset('assets/front/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/front/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/front/aos/aos.js') }}"></script>

    <script src="{{ asset('assets/front/js/highlight.min.js') }}"></script>

    <script src="{{ asset('assets/front/js/main.js') }}"></script>

    {{-- ajax setup --}}
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                }
            });
        });

        // accordion collapse show oldugundaki action
        $('.accordion-collapse').on('show.bs.collapse', function () {
            $(this).prev().find('.fa-chevron-down').addClass('fa-cehvron-up');
            $(this).prev().find('.fa-chevron-down').removeClass('fa-cehvron-down');
        });

        // accordion collapse hide oldugundaki action
        $('.accordion-collapse').on('hide.bs.collapse', function () {
            $(this).prev().find('.fa-chevron-up').addClass('fa-cehvron-down');
            $(this).prev().find('.fa-chevron-up').removeClass('fa-cehvron-up');
        });
    </script>

    @include('sweetalert::alert')
    @yield('js')

</body>

</html>
