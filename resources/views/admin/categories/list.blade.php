@extends('layouts.admin')

@section('title')
    Kategori Listeleme
@endsection

@section('css') 
    <style>
        .table-hover > tbody > tr:hover{
        --bs-table-hover-bg:transparent;
        background: #363638;
        color: #fff;
    }
    </style>
@endsection

@section('content')
    {{-- <div class="card">
        <div class="card-header">
            <h2>Kategori Listesi</h2>
        </div>
        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">First</th>
                        <th scope="col">Last</th>
                        <th scope="col">Handle</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                    </tr>
                    <tr>
                        <th scope="row">2</th>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                    </tr>
                    <tr>
                        <th scope="row">3</th>
                        <td colspan="2">Larry the Bird</td>
                        <td>@twitter</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div> --}}

    <x-bootstrap.card>
        <x-slot:header>
            <h2>Kategori Listesi</h2>
        </x-slot:header>

        <x-slot:body>
            <x-bootstrap.table
                :class="'table-striped table-hover'"
                :isResponsive="1"
                >
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
                                        <a href="javascript:void(0)" data-id="{{ $category->id }}" class="btn btn-success btn-sm btnChangeStatus">Aktif</a>
                                    @else    
                                        <a href="javascript:void(0)" data-id="{{ $category->id }}" class="btn btn-danger btn-sm btnChangeStatus">Pasif</a>
                                @endif
                            </td>
                            <td>
                                @if ($category->feature_status)
                                        <a href="javascript:void(0)" data-id="{{ $category->id }}" class="btn btn-success btn-sm btnChangeFeatureStatus">Aktif</a>
                                    @else    
                                        <a href="javascript:void(0)" data-id="{{ $category->id }}" class="btn btn-danger btn-sm btnChangeFeatureStatus">Pasif</a>
                                @endif
                            </td>

                            <td>{{ substr($category->description , 0, 20) }}</td>
                            <td>{{ $category->order }}</td>
                            <td>{{ $category->parent_category?->name  }}</td>
                            <td>{{ $category->user->name  }}</td>
                            <td class="d-flex">
                                <a href="" class="btn btn-warning btn-sm"><i class="material-icons ms-0">edit</i></a>    
                                <a href="" class="btn btn-danger btn-sm"><i class="material-icons ms-0">delete</i></a>    
                            </td>

                        </tr>
                    @endforeach
                </x-slot:rows>
            </x-bootstrap.table>
        </x-slot:body>
    </x-bootstrap.card>
    <form action="" method="POST" id="statusChangeForm">
        @csrf
        <input type="hidden" name="id" id="inputStatus" value="">
    </form>
@endsection

@section('js') 
    <script>
        $(document).ready(function () 
            {
                $('.btnChangeStatus').click(function () { 
                    let categoryID=$(this).data('id');
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
                        $('#statusChangeForm').attr("action", "{{ route('categories.changeStatus')}}");
                        $('#statusChangeForm').submit();
                    } 
                    else if (result.isDenied) 
                    {
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

        $(document).ready(function () 
            {
                $('.btnChangeFeatureStatus').click(function () { 
                    let categoryID=$(this).data('id');
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
                        $('#statusChangeForm').attr("action", "{{ route('categories.changeFeatureStatus')}}");
                        $('#statusChangeForm').submit();
                    } 
                    else if (result.isDenied) 
                    {
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

            
    
    </script>
@endsection