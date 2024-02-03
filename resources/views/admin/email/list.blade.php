@extends('layouts.admin')

@section('title')
    Email Tema Listeleme
@endsection

@section('css')
    <link href="{{ asset('assets/admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet">

    <style>
        .table-hover>tbody>tr:hover {
            --bs-table-hover-bg: transparent;
            background: #6528F7;
            color: #D7BBF5;
        }

        table td {
            vertical-align: middle !important;
            height: 60px;
        }
    </style>
@endsection

@section('content')
    <x-bootstrap.card>
        <x-slot:header>
            <h2>Email Tema Listesi</h2>
        </x-slot:header>

        <x-slot:body>
            <form action="" method="get" id="formFilter">
                <div class="row">

                    <div class="col-3 my-2">
                        <select class="js-states form-control" name="theme_type" id="theme_type" tabindex="-1"
                            style="display: none; width: 100%">
                            <option value="{{ null }}">Tema Turu Secin</option>
                                <option value="1" {{ request()->get('theme_type') == "1" ? 'selected' : '' }}>Kendim Icerik Olusturmak Istiyorum</option>
                                <option value="2" {{ request()->get('theme_type') == "2" ? 'selected' : '' }}>Parola Sifirlama Maili</option>

                        </select>
                    </div>


                    <div class="col-3 my-2">
                        <select class="js-states form-control" name="process" id="process" tabindex="-1"
                            style="display: none; width: 100%">
                            <option value="{{ null }}">Islem Seciniz</option>
                            <option value="1" {{ request()->get('process') == "1" ? 'selected' : '' }}>Email Dogrulama Mail Icerigi</option>
                            <option value="2" {{ request()->get('process') == "2" ? 'selected' : '' }}>Parola Sifirlama Mail Icerigi</option>
                            <option value="3" {{ request()->get('process') == "3" ? 'selected' : '' }}>Parola Sifirlama Islem Tamamlandiginda Gonderilecek Mail Icerigi</option>

                        </select>
                    </div>


                    <div class="col-3 my-2">
                        <input type="text" class="form-control" value="{{ request()->get('search_text') }}"
                            name="search_text" placeholder="Mail Icerigi">
                    </div>

                    <hr>
                    <div class="col-6 mb-2 d-flex">
                        <button type="submit" class="btn btn-primary w-50 me-4">Filtrele</button>
                        <button type="button" class="btn btn-warning w-50" id="btnClearFilter">Filtreyi Temizle</button>
                    </div>
                    <hr>
                </div>
            </form>
            <x-bootstrap.table :class="'table-striped table-hover'" :isResponsive="1">
                <x-slot:columns>
                    <th scope="col">Tema Turu</th>
                    <th scope="col">Islem</th>
                    <th scope="col">Icerik</th>
                    <th scope="col">Status</th>
                    <th scope="col">Olusturan</th>
                    <th scope="col">Created Date</th>
                    <th scope="col">Actions</th>
                </x-slot:columns>

                <x-slot:rows>
                    @foreach ($list as $email)
                        <tr id="row-{{ $email->id }}">
                            <td>{{ $email->theme_type }}</td>
                            <td>{{ $email->process }}</td>
                            <td>
                                <a href="javascript:void(0)" class="btn btn-info btn-sm btnModelThemeDetail" data-bs-toggle="modal" data-bs-target="#contentViewModal" data-id="{{ $email->id }}" data-content="{{ $email->body }}" data-theme-type="{{ $email->getRawOriginal('theme_type') }}"
                                    >
                                            <i class="material-icons ms-0">visibility</i>
                                        </a>
                            </td>
                            <td>
                                @if ($email->status)
                                    <a href="javascript:void(0)" data-id="{{ $email->id }}"
                                        class="btn btn-success btn-sm btnChangeStatus">Aktif</a>
                                @else
                                    <a href="javascript:void(0)" data-id="{{ $email->id }}"
                                        class="btn btn-danger btn-sm btnChangeStatus">Pasif</a>
                                @endif
                            </td>

                            <td>{{ $email->user->name }}</td>
                            <td>{{ $email->created_at }}</td>
                            <td>
                                <div class="d-flex">
                                    <a href="{{ route('admin.email-themes.edit', ['id' => $email->id]) }}"
                                        class="btn btn-warning btn-sm">
                                        <i class="material-icons ms-0">edit</i>
                                    </a>
                                    <a href="javascript:void(0)" class="btn btn-danger btn-sm btnDelete"
                                        data-id="{{ $email->id }}" data-name="{{ $email->title }}">
                                        <i class="material-icons ms-0">delete</i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </x-slot:rows>
            </x-bootstrap.table>
            <div class="d-flex justify-content-center">
                {{ $list->appends(request()->all())->onEachside(1)->links() }}
            </div>
        </x-slot:body>
    </x-bootstrap.card>

        <!-- Modal -->
        <div class="modal fade" id="contentViewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Sablon Icerigi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modalBody">
                        <pre><code class="language-json" id="jsonData"></code></pre>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                    </div>
                </div>
            </div>
        </div>

