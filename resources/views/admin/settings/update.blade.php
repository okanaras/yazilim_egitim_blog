@extends('layouts.admin')

@section('title')
    Ayarlar
@endsection

@section('css')
    <link href="{{ asset('assets/admin/plugins/summernote/summernote-lite.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <x-bootstrap.card>
        <x-slot:header>
            <h2 class="card-title">Ayarlar</h2>
        </x-slot:header>
        <x-slot:body>
            <div class="example-container">
                <div class="example-content">
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger">{{ $error }}</div>
                        @endforeach
                    @endif
                    <form action="{{ route('settings') }}" method="POST" enctype="multipart/form-data" id="settingsForm">
                        @csrf
                        <label for="telegram_link" class="form-label">Telegram Linki</label>
                        <input type="text" id="telegram_link"
                            class="form-control form-control-solid-bordered m-b-sm
                            @if ($errors->has('telegram_link')) border-danger @endif
                            "
                            placeholder="Telegram Linki" name="telegram_link"
                            value="{{ isset($settings) ? $settings->telegram_link : '' }}">

                        <label for="header_text" class="form-label">Header Text</label>
                        <textarea
                            class="form-control form-control-solid-bordered m-b-sm
                        @if ($errors->has('name')) border-danger @endif"
                            name="header_text" id="header_text" cols="30" rows="5" placeholder="Header Aciklama">{!! isset($settings) ? $settings->header_text : '' !!}</textarea>
                        @if ($errors->has('header_text'))
                            <div class="alert alert-danger">{{ $errors->first('title') }}</div>
                        @endif

                        <label for="seo_keywords_home" class="form-label m-t-sm">Seo Anahtar Kelimeler Anasayfa</label>
                        <textarea class="form-control form-control-solid-bordered  m-b-sm" name="seo_keywords_home" id="seo_keywords_home" cols="30"
                            rows="5" style="resize: none" placeholder="Seo Keywords Anasayfa">{{ isset($settings) ? $settings->seo_keywords_home : '' }}</textarea>

                        <label for="seo_description_home" class="form-label">Seo Description Anasayfa</label>
                        <textarea class="form-control form-control-solid-bordered m-b-sm" name="seo_description_home" id="seo_description_home"
                            cols="30" rows="5" style="resize: none" placeholder="Seo Description Anasayfa">{{ isset($settings) ? $settings->seo_description_home : '' }}</textarea>

                        <label for="seo_keywords_articles" class="form-label m-t-sm">Seo Anahtar Kelimeler Makale</label>
                        <textarea class="form-control form-control-solid-bordered  m-b-sm" name="seo_keywords_articles" id="seo_keywords_articles" cols="30"
                            rows="5" style="resize: none" placeholder="Seo Keywords Makale">{{ isset($settings) ? $settings->seo_keywords_articles : '' }}</textarea>

                        <label for="seo_description_articles" class="form-label">Seo Description Makale</label>
                        <textarea class="form-control form-control-solid-bordered m-b-sm" name="seo_description_articles" id="seo_description_articles"
                            cols="30" rows="5" style="resize: none" placeholder="Seo Description Makale">{{ isset($settings) ? $settings->seo_description_articles : '' }}</textarea>

                        <label for="footer_text" class="form-label m-t-sm">Footer Text</label>
                        <textarea class="form-control form-control-solid-bordered  m-b-sm" name="footer_text" id="footer_text" cols="30"
                            rows="5" placeholder="Footer Aciklama">{!! isset($settings) ? $settings->footer_text : '' !!}</textarea>
                        @if ($errors->has('footer_text'))
                            <div class="alert alert-danger">{{ $errors->first('title') }}</div>
                        @endif

                        <label for="logo" class="form-label m-t-sm">Logo Gorseli</label>
                        <input type="file" name="logo" id="logo" class="form-control"
                            accept="image/png,image/jpeg,image/jpg">
                        <div class="form-text m-b-sm">Logo gorseli max 2 MB olmalidir.</div>
                        @if (isset($settings) && $settings->logo)
                            <img src="{{ asset($settings->logo) }}" alt="" class="img-fluid"
                                style="max-height: 200px;">
                        @endif
                        <hr>

                        <label for="category_default_image" class="form-label m-t-sm">Kategori Varsayilan
                            Gorseli</label>
                        <input type="file" name="category_default_image" id="category_default_image" class="form-control"
                            accept="image/png,image/jpeg,image/jpg">
                        <div class="form-text m-b-sm">Kategori varsayilan gorseli max 2 MB olmalidir.</div>
                        @if (isset($settings) && $settings->category_default_image)
                            <img src="{{ asset($settings->category_default_image) }}" alt="" class="img-fluid"
                                style="max-height: 200px;">
                        @endif
                        <hr>

                        <label for="article_default_image" class="form-label m-t-sm">Makale Varsayilan Gorseli</label>
                        <input type="file" name="article_default_image" id="article_default_image" class="form-control"
                            accept="image/png,image/jpeg,image/jpg">
                        <div class="form-text m-b-sm">Makale varsayilan gorseli max 2 MB olmalidir.</div>
                        @if (isset($settings) && $settings->article_default_image)
                            <img src="{{ asset($settings->article_default_image) }}" alt="" class="img-fluid"
                                style="max-height: 200px;">
                        @endif
                        <hr>

                        <label for="reset_password_image" class="form-label m-t-sm">Parola Sifirlama Maili Gorseli</label>
                        <input type="file" name="reset_password_image" id="reset_password_image" class="form-control"
                            accept="image/png,image/jpeg,image/jpg">
                        <div class="form-text m-b-sm">Parola Sifirlama Maili Gorseli max 2 MB olmalidir.</div>
                        @if (isset($settings) && $settings->reset_password_image)
                            <img src="{{ asset($settings->reset_password_image) }}" alt="" class="img-fluid"
                                style="max-height: 200px;">
                        @endif
                        <hr>

                        <div class="form-check m-t-sm">
                            <input type="checkbox" class="form-check-input " value="1"
                                name="feature_categories_is_active" id="feature_categories_is_active"
                                {{ isset($settings) && $settings->feature_categories_is_active ? 'checked' : '' }}>
                            <label for="feature_categories_is_active" class="form-check-label">
                                One Cikarilan Kategoriler Anasayfada Gorunsun mu?
                            </label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" value="1" name="video_is_active"
                                id="video_is_active" {{ isset($settings) && $settings->video_is_active ? 'checked' : '' }}>
                            <label for="video_is_active" class="form-check-label">
                                Video Sidebarda Gorunsun mu?
                            </label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" value="1" name="author_is_active"
                                id="author_is_active"
                                {{ isset($settings) && $settings->author_is_active ? 'checked' : '' }}>
                            <label for="author_is_active" class="form-check-label">
                                Yazarlar Sidebarda Gorunsun mu?
                            </label>
                        </div>
                        <hr>
                        <div class="col-6 mx-auto mt-5">
                            <button type="button" class="btn btn-success btn-rounded w-100" id="btnSave">Kaydet</button>
                        </div>
                    </form>
                </div>
            </div>
        </x-slot:body>
    </x-bootstrap.card>
@endsection

@section('js')
    <script src="{{ asset('assets/admin/plugins/summernote/summernote-lite.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/pages/text-editor.js') }}"></script>
    <script src="{{ asset('assets/admin/js/custom.js') }}"></script>

    <script>
        let name = $('#name');

        $(document).ready(function() {
            $('#btnSave').click(function() {

            let logoCheckStatus = imageCheck($('#logo'));
            let category_default_imageStatus = imageCheck($('#category_default_image'));
            let article_default_imageStatus = imageCheck($('#article_default_image'));
            let reset_password_imageStatus = imageCheck($('#reset_password_image'));

            if (!logoCheckStatus || !category_default_imageStatus || !article_default_imageStatus || !reset_password_imageStatus) {
                Swal.fire({
                title: "Uyari",
                text: "Sectiginiz gorselleri kontrol edin.",
                confirmButtonText: "Tamam",
                icon: "warning"
            });
            } else {
                $('#settingsForm').submit();
            }
            });
        });


    </script>
@endsection
