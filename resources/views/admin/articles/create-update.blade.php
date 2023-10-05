@extends('layouts.admin')

@section('title')
    Makale {{ isset($article) ? 'Guncelleme' : 'Ekleme' }}
@endsection

@section('css')
    <link href="{{ asset('assets/admin/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/plugins/summernote/summernote-lite.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <x-bootstrap.card>
        <x-slot:header>
            <h2 class="card-title">Makale {{ isset($article) ? 'Guncelleme' : 'Ekleme' }}
            </h2>
        </x-slot:header>
        <x-slot:body>
            <p class="card-description">Lorem ipsum dolor sit amet.</p>
            <div class="example-container">
                <div class="example-content">
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger">{{ $error }}</div>
                        @endforeach
                    @endif
                    <form
                        action="{{ isset($article) ? route('article.edit', ['id' => $article->id]) : route('article.create') }}"
                        method="POST">
                        @csrf
                        <label for="title" class="form-label">Makale Basligi</label>
                        <input type="text" id="title"
                            class="form-control form-control-solid-bordered m-b-sm
                            @if ($errors->has('title')) border-danger @endif
                            "
                            placeholder="Makale Baslik" name="title" value="{{ isset($article) ? $article->title : '' }}"
                            required>
                        {{-- @if ($errors->has('title'))
                            <div class="alert alert-danger">{{ $errors->first("title") }}</div>
                        @endif --}}

                        <label for="slug" class="form-label">Makale Slug</label>
                        <input type="text" class="form-control form-control-solid-bordered m-b-sm"
                            placeholder="Makale Slug" id="slug" name="slug"
                            value="{{ isset($article) ? $article->slug : '' }}">

                        <label for="tags" class="form-label">Etiketler</label>
                        <input type="text" class="form-control form-control-solid-bordered " placeholder="Etiketler"
                            name="tags" value="{{ isset($article) ? $article->tags : '' }}">
                        <div id="tags" class="form-text m-b-sm">Etiketleri virgullerle ayirarak yaziniz.</div>

                        <label for="category_id" class="form-label">Kategori Secimi</label>
                        <select class="form-select bg-light m-b-sm" id="category_id" name="category_id">
                            <option value="{{ null }}">Kategori Secimi</option>
                            @foreach ($categories as $item)
                                <option value="{{ $item->id }}"
                                    {{ isset($article) && $article->category_id == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>

                        <label for="summernote" class="form-label">Icerik</label>
                        <div id="summernote" class="m-b-sm">Hello Summernote</div>

                        <label for="seo_keywords" class="form-label m-t-sm">Seo Anahtar Kelimeler</label>
                        <textarea class="form-control form-control-solid-bordered  m-b-sm" name="seo_keywords" id="seo_keywords" cols="30"
                            rows="5" style="resize: none" placeholder="Seo Keywords">{{ isset($article) ? $article->seo_keywords : '' }}</textarea>

                        <label for="seo_description" class="form-label">Seo Aciklama</label>
                        <textarea class="form-control form-control-solid-bordered m-b-sm" name="seo_description" id="seo_description"
                            cols="30" rows="5" style="resize: none" placeholder="Seo Description">{{ isset($article) ? $article->seo_description : '' }}</textarea>

                        <label for="publish_date" class="form-label">Yayimlanma Tarihi</label>
                        <input class="form-control flatpickr2 m-b-sm" id="publish_date" type="text" name="publish_date"
                            type="text" placeholder="Ne zaman yayinlansin?">

                        <label for="image" class="form-label">Makale Gorseli</label>
                        <input type="file" name="image" id="image" class="form-control"
                            accept="image/png,image/jpeg,image/jpg">
                        <div class="form-text m-b-sm">Makale gorseli max 2 MB olmalidir.</div>

                        <div class="form-check m-t-sm">
                            <input type="checkbox" class="form-check-input" value="1" name="status" id="status"
                                {{ isset($article) && $article->status ? 'checked' : '' }}>
                            <label for="status" class="form-check-label">
                                Makale Sitede Aktif Olarak Gorunsun mu?
                            </label>
                        </div>
                        <hr>
                        <div class="col-6 mx-auto mt-5">
                            <button type="submit"
                                class="btn btn-success btn-rounded w-100">{{ isset($article) ? 'Guncelle' : 'Kaydet' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </x-slot:body>
    </x-bootstrap.card>
@endsection

@section('js')
    <script src="{{ asset('assets/admin/plugins/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/admin/js/pages/datepickers.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/summernote/summernote-lite.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/pages/text-editor.js') }}"></script>

    <script>
        $("#publish_date").flatpickr({
            enableTime: true,
            dateFormat: "Y-m-d H:i",
        });
    </script>
@endsection