@endsection

@section('js')
    <script src="{{ asset('assets/admin/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/pages/select2.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/admin/js/pages/datepickers.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/bootstrap/js/popper.min.js') }}"></script>
    <script>
        $(document).ready(function() {

            $('.btnChangeStatus').click(function() {
                let articleID = $(this).data('id');
                let self = $(this);

                Swal.fire({
                    title: 'Status degistirmek istediginize emin misiniz?',
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: 'Evet',
                    denyButtonText: `Hayir`,
                    cancelButtonText: "Iptal"
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $.ajax({
                            method: "POST",
                            url: "{{ route('article.changeStatus') }}",
                            data: {
                                articleID: articleID
                            },
                            async: false,
                            success: function(data) {
                                if (data.article_status) {
                                    self.removeClass("btn-danger");
                                    self.addClass("btn-success");
                                    self.text("Aktif");

                                } else {
                                    self.removeClass("btn-success");
                                    self.addClass("btn-danger");
                                    self.text("Pasif");
                                }
                                Swal.fire({
                                    title: "Basarili",
                                    text: "Status Guncellendi!",
                                    confirmButtonText: "Tamam",
                                    icon: "success"
                                });
                            },
                            error: function() {
                                console.log("hata geldi");
                            }
                        });
                    } else if (result.isDenied) {
                        Swal.fire({
                            title: "Bilgi",
                            text: "Herhangi bir islem yapilmadi!",
                            confirmButtonText: "Tamam",
                            icon: "info"
                        });
                    }
                })
            });


            $('.btnDelete').click(function() {
                let articleID = $(this).data('id');
                let articleName = $(this).data('name');
                // let articleName = "okan";

                Swal.fire({
                    title: articleName + "'i Silmek istediğinize emin misiniz?",
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: 'Evet',
                    denyButtonText: `Hayir`,
                    cancelButtonText: "İptal"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            method: "POST",
                            url: "{{ route('article.delete') }}",
                            data: {
                                "_method": "DELETE",
                                articleID: articleID
                            },
                            async: false,
                            success: function(data) {

                                $('#row-' + articleID).remove();
                                Swal.fire({
                                    title: "Basarili",
                                    text: "Makale Silindi",
                                    confirmButtonText: 'Tamam',
                                    icon: "success"
                                });
                            },
                            error: function() {
                                console.log("hata geldi");
                            }
                        })

                    } else if (result.isDenied) {
                        Swal.fire({
                            title: "Bilgi",
                            text: "Herhangi bir islem yapilmadi",
                            confirmButtonText: 'Tamam',
                            icon: "info"
                        });
                    }
                })

            });

            $('.btnModelThemeDetail').click(function () {
                let content = $(this).data("content");
                let themeType = $(this).data("theme-type");

                if (themeType == 1) {

                    $('#jsonData').html(content.replace('"', '').replace('"', ''));
                }
                else{
                    $('#jsonData').html(JSON.stringify(content, null, 2));
                    document.querySelectorAll('#jsonData').forEach(block => {
                            hljs.highlightElement(block);
                    });
                }
            });

            $('#theme_type').select2();
            $('#process').select2();

        });
    </script>
@endsection

@push('javascript')
    <script src="{{ asset('assets/front/js/highlight.min.js') }}"></script>
    <script>
        hljs.highlightAll();
    </script>
@endpush

@push('style')
    <link rel="stylesheet" href="{{ asset('assets/plugins/highlight/styles/androidstudio.css') }}">
@endpush

