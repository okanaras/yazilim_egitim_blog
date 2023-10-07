@extends('layouts.admin')

@section('title')
    Makale Listeleme
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
    </style>
@endsection

@section('content')
    <x-bootstrap.card>
        <x-slot:header>
            <h2>Makale Listesi</h2>
        </x-slot:header>

        <x-slot:body>
            <form action="" method="get">
                <div class="row">
                    <div class="col-3 my-2">
                        <select class="js-states form-control" name="category_id" id="selectParentCategory" tabindex="-1"
                            style="display: none; width: 100%">
                            <option value="{{ null }}">Kategori Secin</option>
                            @foreach ($categories as $parent)
                                <option value="{{ $parent->id }}"
                                    {{ request()->get('parent_id') == $parent->id ? 'selected' : '' }}>{{ $parent->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
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
                    <div class="col-3 my-2">
                        <select class="form-select" name="status" aria-label="Default select example">
                            <option value="{{ null }}">Status</option>
                            <option value="0" {{ request()->get('status') === '0' ? 'selected' : '' }}>Pasif</option>
                            <option value="1" {{ request()->get('status') === '1' ? 'selected' : '' }}>Aktif</option>
                        </select>
                    </div>
                    <div class="col-3 my-2">

                        <input class="form-control flatpickr2 m-b-sm" id="publish_date" type="text" name="publish_date"
                            type="text" placeholder="Ne zaman yayinlansin?"
                            value="{{ request()->get('publish_date') }}">
                    </div>
                    <div class="col-3 my-2">
                        <input type="text" class="form-control" value="{{ request()->get('search_text') }}"
                            name="search_text" placeholder="Title, Slug, Body, Tags">
                    </div>
                    <div class="col-9 my-2">
                        <div class="row">
                            <div class="col-6">
                                <div class="row">
                                    <div class="col-6">
                                        <input type="number" class="form-control"
                                            value="{{ request()->get('min_view_count') }}" name="min_view_count"
                                            placeholder="Min View Count">
                                    </div>
                                    <div class="col-6">
                                        <input type="number" class="form-control"
                                            value="{{ request()->get('max_view_count') }}" name="max_view_count"
                                            placeholder="Max View Count">
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="row">
                                    <div class="col-6">
                                        <input type="number" class="form-control"
                                            value="{{ request()->get('min_like_count') }}" name="min_like_count"
                                            placeholder="Min Like Count">
                                    </div>
                                    <div class="col-6">
                                        <input type="number" class="form-control"
                                            value="{{ request()->get('max_like_count') }}" name="max_like_count"
                                            placeholder="Max Like Count">
                                    </div>
                                </div>
                            </div>
                        </div>
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
                    <th scope="col">Image</th>
                    <th scope="col">Title</th>
                    <th scope="col">Slug</th>
                    <th scope="col">Status</th>
                    <th scope="col">Body</th>
                    <th scope="col">Tags</th>
                    <th scope="col">View Count</th>
                    <th scope="col">Like Count</th>
                    <th scope="col">Category</th>
                    <th scope="col">Publish Date</th>
                    <th scope="col">User</th>
                    <th scope="col">Actions</th>
                </x-slot:columns>

                <x-slot:rows>
                    @foreach ($list as $article)
                        <tr>
                            <td>
                                @if (!empty($article->image))
                                    <img src="{{ asset($article->image) }}" height="100" class="img-fluid">
                                @endif
                            </td>
                            <td>{{ $article->title }}</td>
                            <td>{{ $article->slug }}</td>
                            <td>
                                @if ($article->status)
                                    <a href="javascript:void(0)" class="btn btn-success btn-sm btnChangeStatus"
                                        data-id="{{ $article->id }}">Aktif</a>
                                @else
                                    <a href="javascript:void(0)" class="btn btn-danger btn-sm btnChangeStatus"
                                        data-id="{{ $article->id }}">Pasif</a>
                                @endif
                            </td>
                            <td>
                                <span data-bs-container="body" data-bs-toggle="tooltip" data-bs-placement="right"
                                    data-bs-title="{{ substr($article->body, 0, 200) }}">{{ substr($article->body, 0, 20) }}</span>
                            </td>
                            <td>{{ $article->tags }}</td>
                            <td>{{ $article->view_count }}</td>
                            <td>{{ $article->like_count }}</td>
                            <td>{{ $article->category->name }}</td>
                            <td>{{ $article->user->name }}</td>
                            <td>
                                <div class="d-flex">
                                    <a href="javascript:void(0)" class="btn btn-warning btn-sm">
                                        <i class="material-icons ms-0">edit</i>
                                    </a>
                                    <a href="javascript:void(0)" class="btn btn-danger btn-sm btnDelete"
                                        data-id="{{ $article->id }}" data-name="{{ $article->name }}">
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
    <form action="" method="POST" id="statusChangeForm">
        @csrf
        <input type="hidden" name="id" id="inputStatus" value="">
    </form>
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
                let categoryID = $(this).data('id');
                $('#inputStatus').val(categoryID);

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
                        $('#statusChangeForm').attr("action",
                            "{{ route('categories.changeStatus') }}");
                        $('#statusChangeForm').submit();
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

        $(document).ready(function() {
            $('.btnChangeFeatureStatus').click(function() {
                let categoryID = $(this).data('id');
                $('#inputStatus').val(categoryID);

                Swal.fire({
                    title: 'Feature Status degistirmek istediginize emin misiniz?',
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: 'Evet',
                    denyButtonText: `Hayir`,
                    cancelButtonText: "Iptal"
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $('#statusChangeForm').attr("action",
                            "{{ route('categories.changeFeatureStatus') }}");
                        $('#statusChangeForm').submit();
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
        $(document).ready(function() {
            $('.btnDelete').click(function() {
                let categoryID = $(this).data('id');
                let categoryName = $(this).data('name');
                $('#inputStatus').val(categoryID);

                Swal.fire({
                    title: 'Feature Status degistirmek istediginize emin misiniz?',
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: 'Evet',
                    denyButtonText: `Hayir`,
                    cancelButtonText: "Iptal"
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $('#statusChangeForm').attr("action", "{{ route('categories.delete') }}");
                        $('#statusChangeForm').submit();
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
