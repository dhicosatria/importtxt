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
                                style="margin-right: 20px; margin-left: 20px; margin-top: 10px; margin-bottom: 10px;">
                                <table class="table card-table table-vcenter datatable">       
                                    <div class="row">
                                        <div class="mb-3 col-md-2" style="max-width: 145px;">
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#add-administrator"><button class="btn btn-default">Import Domains</button></a>
                                        </div>
                                        <div class="mb-3 col-md-2" style="max-width: 120px;">
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#add-domain"><button class="btn btn-default">Add Domain</button></a>
                                        </div>
                                        <div class="mb-3 col-md-2" style="max-width: 85px;">
                                        <a href="{{ url('/history') }}"><button class="btn btn-default">History</button></a>
                                        </div>
                                        <div class="mb-3 col-md-2" style="max-width: 80px;" >
                                        <a href="{{ url('/export-powerdns') }}"><button class="btn btn-default">Sync</button></a>
                                        </div>
                                        <div class="mb-3 col-md-2" style="max-width: 75px; margin-left: 730px">
                                            <a href="{{ url('/login') }}"><button type="submit"button class="btn btn-outline-danger">Logout</button></a>
                                            </div>
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
                                                <form action="{{ url('/delete-list-domain/'.$data->name) }}" method="POST">
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

    <div class="modal modal-blur fade" id="add-administrator" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ url('/import-txt') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <label class="form-label">File</label>
                                <input type="file" name="txt_file" class="form-control" required>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                        Cancel
                    </a>
                    <input type="submit" name="submit" value="Add Data" class="btn btn-primary ms-auto">
                </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal modal-blur fade" id="add-domain" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Domain</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                        <!-- Pesan kesalahan akan ditampilkan di sini -->
                        <div class="alert alert-danger" role="alert" id="error-message" style="display: none;"></div>
                    
                    <form method="POST" action="{{ url('/add-domain') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <label class="form-label">Domain Name</label>
                                <input type="name" name="domain" class="form-control" required>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                        Cancel
                    </a>
                    <input type="submit" name="submit" value="Add Data" class="btn btn-primary ms-auto">
                </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            var table = $('.datatable').DataTable({
                "lengthMenu": [5, 10, 20, 50, 100],
                "pageLength": 50,
                "searching": true,
                "paging": true,
                "order": [
                    [0, 'desc']
                ],
            });
        });

        // Fungsi untuk menampilkan pesan kesalahan (alert)
        function showAlert(message) {
            const errorMessageElement = document.getElementById('error-message');
            errorMessageElement.textContent = message;
            errorMessageElement.style.display = 'block'; // Menampilkan pesan kesalahan
        }

        // Contoh penggunaan fetch untuk mengambil data dari server
        fetch('http://127.0.0.1:8000/', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ domain: 'Nama_Domain' }),
        })
        .then(response => {
            if (!response.ok) {
                response.json().then(data => {
                    if (response.status === 400) {
                        showAlert(data.message); // Menampilkan pesan kesalahan ketika terjadi data duplicate
                    }
                });
            }
            // Lanjutkan penanganan respons yang berhasil
        })
        .catch(error => {
            console.error('Terjadi kesalahan: ' + error);
        });
    </script>
@endsection
