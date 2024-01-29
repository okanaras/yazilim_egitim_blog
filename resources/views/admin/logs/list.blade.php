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
                            name="search_text" placeholder="Data, Created Date">
                    </div>
                    <div class="col-3 my-2">
                        <input type="text" class="form-control" value="{{ request()->get('user_search_text') }}"
                            name="user_search_text" placeholder="User: Name, Username, Email">
                    </div>
                    <div class="col-3 my-2">
                        <select name="model" id="models" class="js-states form-control w-100 d-none">
                            <option value="{{ null }}">Model Secebilirsiniz</option>
                            @foreach ($models as $model)
                                <option {{ request()->get('model') == $model ? 'selected' : ''}}>{{ $model }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-3 my-2">
                        <select name="action" id="actions" class="js-states form-control w-100 d-none">
                            <option value="{{ null }}">Action Secebilirsiniz</option>
                            @foreach ($actions as $model)
                                <option {{ request()->get('action') == $model ? 'selected' : ''}}>{{ $model }}</option>
                            @endforeach
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
                                <a href="javascript:void(0)" class="btn btn-info btn-sm btnModelLogDetail" data-bs-toggle="modal" data-bs-target="#contentViewModal" data-id="{{ $log->id }}"
                                >
                                        <i class="material-icons ms-0">visibility</i>
                                    </a>
                            </td>
                            <td>{{ $log->user->name }}</td>
                            <td>
                                <a href="javascript:void(0)" class="btn btn-primary btn-sm btnDataDetail" data-bs-toggle="modal" data-bs-target="#contentViewModal" data-id="{{ $log->id }}"
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

            $('.btnModelLogDetail').click(function() {
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

            $('.btnDataDetail').click(function() {
                let logID = $(this).data('id');
                let self = $(this);
                let route = "{{ route('dblogs.getLog', ['id'=> ':id']) }}";
                route = route.replace(":id", logID);
                console.log(route);

                $.ajax({
                    method: "get",
                    url: route,
                    async: false,
                    data: {
                        data_type: 'data'
                    },
                    success: function(data) {
                        $('#jsonData').html(JSON.stringify(data, null, 2));
                        document.querySelectorAll('#jsonData').forEach(block => {
                            hljs.highlightElement(block);
                        });
                    },
                    error: function() {
                        console.log("hata geldi");
                    }
                });
            });

            $('#models').select2();
            $('#actions').select2();
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

@push('javascript')
    <script src="{{ asset('assets/front/js/highlight.min.js') }}"></script>
    <script>
        hljs.highlightAll();
    </script>
@endpush

@push('style')
    <link rel="stylesheet" href="{{ asset('assets/front/css/highlighter-default.min.css') }}">
@endpush
