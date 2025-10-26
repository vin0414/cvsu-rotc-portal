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

    h4 {
        border: 0.5px solid lightgray;
        padding: 10px;
        border-radius: 10px;
    }
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
                            <h2 class="page-title"><?=$cadet['school_id']?></h2>
                        </div>
                        <!-- Page title actions -->
                        <div class="col-auto ms-auto d-print-none">
                            <div class="btn-list">
                                <a href="<?=site_url('cadets')?>"
                                    class="btn btn-default text-success btn-5 d-none d-sm-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-left">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M5 12l14 0" />
                                        <path d="M5 12l6 6" />
                                        <path d="M5 12l6 -6" />
                                    </svg>
                                    Back
                                </a>
                                <a href="<?=site_url('cadets')?>"
                                    class="btn btn-default text-success btn-6 d-sm-none btn-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-left">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M5 12l14 0" />
                                        <path d="M5 12l6 6" />
                                        <path d="M5 12l6 -6" />
                                    </svg>
                                </a>
                            </div>
                            <!-- BEGIN MODAL -->
                            <!-- END MODAL -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- END PAGE HEADER -->
            <!-- BEGIN PAGE BODY -->
            <div class="page-body">
                <div class="container-xl">
                    <div class="row g-3">
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title">Student No : <?=$cadet['school_id']?></div>
                                    <div class="row g-1">
                                        <div class="col-lg-12">
                                            <div class="row g-3">
                                                <div class="col-lg-8">
                                                    <label class="form-label"><small>Student Name</small></label>
                                                    <h4>
                                                        <?=$cadet['fullname']?>
                                                    </h4>
                                                </div>
                                                <div class="col-lg-4">
                                                    <label class="form-label"><small>Email</small></label>
                                                    <h4><?=$cadet['email']?></h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <ul class="nav nav-tabs" data-bs-toggle="tabs">
                                                <li class="nav-item">
                                                    <a href="#tabs-home-8" class="nav-link active" data-bs-toggle="tab">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="icon icon-tabler icons-tabler-outline icon-tabler-user-shield">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M6 21v-2a4 4 0 0 1 4 -4h2" />
                                                            <path
                                                                d="M22 16c0 4 -2.5 6 -3.5 6s-3.5 -2 -3.5 -6c1 0 2.5 -.5 3.5 -1.5c1 1 2.5 1.5 3.5 1.5z" />
                                                            <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                                        </svg>
                                                        Basic Information
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="#tabs-other-8" class="nav-link" data-bs-toggle="tab">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="icon icon-tabler icons-tabler-outline icon-tabler-list-search">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M15 15m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                                                            <path d="M18.5 18.5l2.5 2.5" />
                                                            <path d="M4 6h16" />
                                                            <path d="M4 12h4" />
                                                            <path d="M4 18h4" />
                                                        </svg>
                                                        Others
                                                    </a>
                                                </li>
                                            </ul>
                                            <div class="tab-content">
                                                <div class="tab-pane fade active show" id="tabs-home-8">
                                                    <br />
                                                    <div class="row g-3">
                                                        <div class="col-lg-12">
                                                            <div class="row g-3">
                                                                <div class="col-lg-8">
                                                                    <label class="form-label">Course</label>
                                                                    <input type="text" class="form-control"
                                                                        value="<?=$info['course']?>" />
                                                                </div>
                                                                <div class="col-lg-2">
                                                                    <label class="form-label">Year</label>
                                                                    <input type="text" class="form-control"
                                                                        value="<?=$info['year']?>" />
                                                                </div>
                                                                <div class="col-lg-2">
                                                                    <label class="form-label">Section</label>
                                                                    <input type="text" class="form-control"
                                                                        value="<?=$info['section']?>" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <label class="form-label">School Attended</label>
                                                            <textarea class="form-control"><?=$info['school_attended']?>
                                                            </textarea>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="row g-3">
                                                                <div class="col-lg-3">
                                                                    <label class="form-label">Birth Date</label>
                                                                    <input type="date" class="form-control"
                                                                        value="<?=$info['birthdate']?>" />
                                                                </div>
                                                                <div class="col-lg-2">
                                                                    <label class="form-label">Height</label>
                                                                    <input type="text" class="form-control"
                                                                        value="<?=$info['height']?>" />
                                                                </div>
                                                                <div class="col-lg-2">
                                                                    <label class="form-label">Weight</label>
                                                                    <input type="text" class="form-control"
                                                                        value="<?=$info['weight']?>" />
                                                                </div>
                                                                <div class="col-lg-2">
                                                                    <label class="form-label">Gender</label>
                                                                    <input type="text" class="form-control"
                                                                        value="<?=$info['gender']?>" />
                                                                </div>
                                                                <div class="col-lg-3">
                                                                    <label class="form-label">Religion</label>
                                                                    <input type="text" class="form-control"
                                                                        value="<?=$info['religion']?>" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="row g-3">
                                                                <div class="col-lg-4">
                                                                    <label class="form-label">Contact No</label>
                                                                    <input type="text" class="form-control"
                                                                        value="<?=$info['contact_no']?>" />
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <label class="form-label">Facebook Account</label>
                                                                    <input type="text" class="form-control"
                                                                        value="<?=$info['fb_account']?>" />
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <label class="form-label">Email Address</label>
                                                                    <input type="text" class="form-control"
                                                                        value="<?=$info['email']?>" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <label class="form-label">Complete Address</label>
                                                            <textarea class="form-control"><?=$info['house_no']?> <?=$info['street']?> <?=$info['village']?>, <?=$info['municipality']?>, <?=$info['province']?> 
                                                            </textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="tabs-other-8">
                                                    <br />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
</body>

</html>