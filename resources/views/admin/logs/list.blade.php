@extends('layouts.admin')

@section('title')
    Log Listeleme
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
            <h2>Log Listesi</h2>
        </x-slot:header>

        <x-slot:body>
            <form action="" method="get">
                <div class="row">
                    <div class="col-3 my-2">
                        <input type="text" class="form-control" value="{{ request()->get('search_text') }}"
                            name="search_text" placeholder="Title, Slug, Body, Tags">
                    </div>

                    <hr>
                    <div class="col-6 mb-2 d-flex">
                        <button type="submit" class="btn btn-primary w-50 me-4">Filtrele</button>
                        <button type="button" class="btn btn-warning w-50">Filtreyi Temizle</button>
                    </div>
                    <hr>
                </div>
            </form>
            <x-bootstrap.table :class="'table-striped table-hover'" :isResponsive="1">
                <x-slot:columns>
                    <th scope="col">Action</th>
                    <th scope="col">Model</th>
                    <th scope="col">Model View</th>
                    <th scope="col">User</th>
                    <th scope="col">Data</th>
                    <th scope="col">Create Date</th>
                </x-slot:columns>

                <x-slot:rows>
                    @foreach ($list as $log)
                        <tr id="row-{{ $log->id }}">
                            <td>{{ $log->action }}</td>
                            <td>{{ $log->loggable_type }}</td>
                            <td>
                                <a href="javascript:void(0)" class="btn btn-info btn-sm btnLogDetail" data-bs-toggle="modal" data-bs-target="#contentViewModal" data-id="{{ $log->id }}"
                                >
                                        <i class="material-icons ms-0">visibility</i>
                                    </a>
                            </td>
                            <td>{{ $log->user->name }}</td>
                            <td>
                                <a href="javascript:void(0)" class="btn btn-primary btn-sm" data-bs-target="#test"
                                >
                                        <i class="material-icons ms-0">visibility</i>
                                    </a>
                            </td>
                            <td>{{ $log->created_at }}</td>
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
                        <h5 class="modal-title" id="exampleModalLabel">Log Detayi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modalBody">
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

            $('.btnLogDetail').click(function() {
                let logID = $(this).data('id');
                let self = $(this);
                let route = "{{ route('dblogs.getLog', ['id'=> ':id']) }}";
                route = route.replace(":id", logID);
                console.log(route);

                $.ajax({
                    method: "get",
                    url: route,
                    async: false,
                    success: function(data) {
                        $('#modalBody').html(data);
                    },
                    error: function() {
                        console.log("hata geldi");
                    }
                });
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

            $('#selectParentCategory').select2();
        });
    </script>

    <script>
        $("#publish_date").flatpickr({
            enableTime: true,
            dateFormat: "Y-m-d H:i",
        });

        const popover = new bootstrap.Popover('.example-popover', {
            container: 'body'
        })
    </script>
@endsection
