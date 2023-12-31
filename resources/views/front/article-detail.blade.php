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
                        @php
                            $tags = explode(',', $article->tags);
                        @endphp
                        @foreach ($article->getAttribute('tagsToArray') as $tag)
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
                    <a href="javascript:void(0)" class="favorite-article me-2" id="favoriteArticle"
                        data-id="{{ $article->id }}" @if (!is_null($userLike)) style="color: red" @endif>
                        <span class="material-icons-outlined">favorite</span>
                    </a>
                    <span class="fw-light" id="favoriteCount">{{ $article->like_count }}</span>
                </div>
                <a href="javascript:void(0)" class="btn-response btnArticleResponse">Cevap Ver</a>
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
                    <input type="hidden" name="parent_id" id="comment_parent_id" value="{{ null }}">
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

                @foreach ($article->comments as $comment)
                    <!-- yorumlar -->
                    <div class="article-response-wrapper">
                        <!-- yorum -->
                        <div class="article-response bg-white mt-3 p-2 d-flex align-items-center shadow-sm">
                            <div class="col-md-2">
                                @php
                                    if ($comment->user) {
                                        $image = $comment->user->image;
                                        $name = $comment->user->name;
                                        if (!file_exists(public_path($image))) {
                                            $image = $settings->default_comment_profile_image;
                                        }
                                    } else {
                                        $image = $settings->default_comment_profile_image;
                                        $name = $comment->name;
                                    }
                                @endphp
                                <img src="{{ asset($image) }}" alt="" width="75" height="75">
                            </div>
                            <div class="col-md-10">
                                <div class="px-3">
                                    <div class="comment-title-date d-flex justify-content-between">
                                        <h4 class="mt-3"><a href="">{{ $name }}</a></h4>
                                        <time
                                            datetime="{{ \Carbon\Carbon::parse($comment->created_at)->format('d-m-Y') }}">
                                            {{ \Carbon\Carbon::parse($comment->created_at)->format('d-m-Y') }}
                                        </time>
                                    </div>
                                    <p class="text-secondary">
                                        {{ $comment->comment }}
                                    </p>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <a href="javascript:void(0)" class="btn-response btnArticleResponseComment"
                                                data-id="{{ $comment->id }}">Cevap Ver</a>
                                        </div>
                                        <div class="d-flex align-items-center ">
                                            @php
                                                $commentLike = $comment->commentLikes
                                                    ->where('user_id', auth()->id())
                                                    ->where('comment_id', $comment->id)
                                                    ->first();
                                            @endphp
                                            <a href="javascript:void(0)" class="like-comment me-1"
                                                data-id="{{ $comment->id }}"
                                                @if (!is_null($commentLike)) style="color:red" @endif>
                                                <span class="material-icons">thumb_up</span>
                                            </a>
                                            <span class="fw-light"
                                                id="commentLikeCount-{{ $comment->id }}">{{ $comment->like_count }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        @if ($comment->children)
                            <div class="articles-response-comment-wrapper">
                                @foreach ($comment->children as $child)
                                    @php
                                        if ($child->user) {
                                            $childImage = $child->user->image;
                                            $childName = $child->user->name;
                                            if (!file_exists(public_path($childImage))) {
                                                $childImage = $settings->default_comment_profile_image;
                                            }
                                        } else {
                                            $childImage = $settings->default_comment_profile_image;
                                            $childName = $child->name;
                                        }

                                    @endphp
                                    <!-- yoruma yorum -->
                                    <div
                                        class="article-comment bg-white p-2 mt-3 d-flex justify-content-between align-items-center shadow-sm">
                                        <div class="col-md-2">
                                            <img src="{{ asset($childImage) }}" alt="" width="75"
                                                height="75">
                                        </div>
                                        <div class="col-md-10">
                                            <div class="px-3">
                                                <div class="comment-title-date d-flex justify-content-between">
                                                    <h4 class="mt-3"><a href="">{{ $childName }}</a>
                                                    </h4>
                                                    <time
                                                        datetime="{{ \Carbon\Carbon::parse($child->created_at)->format('d-m-Y') }}">
                                                        {{ \Carbon\Carbon::parse($child->created_at)->format('d-m-Y') }}
                                                    </time>
                                                </div>
                                                <p class="text-secondary">
                                                    {{ $child->comment }}
                                                </p>
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="d-flex align-items-center ">
                                                        @php
                                                            $commentLikeChild = $child->commentLikes
                                                                ->where('user_id', auth()->id())
                                                                ->where('comment_id', $child->id)
                                                                ->first();
                                                        @endphp
                                                        <a href="javascript:void(0)" class="like-comment me-1"
                                                            data-id="{{ $child->id }}"
                                                            @if (!is_null($commentLikeChild)) style="color:red" @endif>
                                                            <span class="material-icons">thumb_up</span>
                                                        </a>
                                                        <span class="fw-light"
                                                            id="commentLikeCount-{{ $child->id }}">{{ $child->like_count }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </section>
    </section>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('#favoriteArticle').click(function() {
                @if (Auth::check())
                    let articleID = $(this).data('id');
                    console.log(articleID);
                    let self = $(this);

                    $.ajax({
                        method: "POST",
                        url: "{{ route('article.favorite') }}",
                        data: {
                            id: articleID
                        },
                        async: false,
                        success: function(data) {
                            if (data.process) {
                                self.css("color", "red")
                            } else {
                                self.css("color", "inherit")
                            }
                            $('#favoriteCount').text(data.like_count);
                        },
                        error: function() {
                            console.log("hata geldi");
                        }
                    });
                @else
                    Swal.fire({
                        title: "Bilgi",
                        text: "Kullanici girisi yapmadan favorilerinize alamazsiniz!",
                        confirmButtonText: "Tamam",
                        icon: "info"
                    });
                @endif
            });
            $('.like-comment').click(function() {
                @if (Auth::check())
                    let id = $(this).data('id');
                    console.log(id);
                    let self = $(this);

                    $.ajax({
                        method: "POST",
                        url: "{{ route('article.comment.favorite') }}",
                        data: {
                            id: id
                        },
                        async: false,
                        success: function(data) {
                            if (data.process) {
                                self.css("color", "red")
                            } else {
                                self.css("color", "inherit")
                            }
                            $('#commentLikeCount-' + id).text(data.like_count);
                        },
                        error: function() {
                            console.log("hata geldi");
                        }
                    });
                @else
                    Swal.fire({
                        title: "Bilgi",
                        text: "Kullanici girisi yapmadan yorumu begenemezsiniz!",
                        confirmButtonText: "Tamam",
                        icon: "info"
                    });
                @endif
            });
        });
    </script>
@endsection
