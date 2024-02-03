@extends('layouts.admin')

@section('css')
    <link href="{{ asset('assets/admin/plugins/summernote/summernote-lite.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <x-bootstrap.card>
        <x-slot:header>
            <h2 class="card-title">Makale {{ isset($article) ? 'Guncelleme' : 'Ekleme' }}
        </x-slot:header>

        <x-slot:body>
            <form action="" method="post" enctype="multipart/form-data">
                @csrf
                <div class="theme-select">
                    <div class="row">

                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger">{{ $error }}</div>
                            @endforeach
                        @endif


                        <div class="col-6">
                            <select name="theme_type" id="theme-type" class="form-control">
                                <option value="">Tema Turu Seciniz</option>
                                <option value="1">Kendim Icerik Olusturmak Istiyorum</option>
                                <option value="2">Parola Sifirlama Maili</option>
                            </select>
                        </div>

                        <div class="col-6">
                            <select name="process" id="process" class="form-control">
                                <option value="">Islem Seciniz</option>
                                <option value="1">Email Dogrulama Mail Icerigi</option>
                                <option value="2">Parola Sifirlama Mail Icerigi</option>
                                <option value="3">Parola Sifirlama Islem Tamamlandiginda Gonderilecek Mail Icerigi</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="content mt-5">
                    <div class="custom-content d-none">
                        <div class="row">
                            <div class="col-12">
                                <h5>Kendi Iceriginizi Olusturabilirsiniz</h5>
                                <hr>
                                <h6>Kullanabileceginiz Alanlar</h6>
                                <p>
                                    {link}, {username}, {useremail}
                                </p>
                            </div>

                            <div class="col-12 mt-5">
                                <textarea class="form-control" name="custom_content" id="custom_content" cols="30" rows="5"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="password-reset-mail d-none">
                        <div class="row">
                            <div class="col-12">
                                <h5>Parola Sifirlama Mail Alanlarini Doldurabilirsiniz.</h5>
                                <hr>
                            </div>

                            <div class="col-6 mt-4">
                                <a href="javascript:void(0)" class="btn btn-warning btn-sm w-100" id="btnAddLogoImage" data-input="logo" data-preview="imgLogo">
                                    Logo Gorseli
                                </a>
                                <input type="hidden" name="passwordResetMail[logo]" id="logo">
                            </div>

                            <div class="col-6 mt-4" id="imgLogo">
                                <img src="" alt="" id="imgLogo2">
                            </div>

                            <div class="col-6 mt-4">
                                <input type="text" name="passwordResetMail[logo_alt]" id="logo_alt" class="form-control" placeholder="Logo Alt Attribute">
                            </div>

                            <div class="col-6 mt-4">
                                <input type="text" name="passwordResetMail[logo_title]" id="logo_title" class="form-control" placeholder="Logo Title Attribute">
                            </div>

                            <div class="col-6 mt-4">
                                <a href="javascript:void(0)" class="btn btn-warning btn-sm w-100" id="btnAddResetPasswordImage" data-input="resetPasswordImage" data-preview="resetPassword">
                                    Reset Password Gorseli
                                </a>
                                <input type="hidden" name="passwordResetMail[reset_password_image]" id="resetPasswordImage">
                            </div>

                            <div class="col-6 mt-4" id="resetPassword">
                                <img src="" alt="" id="passwordResetMail[imgResetPassword]">
                            </div>

                            <div class="col-6 mt-4">
                                <input type="text" name="passwordResetMail[reset_password_image_alt]" id="reset_password_image_alt" class="form-control" placeholder="Reset Password Alt Attribute">
                            </div>

                            <div class="col-6 mt-4">
                                <input type="text" name="passwordResetMail[reset_password_image_title]" id="reset_password_image_title" class="form-control" placeholder="Reset Password Title Attribute">
                            </div>

                            <div class="col-6 mt-4">
                                <input type="text" name="passwordResetMail[title]" id="title" class="form-control" placeholder="Baslik">
                            </div>

                            <div class="col-6 mt-4">
                                <input type="text" name="passwordResetMail[description]" id="description" class="form-control" placeholder="Aciklama">
                            </div>

                            <div class="col-6 mt-4">
                                <input type="text" name="passwordResetMail[button_text]" id="button_text" class="form-control" placeholder="Parola Sifirlama Butonunda Ne Yazsin?">
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-4 mt-4 d-none theme-status">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" value="1" name="status" id="status"
                                    {{ isset($email) && $email->status ? 'checked' : '' }}>
                                <label for="status" class="form-check-label">
                                    Tema Aktif Olarak Kullanilsin Mi?
                                </label>
                            </div>
                        </div>
                        <div class="col-12 text-center">
                            <hr>
                            <button class="btn btn-success w-50">KAYDET</button>
                        </div>
                    </div>
                </div>
            </form>

        </x-slot:body>
    </x-bootstrap.card>
@endsection

@section('js')

    <script src="{{ asset('assets/admin/plugins/summernote/summernote-lite.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/pages/text-editor.js') }}"></script>
    <script src="{{ asset('vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>

    <script>
        $('#theme-type').change(function () {
            let val = $(this).val();

            switch (val) {
                case "1":
                    $('.custom-content').removeClass('d-none');
                    $('.theme-status').removeClass('d-none');
                    $('.password-reset-mail').addClass('d-none');
                    $('#process').val("").change();
                    $('#process').removeAttr('style').removeAttr('readonly');
                    break;

                case "2":
                    $('.custom-content').addClass('d-none');
                    $('.password-reset-mail').removeClass('d-none');
                    $('.theme-status').removeClass('d-none');
                    $('#process').val(2).change();
                    $('#process').attr("readonly", true).attr("style", "pointer-events:none;");
                    break;

                default:
                    $('.custom-content').addClass('d-none');
                    $('.password-reset-mail').addClass('d-none');
                    $('.theme-status').addClass('d-none');
                    $('#process').val("").change();
                    $('#process').removeAttr('style').removeAttr('readonly');
                    break;
            }
        });

        $('#btnAddLogoImage').filemanager();
        $('#btnAddResetPasswordImage').filemanager();
    </script>
@endsection
