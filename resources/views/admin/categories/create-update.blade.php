@extends('layouts.admin')

@section('title')
    Kategori {{ isset($category) ? 'Guncelleme' : 'Ekleme' }}
@endsection

@section('css')
@endsection

@section('content')
    <x-bootstrap.card>
        <x-slot:header>
            <h2 class="card-title">Kategori {{ isset($category) ? 'Guncelleme' : 'Ekleme' }}
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
                        action="{{ isset($category) ? route('categories.edit', ['id' => $category->id]) : route('category.create') }}"
                        method="POST" enctype="multipart/form-data" id="categoryForm">
                        @csrf
                        <label for="color" class="form-label">Kategorinin Rengi</label>
                        <input type="color" name="color" id="color" class="form-control m-b-sm"
                            value="{{ isset($category) ? $category->color : '' }}">

                        <input type="text"
                            class="form-control form-control-solid-bordered m-b-sm
                            @if ($errors->has('name')) border-danger @endif
                            "
                            aria-describedby="solidBoderedInputExample" placeholder="Kategori Adi" name="name"
                            id="name" value="{{ isset($category) ? $category->name : '' }}">
                        @if ($errors->has('name'))
                            {{-- <div class="alert alert-danger">{{ $errors->first("name") }}</div> --}}
                        @endif
                        <input type="text" class="form-control form-control-solid-bordered m-b-sm"
                            aria-describedby="solidBoderedInputExample" placeholder="Kategori Slug" name="slug"
                            value="{{ isset($category) ? $category->slug : '' }}">
                        <textarea class="form-control form-control-solid-bordered m-b-sm" name="description" id="" cols="30"
                            rows="5" style="resize: none" placeholder="Kategori Aciklama">{{ isset($category) ? $category->description : '' }}</textarea>
                        <input type="number" class="form-control form-control-solid-bordered m-b-sm"
                            aria-describedby="solidBoderedInputExample" placeholder="Siralama" name="order"
                            value="{{ isset($category) ? $category->order : '' }}">
                        <select class="form-select bg-light m-b-sm" aria-label="Ust Kategori Secimi" name="parent_id">
                            <option value="{{ null }}">Ust Kategori Secimi</option>
                            @foreach ($categories as $item)
                                <option value="{{ $item->id }}"
                                    {{ isset($category) && $category->id == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                        <textarea class="form-control form-control-solid-bordered m-b-sm" name="seo_keywords" name="seo_keywords"
                            id="seo_description" cols="30" rows="5" style="resize: none" placeholder="Seo Description">{{ isset($category) ? $category->seo_keywords : '' }}</textarea>
                        <textarea class="form-control form-control-solid-bordered m-b-sm" name="seo_description" id="seo_description"
                            cols="30" rows="5" style="resize: none" placeholder="Seo Description">{{ isset($category) ? $category->seo_description : '' }}</textarea>

                        <label for="image" class="form-label">Kategori Gorseli</label>
                        <input type="file" name="image" id="image" class="form-control"
                            accept="image/png,image/jpeg,image/jpg">
                        <div class="form-text m-b-sm">Kategori gorseli max 2 MB olmalidir.</div>

                        @if (isset($category) && $category->image)
                            <img src="{{ asset($category->image) }}" alt="" class="img-fluid"
                                style="max-height: 200px;">
                        @endif

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" value="1" name="status" id="status"
                                {{ isset($category) && $category->status ? 'checked' : '' }}>
                            <label for="status" class="form-check-label">
                                Kategori Sitede Gorunsun mu?
                            </label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" value="1" name="feature_status"
                                id="feature_status" {{ isset($category) && $category->feature_status ? 'checked' : '' }}>
                            <label for="feature_status" class="form-check-label">
                                Kategori Anasayfada One Cikarilsin mi?
                            </label>
                        </div>
                        <hr>
                        <div class="col-6 mx-auto mt-5">
                            <button type="button" class="btn btn-success btn-rounded w-100"
                                id="btnSave">{{ isset($category) ? 'Guncelle' : 'Kaydet' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </x-slot:body>
    </x-bootstrap.card>
@endsection

@section('js')
    <script>
        let name = $('#name');
        $(document).ready(function() {
            $('#btnSave').click(function() {
                if (name.val().trim() === "" || name.val().trim() == null) {
                    Swal.fire({
                        title: "Uyari",
                        text: "Kategori adi bos birakilamaz!",
                        confirmButtonText: "Tamam",
                        icon: "info"
                    });
                } else {
                    $('#categoryForm').submit();
                }
            });
        });
    </script>
@endsection
