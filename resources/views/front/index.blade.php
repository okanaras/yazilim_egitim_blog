@extends('layouts.front')

@section('title')
@endsection

@section('css')
@endsection

@section('container-top')
    @if (isset($settings) && $settings->feature_categories_is_active)
        <!-- one cikarilan articles -->
        <section class="feature-categories mt-4">
            <div class="row">
                @foreach ($mostPopularCategories as $category)
                    <div class="col-6 col-md-3 p-3 most-popular-category-wrapper" data-aos="fade-down-left" data-aos-duration="1000" data-aos-easing="ease-in-out" onclick="window.location.href='{{ route('front.categoryArticles', ['category' => $category->slug]) }}'" >

                        <div class="d-flex justify-content-center align-items-center shadow-sm most-popular-category" style="height:300px; background-color: {{ $category->color }}; border-radius:10px;">
                            <div class="w-75">
                                <div class="d-flex justify-content-center">
                                    <img src="{{ imageExist($category->image, $settings->category_default_image) }}" alt="category image" class="img-fluid" style="width: 90px">
                                </div>
                                <div class="text-center text-secondary mt-3 border-1 border-secondary border-top mt-4 pt-2"><h2>{{ $category->name }}</h2></div>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>
        </section>
    @endif
@endsection

@section('content')
    <!-- populer articles title -->
    <section class="most-popular row" data-aos="zoom-in-up" data-aos-duration="2000" data-aos-easing="ease-in-out">
        <div class="populer-title col-md-8 p-0">
            <h2 class="font-montserrat fw-semibold">En Cok Okunan Makaleler</h2>
        </div>
        <!-- swiper next-back button -->
        <div class="col-4">
            <div class="most-popular-swiper-navigation text-end">
                <span class="btn btn-secondary material-icons most-popular-swiper-button-prev">arrow_back</span>
                <span class="btn btn-secondary material-icons most-popular-swiper-button-next">arrow_forward</span>
            </div>
        </div>
        <!-- populer articles content -->
        <div class="col-12">
            <div class="swiper-most-popular mt-3">
                <div class="swiper-wrapper ">
                    <!-- Slides -->
                    @foreach ($mostPopularArticles as $article)
                        <div class="swiper-slide">
                            <a href="{{ route('front.articleDetail', [
                                'user' => $article->user->username,
                                'article' => $article->slug
                                ]) }}">
                                <img src="{{ imageExist($article->image, $settings->article_default_image) }}" class="img-fluid">
                            </a>
                            <div class="most-popular-body mt-2">
                                <div class="most-popular-author most-popular-author d-flex justify-content-between">
                                    <div>Yazar: <a href="{{ route('front.authorArticles', ['user' => $article->user->username]) }}">{{ $article->user->name }}</a></div>
                                    <div class="text-end">Kategori: <a href="{{ route('front.categoryArticles', ['category' => $article->category->slug]) }}">{{ $article->category->name }}</a></div>
                                </div>
                                <div class="most-popular-title">
                                    <h4 class="text-black">
                                        <a href="{{ route('front.articleDetail', [
                                            'user' => $article->user->username,
                                            'article' => $article->slug
                                            ]) }}">{{ $article->title }}</a>
                                    </h4>
                                </div>
                                <div class="most-popular-date">
                                    <span>{{ $article->format_publish_date }}</span> &#x25CF; <span>10 dk</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- telegram -->
    <section class="telegram d-flex align-items-center mt-5 p-4 rounded-2 text-white">
        <div class="me-4">
            <span class="material-icons text-black">send</span>
        </div>
        <div class="telegram body">
            <h4>Telegram grubumuza katilmayi unutma!</h4>
            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Aliquam, libero quidem.</p>
            <a href="{{ isset($settings) ? $settings->telegram_link : 'javascript:void(0)' }}" target="blank"
                class="btn btn-warning p-3 text-black">Telegrama Katil</a>
        </div>
    </section>

    <!-- son eklenen makaleler -->
    <section class="articles row mt-5" data-aos="flip-left" data-aos-duration="2000" data-aos-easing="ease-out-cubic">
        <div class="populer-title col-md-12 p-0">
            <h2 class="font-montserrat fw-semibold">Son Makaleler</h2>
        </div>
        @foreach ($lastPublishedArticles as $article)
            <div class="col-md-4 mt-4">
                <a href="{{ route('front.articleDetail', ['user' => $article->user->username, 'article' => $article->slug]) }}">
                    <img src="{{ imageExist($article->image, $settings->article_default_image) }}" class="img-fluid">
                </a>
                <div class="most-popular-body mt-2">
                    <div class="most-popular-author most-popular-author d-flex justify-content-between">
                        <div>Yazar: <a href="{{ route('front.authorArticles', ['user' => $article->user->username]) }}">{{ $article->user->name }}</a></div>
                        <div class="text-end">Kategori: <a href="{{ route('front.categoryArticles', ['category' => $article->category->slug]) }}">{{ $article->category->name }}</a></div>
                    </div>
                    <div class="most-popular-title">
                        <h4 class="text-black">
                            <a href="{{ route('front.articleDetail', [
                                            'user' => $article->user->username,
                                            'article' => $article->slug
                                            ]) }}">{{ $article->title }}</a>
                        </h4>
                    </div>
                    <div class="most-popular-date">
                        <span>{{ $article->format_publish_date }}</span> &#x25CF; <span>10 dk</span>
                    </div>
                </div>
            </div>
        @endforeach
    </section>
@endsection

@push('meta')
    <meta name="keyword" content="{{ $settings->seo_keywords_home }}">
    <meta name="description" content="{{ $settings->seo_description_home }}">
    <meta name="author" content="Yazilim Egitim">
@endpush

@section('js')
@endsection
