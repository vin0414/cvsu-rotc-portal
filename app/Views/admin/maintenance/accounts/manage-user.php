<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="apple-touch-icon" href="<?=base_url('assets/images/cvsu-logo.png')?>">
    <link rel="shortcut icon" type="image/x-icon" href="<?=base_url('assets/images/cvsu-logo.png')?>">
    <title>CvSU-CCC ROTC Unit Portal</title>
    <link href="<?=base_url('assets/css/tabler.min.css')?>" rel="stylesheet" />
    <link href="<?=base_url('assets/css/demo.min.css')?>" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.1/css/dataTables.dataTables.css" />
    <style>
    @import url("https://rsms.me/inter/inter.css");
    </style>
</head>

<body>
    <script src="<?=base_url('assets/js/demo-theme.min.js')?>"></script>
    <div class="page">
        <!--  BEGIN SIDEBAR  -->
        <?= view('admin/templates/sidebar')?>
        <!--  END SIDEBAR  -->
        <!-- BEGIN NAVBAR  -->
        <?= view('admin/templates/header')?>
        <!-- END NAVBAR  -->
        <div class="page-wrapper">
            <!-- BEGIN PAGE HEADER -->
            <div class="page-header d-print-none">
                <div class="container-xl">
                    <div class="row g-2 align-items-center">
                        <div class="col">
                            <!-- Page pre-title -->
                            <div class="page-pretitle">CvSU-CCC ROTC Unit Portal</div>
                            <h2 class="page-title"><?=$title?></h2>
                        </div>
                        <!-- Page title actions -->
                    </div>
                </div>
            </div>
            <!-- END PAGE HEADER -->
            <!-- BEGIN PAGE BODY -->
            <div class="page-body">
                <div class="container-xl">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="tblaccount">
                                    <thead>
                                        <th>Employee ID</th>
                                        <th>Fullname</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END PAGE BODY -->
            <!--  BEGIN FOOTER  -->
            <footer class="footer footer-transparent d-print-none">
                <div class="container-xl">
                    <div class="row text-center align-items-center flex-row-reverse">
                        <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                            <ul class="list-inline list-inline-dots mb-0">
                                <li class="list-inline-item">
                                    Copyright &copy; <?= date('Y')?>
                                    <a href="." class="link-secondary">CvSU-CCC ROTC Unit Portal</a>. All rights
                                    reserved.
                                </li>
                                <li class="list-inline-item">
                                    <a href="" class="link-secondary" rel="noopener"> v1.1.1 </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </footer>
            <!--  END FOOTER  -->
        </div>
    </div>
    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="<?=base_url('assets/js/tabler.min.js')?>" defer></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->
    <!-- BEGIN DEMO SCRIPTS -->
    <script src="<?=base_url('assets/js/demo.min.js')?>" defer></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.2.1/js/dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    let account = $('#tblaccount').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": window.location.origin + "/fetch-account",
            "type": "GET",
            "dataSrc": function(json) {
                // Handle the data if needed
                return json.data;
            },
            "error": function(xhr, error, code) {
                console.error("AJAX Error: " + error);
                alert("Error occurred while loading data.");
            }
        },
        "searching": true,
        "columns": [{
                "data": "employee_id"
            },
            {
                "data": "fullname"
            },
            {
                "data": "email"
            },
            {
                "data": "role"
            },
            {
                "data": "status",
                render(data, type, row) {
                    if (data == 1) {
                        return '<span class="badge bg-success text-white">Active</span>';
                    } else {
                        return '<span class="badge bg-danger text-white">Inactive</span>';
                    }
                }
            },
            {
                "data": "action"
            }
        ]
    });
    </script>
</body>

</html>