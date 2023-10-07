@extends('layouts.admin')

@section('title')
    Kategori Listeleme
@endsection

@section('css')
    <link href="{{ asset('assets/admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">

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
            <h2>Kategori Listesi</h2>
        </x-slot:header>

        <x-slot:body>
            <form action="" method="get">
                <div class="row">
                    <div class="col-3 my-2">
                        <input type="text" class="form-control" value="{{ request()->get('name') }}" name="name"
                            placeholder="Name">
                    </div>
                    <div class="col-3 my-2">
                        <input type="text" class="form-control" value="{{ request()->get('slug') }}" name="slug"
                            placeholder="Slug">
                    </div>
                    <div class="col-3 my-2">
                        <input type="text" class="form-control" value="{{ request()->get('description') }}"
                            name="description" placeholder="description">
                    </div>
                    <div class="col-3 my-2">
                        <input type="text" class="form-control" value="{{ request()->get('order') }}" name="order"
                            placeholder="Order">
                    </div>
                    <div class="col-3 my-2">
                        <select class="js-states form-control" name="parent_id" id="selectParentCategory" tabindex="-1"
                            style="display: none; width: 100%">
                            <option value="{{ null }}">Parent Kategori</option>
                            @foreach ($parentCategories as $parent)
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
                        <select class="form-select" name="feature_status" aria-label="Default select example">
                            <option value="{{ null }}">Feature Status</option>
                            <option value="0" {{ request()->get('feature_status') === '0' ? 'selected' : '' }}>Pasif
                            </option>
                            <option value="1" {{ request()->get('feature_status') === '1' ? 'selected' : '' }}>Aktif
                            </option>
                        </select>
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
                    <th scope="col">Name</th>
                    <th scope="col">Slug</th>
                    <th scope="col">Status</th>
                    <th scope="col">Feature Status</th>
                    <th scope="col">Description</th>
                    <th scope="col">Order</th>
                    <th scope="col">Parent Category</th>
                    <th scope="col">User</th>
                    <th scope="col">Actions</th>
                </x-slot:columns>

                <x-slot:rows>
                    @foreach ($list as $category)
                        <tr>
                            <th scope="row">{{ $category->name }}</th>
                            <td>{{ $category->slug }}</td>
                            <td>
                                @if ($category->status)
                                    <a href="javascript:void(0)" data-id="{{ $category->id }}"
                                        class="btn btn-success btn-sm btnChangeStatus">Aktif</a>
                                @else
                                    <a href="javascript:void(0)" data-id="{{ $category->id }}"
                                        class="btn btn-danger btn-sm btnChangeStatus">Pasif</a>
                                @endif
                            </td>
                            <td>
                                @if ($category->feature_status)
                                    <a href="javascript:void(0)" data-id="{{ $category->id }}"
                                        class="btn btn-success btn-sm btnChangeFeatureStatus">Aktif</a>
                                @else
                                    <a href="javascript:void(0)" data-id="{{ $category->id }}"
                                        class="btn btn-danger btn-sm btnChangeFeatureStatus">Pasif</a>
                                @endif
                            </td>

                            <td title="{{ $category->description }}">{{ substr($category->description, 0, 20) }}</td>
                            <td>{{ $category->order }}</td>
                            <td>{{ $category->parentCategory?->name }}</td>
                            <td>{{ $category->user->name }}</td>
                            <td>
                                <div class="d-flex">
                                    <a href="{{ route('categories.edit', ['id' => $category->id]) }}"
                                        class="btn btn-warning btn-sm">
                                        <i class="material-icons ms-0">edit</i>
                                    </a>
                                    <a href="javascript:void(0)" class="btn btn-danger btn-sm btnDelete"
                                        data-id="{{ $category->id }}" data-name="{{ $category->name }}">
                                        <i class="material-icons ms-0">delete</i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </x-slot:rows>
            </x-bootstrap.table>
            <div class="d-flex justify-content-center">
                {{-- {{ $list->onEachside(1)->links("vendor.pagination.bootstrap-5") }} --}}
                {{-- {{ $list->onEachside(1)->links() }} --}}

                {{--
                @php
                    $filterArray=['name' => request()->get("name") , 'description' => request()->get("description")];
                @endphp
                {{ $list->appends($filterArray)->onEachside(1)->links() }}
                {{ $list->appends(request()->except("name"))->onEachside(1)->links() }} name disinda hepsini gonder
                {{ $list->appends(request()->only("name"))->onEachside(1)->links() }} yalnizca name i gonder
                {{ $list->appends($_GET)->onEachside(1)->links() }} hepsini gonder
                 --}}
                {{ $list->appends(request()->all())->onEachside(1)->links() }} hepsini gonder
            </div>
        </x-slot:body>
    </x-bootstrap.card>
    <form action="" method="POST" id="statusChangeForm">
        @csrf
        <input type="hidden" name="id" id="inputStatus" value="">
    </form>
@endsection

@section('js')
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
    <script src="{{ asset('assets/admin/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/pages/select2.js') }}"></script>
@endsection
