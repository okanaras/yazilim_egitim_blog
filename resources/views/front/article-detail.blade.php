@extends('layouts.front')

@section('title')
@endsection

@section('css')
@endsection

@section('content')
    <!-- makale detail -->
    <section class="row">
        <!-- makale content -->
        <div class="col-12 bg-white rounded-1 shadow-sm">
            <div class="article-wrapper">
                <div class="article-header font-lato d-flex justify-content-between pb-4">
                    <div class="article-header-date">
                        @php
                            $publishDate = \Illuminate\Support\Carbon::parse($article->publish_date)->format('d-m-Y');
                        @endphp
                        <time datetime="{{ $publishDate }}">{{ $publishDate }}</time>
                        @foreach ($article->getAttribute('tags') as $tag)
                            @php
                                $class = ['text-danger', 'text-primary', 'text-warning', 'text-info', 'text-secondary', 'text-succes', 'text-dark'];
                                $randomClass = $class[random_int(0, 6)];

                            @endphp
                            <span class="{{ $randomClass }}">{{ $tag }}</span>
                        @endforeach
                    </div>
                    <div class="article-header-author">
                        Yazar: <a href="#"><strong>{{ $article->user->name }}</strong></a>
                    </div>

                </div>
                <div class="article-content mt-4">
                    <h1 class="fw-bold mb-4">{{ $article->title }}</h1>
                    <div class="d-flex justify-content-center">
                        <img src="{{ asset($article->image) }}" class="w-75 img-fluid rounded-1">
                    </div>
                    <div class="text-secondary mt-5">
                        {!! $article->body !!}
                    </div>
                </div>
            </div>
        </div>
        <!-- authors, reply and like button -->
        <section class="col-12 mt-4">
            <!-- like ve yorum button -->
            <div class="article-items d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <a href="javascript:void(0)" class="favorite-article me-2">
                        <span class="material-icons-outlined">favorite</span>
                    </a>
                    <span class="fw-light">100</span>
                </div>
                <a href="javascript:void(0)" class="btn-response" id="btnArticleResponse">Cevap Ver</a>
            </div>

            <!-- author info -->
            <div class="article-authors mt-5">
                <div class="bg-white p-4 d-flex justify-content-between align-items-center shadow-sm">
                    <img src="{{ asset($article->user->image) }}" alt="" width="75" height="75">
                    <div class="px-5 me-auto">
                        <h4 class="mt-3"><a href="">{{ $article->user->name }}</a></h4>
                        {{ $article->user->about }}
                    </div>
                </div>
            </div>
        </section>

        <!-- makale formu ve yorumlar  -->
        <section class="article-responses mt-4">
            <!-- makale yorum formu -->
            <div class="response-form bg-white shadow-sm rounded-1 p-4" style="display: none;">
                <form action="{{ route('article.comment', ['article' => $article->id]) }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <h5>Cevabiniz</h5>
                            <hr>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="name" class="form-control" placeholder="Adiniz" required>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="email" class="form-control" placeholder="Email Adresi" required>
                        </div>
                        <div class="col-12 mt-3">
                            <textarea name="comment" id="comment" cols="30" rows="5" class="form-control" placeholder="Mesajiniz"></textarea>
                        </div>
                        <div class="col-md-4">
                            <button class="btn-response align-items-md-center d-flex mt-3">
                                <span class="material-icons-outlined me-2">send</span>
                                Gonder
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- makale yorumlar -->
            <div class="response-body p-4">
                <h3>Makaleye Verilen Yorumlar</h3>
                <hr class="mb-4">
                <!-- yorumlar -->
                <div class="article-response-wrapper">
                    <!-- yorum -->
                    <div
                        class="article-response bg-white mt-3 p-2 d-flex justify-content-between align-items-center shadow-sm">
                        <img src="assets/front/image/profile1.png" alt="" width="75" height="75">
                        <div class="px-3">
                            <div class="comment-title-date d-flex justify-content-between">
                                <h4><a href="">Okan Aras</a></h4>
                                <time datetime="09-10-2023">09-10-2023</time>
                            </div>
                            <p class="text-secondary">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Fuga et,
                                facilis,
                                qui maxime id reiciendis nihil tenetur obcaecati minus quibusdam
                                nostrum!
                                Incidunt a odit omnis!
                            </p>
                            <div class="text-end d-flex align-items-center justify-content-between">
                                <div>
                                    <a href="javascript:void(0)" class="btn-response btnArticleResponse">Cevap Ver</a>
                                </div>
                                <div class="d-flex align-items-center">
                                    <a href="javascript:void(0)" class="like-comment">
                                        <span class="material-icons">thumb_up</span>
                                    </a>
                                    <a href="javascript:void(0)" class="like-comment">
                                        <span class="material-icons-outlined">thumb_up_off_alt</span>
                                    </a> 12
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- yorumlara yorum -->
                    <div class="articles-response-comment-wrapper">
                        <!-- yoruma yorum -->
                        <div
                            class="article-response-comment bg-white mt-3 p-2 d-flex justify-content-between align-items-center shadow-sm">
                            <img src="assets/front/image/profile1.png" alt="" width="75" height="75">
                            <div class="px-3">
                                <div class="comment-title-date d-flex justify-content-between">
                                    <h4><a href="">Okan Aras</a></h4>
                                    <time datetime="09-10-2023">09-10-2023</time>
                                </div>
                                <p class="text-secondary">
                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Fuga et,
                                    facilis,
                                    qui maxime id reiciendis nihil tenetur obcaecati minus quibusdam
                                    nostrum!
                                    Incidunt a odit omnis!
                                </p>
                                <div class="text-end d-flex align-items-center justify-content-between">
                                    <div>
                                        <a href="javascript:void(0)" class="btn-response btnArticleResponse">Cevap
                                            Ver</a>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <a href="javascript:void(0)" class="like-comment">
                                            <span class="material-icons">thumb_up</span>
                                        </a>
                                        <a href="javascript:void(0)" class="like-comment">
                                            <span class="material-icons-outlined">thumb_up_off_alt</span>
                                        </a> 12
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- yorumun yorumuna yorum -->
                        <div
                            class="article-response-comment-in bg-white mt-3 p-2 d-flex justify-content-between align-items-center shadow-sm">
                            <img src="assets/front/image/profile1.png" alt="" width="75" height="75">
                            <div class="px-3">
                                <div class="comment-title-date d-flex justify-content-between">
                                    <h4><a href="">Okan Aras</a></h4>
                                    <time datetime="09-10-2023">09-10-2023</time>
                                </div>
                                <p class="text-secondary">
                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Fuga et,
                                    facilis,
                                    qui maxime id reiciendis nihil tenetur obcaecati minus quibusdam
                                    nostrum!
                                    Incidunt a odit omnis!
                                </p>
                                <div class="text-end d-flex align-items-center justify-content-between">
                                    <div>
                                        <a href="javascript:void(0)" class="btn-response btnArticleResponse">Cevap
                                            Ver</a>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <a href="javascript:void(0)" class="like-comment">
                                            <span class="material-icons">thumb_up</span>
                                        </a>
                                        <a href="javascript:void(0)" class="like-comment">
                                            <span class="material-icons-outlined">thumb_up_off_alt</span>
                                        </a> 12
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2.yorum -->
                <div class="article-response-wrapper">
                    <!-- yorum -->
                    <div
                        class="article-response bg-white mt-3 p-2 d-flex justify-content-between align-items-center shadow-sm">
                        <img src="assets/front/image/profile1.png" alt="" width="75" height="75">
                        <div class="px-3">
                            <div class="comment-title-date d-flex justify-content-between">
                                <h4><a href="">Okan Aras</a></h4>
                                <time datetime="09-10-2023">09-10-2023</time>
                            </div>
                            <p class="text-secondary">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Fuga et,
                                facilis,
                                qui maxime id reiciendis nihil tenetur obcaecati minus quibusdam
                                nostrum!
                                Incidunt a odit omnis!
                            </p>
                            <div class="text-end d-flex align-items-center justify-content-end">
                                <a href="javascript:void(0)" class="like-comment">
                                    <span class="material-icons">thumb_up</span>
                                </a>
                                <a href="javascript:void(0)" class="like-comment">
                                    <span class="material-icons-outlined">thumb_up_off_alt</span>
                                </a> 12
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3.yorum -->
                <div class="article-response-wrapper">
                    <!-- yorum -->
                    <div
                        class="article-response bg-white mt-3 p-2 d-flex justify-content-between align-items-center shadow-sm">
                        <img src="assets/front/image/profile1.png" alt="" width="75" height="75">
                        <div class="px-3">
                            <div class="comment-title-date d-flex justify-content-between">
                                <h4><a href="">Okan Aras</a></h4>
                                <time datetime="09-10-2023">09-10-2023</time>
                            </div>
                            <p class="text-secondary">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Fuga et,
                                facilis,
                                qui maxime id reiciendis nihil tenetur obcaecati minus quibusdam
                                nostrum!
                                Incidunt a odit omnis!
                            </p>
                            <div class="text-end d-flex align-items-center justify-content-end">
                                <a href="javascript:void(0)" class="like-comment">
                                    <span class="material-icons">thumb_up</span>
                                </a>
                                <a href="javascript:void(0)" class="like-comment">
                                    <span class="material-icons-outlined">thumb_up_off_alt</span>
                                </a> 12
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
@endsection

@section('js')
@endsection
