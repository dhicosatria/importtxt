@extends('layout')

@section('content')

    <head>
        <title>Administrators</title>
    </head>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <style>
        .datatable {
            border-collapse: separate;
            border-spacing: 0;
        }

        .datatable th,
        .datatable td {
            border-left: 0;
            border-right: 0;
            border-top: 1px solid #dee2e6;
            border-bottom: 1px solid #dee2e6;
            padding: 8px;
        }

        .datatable th {
            border: none;
        }

        .datatable tbody tr:hover {
            background-color: #f8f9fa;
        }
    </style>
<div class="center-container">
</div>
    <div class="page-wrapper">
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">
                            Admin
                        </h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-body">
            <div class="container-xl">
                <div class="row row-cards">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">List Data</h3>
                            </div>
                            <div class="table-responsive"
                                style="margin-right: 20px; margin-left: 20px; margin-top: 20px; margin-bottom: 20px;">
                                <table class="table card-table table-vcenter datatable">                                   
                                    <div class="row">
                                    <div class="mb-3 col-md-2" style="max-width: 145px;">
                                    <a href="{{ url('/') }}"><button class="btn btn-default">List Domains</button></a>
                                    </div>
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Name</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data_domain as $index => $data)
                                        <tr>
                                            <th>
                                                {{ $index + 1 }}
                                            </th>
                                            <th>
                                                {{ $data->name }}
                                            </th>
                                            <th>
                                                <form action="{{ url('/delete-domain/'.$data->name) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="submit" value="Delete" class="btn btn-danger">
                                                </form>
                                            </th>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            var table = $('.datatable').DataTable({
                "lengthMenu": [5, 10, 20, 50, 1000],
                "pageLength": 50,
                "searching": true,
                "paging": true,
                "order": [
                    [0, 'desc']
                ],
            });
        });
    </script>
@endsection
