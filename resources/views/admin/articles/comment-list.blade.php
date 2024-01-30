@extends('layouts.admin')

@section('title')
    @if ($page == 'commentList')
        Yorum Listesi
    @else
        Onay Bekleyen Yorum Listesi
    @endif
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
            <h2>
                @if ($page == 'commentList')
                    Yorum Listesi
                @else
                    Onay Bekleyen Yorum Listesi
                @endif
            </h2>
        </x-slot:header>

        <x-slot:body>
            <form action="{{ $page == 'commentList' ? route('artical.comment.list') : route('artical.pending-approval') }}"
                method="get" id="formFilter">
                <div class="row">
                    <div class="col-3 my-2">
                        <select class="js-states form-control" name="user_id" tabindex="-1"
                            style="display: none; width: 100%">
                            <option value="{{ null }}">User</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}"
                                    {{ request()->get('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    @if ($page == 'commentList')
                        <div class="col-3 my-2">
                            <select class="form-select" name="status" aria-label="Default select example">
                                <option value="{{ null }}">Status</option>
                                <option value="0" {{ request()->get('status') === '0' ? 'selected' : '' }}>Pasif
                                </option>
                                <option value="1" {{ request()->get('status') === '1' ? 'selected' : '' }}>Aktif
                                </option>
                            </select>
                        </div>
                    @endif

                    <div class="col-3 my-2">
                        <input class="form-control flatpickr2 m-b-sm" id="created_at" type="text" name="created_at"
                            type="text" placeholder="Yorum Tarihi" value="{{ request()->get('created_at') }}">
                    </div>
                    <div class="col-3 my-2">
                        <input type="text" class="form-control" value="{{ request()->get('search_text') }}"
                            name="search_text" placeholder="Comment, Name, Email">
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
                    <th scope="col">Makale Link</th>
                    <th scope="col">User Name</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">IP</th>
                    <th scope="col">Status</th>
                    <th scope="col">Comment</th>
                    <th scope="col">Created Date</th>
                    <th scope="col">Actions</th>
                </x-slot:columns>

                <x-slot:rows>
                    @foreach ($comments as $comment)
                        <tr id="row-{{ $comment->id }}">
                            <td>
                                <a href="{{ route("front.articleDetail", [
                                'user' => $comment->article->user->username,
                                'article' => $comment->article->slug
                                ]) }}" target="_blank">
                                    <span class="material-icons-outlined">visibility</span>
                                </a>
                            </td>

                            <td>{{ $comment->user?->name }}</td>
                            <td>{{ $comment->name }}</td>
                            <td>{{ $comment->email }}</td>
                            <td>{{ $comment->ip }}</td>
                            <td>
                                @if ($comment->status)
                                    <a href="javascript:void(0)" data-id="{{ $comment->id }}"
                                        class="btn btn-success btn-sm btnChangeStatus">Aktif</a>
                                @else
                                    <a href="javascript:void(0)" data-id="{{ $comment->id }}"
                                        class="btn btn-danger btn-sm btnChangeStatus">Pasif</a>
                                @endif
                            </td>

                            <td>
                                <span data-bs-container="body" data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-title="{{ substr($comment->comment, 0, 200) }}">{{ substr($comment->comment, 0, 200) }}</span>
                                <button type="button" class="btn btn-primary lookComment btn-sm p-0 px-2"
                                    data-comment="{{ $comment->comment }}" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">
                                    <span class="material-icons-outlined"
                                        style="line-height: unset; font-size: 20px;">visibility</span></button>
                            </td>

                            <td>{{ isset($comment->created_at) ? Carbon\Carbon::parse($comment->created_at)->translatedFormat('d F Y H:i:s') : 'Tarih Girilmedi' }}
                            </td>
                            <td>
                                <div class="d-flex">
                                    <a href="javascript:void(0)" class="btn btn-danger btn-sm btnDelete"
                                        data-id="{{ $comment->id }}" data-name="{{ $comment->id }}">
                                        <i class="material-icons ms-0">delete</i>
                                    </a>
                                    @if ($comment->deleted_at)
                                        <a href="javascript:void(0)" class="btn btn-primary btn-sm btnRestore"
                                            data-id="{{ $comment->id }}" data-name="{{ $comment->id }}">
                                            <i class="material-icons ms-0" title="Geri al">undo</i>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </x-slot:rows>
            </x-bootstrap.table>
            <div class="d-flex justify-content-center">
                {{ $comments->appends(request()->all())->onEachside(1)->links() }}
            </div>
        </x-slot:body>
    </x-bootstrap.card>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Yorum</h5>
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

            // changeStatus jq-ajax
            $('.btnChangeStatus').click(function() {
                let id = $(this).data('id');
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
                            url: "{{ route('artical.pending-approval.changeStatus') }}",
                            data: {
                                id: id
                            },
                            async: false,
                            success: function(data) {
                                if (data.comment_status) {
                                    $('#row-' + id).remove();

                                }
                                Swal.fire({
                                    title: "Basarili",
                                    text: "Yorum Onaylandi!",
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

            // delete jq-ajax
            $('.btnDelete').click(function() {
                let id = $(this).data('id');
                let articleName = $(this).data('name');

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
                            url: "{{ route('artical.pending-approval.delete') }}",
                            data: {
                                "_method": "DELETE",
                                id: id
                            },
                            async: false,
                            success: function(data) {

                                $('#row-' + id).remove();
                                Swal.fire({
                                    title: "Basarili",
                                    text: "Yorum Silindi",
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

            // restore jq-ajax
            $('.btnRestore').click(function() {
                let id = $(this).data('id');
                let articleName = $(this).data('name');

                let self = $(this);

                Swal.fire({
                    title: articleName + "'i Geri almak istediğinize emin misiniz?",
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: 'Evet',
                    denyButtonText: `Hayir`,
                    cancelButtonText: "İptal"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            method: "POST",
                            url: "{{ route('artical.comment.restore') }}",
                            data: {
                                id: id
                            },
                            async: false,
                            success: function(data) {

                                self.remove();
                                Swal.fire({
                                    title: "Basarili",
                                    text: "Yorum yayina geri alindi!",
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

            // select icin
            $('#selectParentCategory').select2();

            // filtrede kullanilan date
            $("#created_at").flatpickr({
                dateFormat: "Y-m-d",
            });

            // yorum icerigini gosteren modal
            $(".lookComment").click(function() {
                let comment = $(this).data("comment");
                $('#modalBody').text(comment);
            });
        });
    </script>

    <script>
        const popover = new bootstrap.Popover('.example-popover', {
            container: 'body'
        })
    </script>
@endsection
