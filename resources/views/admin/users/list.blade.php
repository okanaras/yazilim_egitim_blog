@extends('layouts.admin')

@section('title')
    Kullanici Listeleme
@endsection

@section('css')
    <link href="{{ asset('assets/admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet">

    <style>
        .table-hover>tbody>tr:hover {
            --bs-table-hover-bg: transparent;
            background: #363638;
            color: #fff;
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
            <h2>Kullanici Listesi</h2>
        </x-slot:header>

        <x-slot:body>
            <form action="" method="get">
                <div class="row">
                    <div class="col-3 my-2">
                        <select class="form-select" name="status" aria-label="Default select example">
                            <option value="{{ null }}">Status</option>
                            <option value="0" {{ request()->get('status') === '0' ? 'selected' : '' }}>Pasif</option>
                            <option value="1" {{ request()->get('status') === '1' ? 'selected' : '' }}>Aktif</option>
                        </select>
                    </div>

                    <div class="col-3 my-2">
                        <input type="text" class="form-control" value="{{ request()->get('search_text') }}"
                            name="search_text" placeholder="Name, Username, Email">
                    </div>

                    <hr>
                    <div class="col-6 mb-2 d-flex">
                        <button type="submit" class="btn btn-primary w-50 me-4">Filtrele</button>
                        <button type="reset" class="btn btn-warning w-50">Filtreyi Temizle</button>
                    </div>
                    <hr>
                </div>
            </form>
            <x-bootstrap.table :class="'table-striped table-hover'" :isResponsive="1">
                <x-slot:columns>
                    <th scope="col">Image</th>
                    <th scope="col">Name</th>
                    <th scope="col">Username</th>
                    <th scope="col">Email</th>
                    <th scope="col">Status</th>
                    <th scope="col">Actions</th>
                </x-slot:columns>

                <x-slot:rows>
                    @foreach ($list as $user)
                        <tr id="row-{{ $user->id }}">
                            <td>
                                @if (!empty($user->image))
                                    <img src="{{ asset($user->image) }}" height="60">
                                @endif
                            </td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if ($user->status)
                                    <a href="javascript:void(0)" data-id="{{ $user->id }}"
                                        class="btn btn-success btn-sm btnChangeStatus">Aktif</a>
                                @else
                                    <a href="javascript:void(0)" data-id="{{ $user->id }}"
                                        class="btn btn-danger btn-sm btnChangeStatus">Pasif</a>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex">
                                    <a href="{{ route('user.edit', ['id' => $user->id]) }}" class="btn btn-warning btn-sm">
                                        <i class="material-icons ms-0">edit</i>
                                    </a>
                                    <a href="javascript:void(0)" class="btn btn-danger btn-sm btnDelete"
                                        data-id="{{ $user->id }}" data-name="{{ $user->title }}">
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
                let userID = $(this).data('id');
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
                            url: "{{ route('user.changeStatus') }}",
                            data: {
                                userID: userID
                            },
                            async: false,
                            success: function(data) {
                                if (data.user_status) {
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
        });

        $('.btnDelete').click(function() {
            let userID = $(this).data('id');
            let userName = $(this).data('name');
            // let userName = "okan";

            Swal.fire({
                title: userName + "'i Silmek istediğinize emin misiniz?",
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: 'Evet',
                denyButtonText: `Hayir`,
                cancelButtonText: "İptal"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        method: "POST",
                        url: "{{ route('user.delete') }}",
                        data: {
                            "_method": "DELETE",
                            userID: userID
                        },
                        async: false,
                        success: function(data) {

                            $('#row-' + userID).remove();
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
