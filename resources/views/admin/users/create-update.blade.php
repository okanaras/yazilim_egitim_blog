@extends('layouts.admin')

@section('title')
    Kullanici {{ isset($user) ? 'Guncelleme' : 'Ekleme' }}
@endsection

@section('css')
    <link href="{{ asset('assets/admin/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/plugins/summernote/summernote-lite.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <x-bootstrap.card>
        <x-slot:header>
            <h2 class="card-title">Kullanici {{ isset($user) ? 'Guncelleme' : 'Ekleme' }}
            </h2>
        </x-slot:header>
        <x-slot:body>
            <div class="example-container">
                <div class="example-content">
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger">{{ $error }}</div>
                        @endforeach
                    @endif
                    <form
                        action="{{ isset($user) ? route('user.edit', ['user' => $user->username]) : route('user.create') }}"
                        method="POST" enctype="multipart/form-data" id="userForm">
                        @csrf

                        <label for="username" class="form-label">Kullanici Adi</label>
                        <input type="text" id="username"
                            class="form-control form-control-solid-bordered m-b-sm
                            @if ($errors->has('username')) border-danger @endif"
                            placeholder="Kullanici Adi" name="username" required
                            value="{{ isset($user) ? $user->username : old('username') }}">

                        <label for="password" class="form-label">Parola</label>
                        <input type="password" id="password"
                            class="form-control form-control-solid-bordered m-b-sm
                            @if ($errors->has('password')) border-danger @endif"
                            placeholder="Parola" name="password" value="" required>

                        <label for="name" class="form-label">Kullanici Ad Soyad</label>
                        <input type="text" class="form-control form-control-solid-bordered m-b-sm"
                            placeholder="Kullanici Ad Soyad" id="name" name="name"
                            value="{{ isset($user) ? $user->name : old('name') }}">

                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control form-control-solid-bordered m-b-sm" placeholder="Email"
                            id="email" name="email" value="{{ isset($user) ? $user->email : old('email') }}">

                        <label for="about" class="form-label">Hakkinda Yazisi</label>
                        <textarea id="about" name="about" class="m-b-sm">{!! isset($user) ? $user->about : old('about') !!}</textarea>

                        <div class="row m-t-sm">
                            <div class="col-8">
                                <label for="image" class="form-label">Kullanici Gorseli</label>
                                <select class="form-control" name="image" id="image">
                                    <option value="{{ null }}">Gorsel Secin</option>
                                    <option value="assets/admin/images/user-images/profile1.png" {{ isset($user) && $user->image == 'assets/admin/images/user-images/profile1.png' ? 'selected' : (old('image') == 'assets/admin/images/user-images/profile1.png' ? 'selected' : '' )}}>Profile 1</option>
                                    <option value="assets/admin/images/user-images/profile2.png" {{ isset($user) && $user->image == 'assets/admin/images/user-images/profile2.png' ? 'selected' : (old('image') == 'assets/admin/images/user-images/profile2.png' ? 'selected' :'')}}>Profile 2</option>
                                </select>
                            </div>
                            <div class="col-4">
                                <img src="{{ isset($user) ? asset($user->image) : old('image') }}" alt="" class="img-fluid"
                                    style="max-height: 80px;" id="profileImage">
                            </div>
                        </div>

                        <div class="form-check m-t-md">
                            <input type="checkbox" class="form-check-input" value="1" name="is_admin" id="is_admin"
                                {{ isset($user) && $user->is_admin ? 'checked' : (old('is_admin') ? 'checked' : '') }}>
                            <label for="is_admin" class="form-check-label">
                                Kullanici admin mi?
                            </label>
                        </div>
                        <div class="form-check m-t-md">
                            <input type="checkbox" class="form-check-input" value="1" name="status" id="status"
                                {{ isset($user) && $user->status ? 'checked' : (old('status') ? 'checked' : '') }}>
                            <label for="status" class="form-check-label">
                                Kullanici aktif olsun mu?
                            </label>
                        </div>
                        <hr>
                        <div class="col-6 mx-auto mt-5">
                            <button type="button" id="btnSave"
                                class="btn btn-success btn-rounded w-100">{{ isset($user) ? 'Guncelle' : 'Kaydet' }}
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

    <script>
        let username = $('#username');
        let email = $('#email');
        let name = $('#name');

        $(document).ready(function() {
            $('#btnSave').click(function() {
                if (username.val().trim() === "" || username.val().trim() == null) {
                    Swal.fire({
                        title: "Uyari",
                        text: "Kullanici adi bos birakilamaz!",
                        confirmButtonText: "Tamam",
                        icon: "info"
                    });
                } else if (name.val().trim() === "" || name.val().trim() == null) {
                    Swal.fire({
                        title: "Uyari",
                        text: "Kullanici adi soyadi bos birakilamaz!",
                        confirmButtonText: "Tamam",
                        icon: "info"
                    });
                } else if (email.val().trim() === "" || email.val().trim() == null) {
                    Swal.fire({
                        title: "Uyari",
                        text: "Kullanici email bos birakilamaz!",
                        confirmButtonText: "Tamam",
                        icon: "info"
                    });
                } else {
                    $('#userForm').submit();
                }
            });

            $('#image').change(function() {
                $('#profileImage').attr("src", "{{ env('APP_URL') }}" + "/" + $(this).val());
            });
        });
    </script>
@endsection
