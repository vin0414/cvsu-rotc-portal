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
                    <form method="GET" class="row g-3 mb-4" id="frmSearch">
                        <div class="col-lg-2">
                            <select name="platoon" class="form-select">
                                <option value="">All Units</option>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <input type="search" class="form-control" placeholder="Type here..." name="search" />
                        </div>
                        <div class="col-lg-2">
                            <button type="submit" class="btn btn-success">
                                <i class="ti ti-search"></i>&nbsp;Search
                            </button>
                        </div>
                    </form>
                    <div class="row row-cards" id="results">
                        <?php if(empty($students)): ?>
                        <div class="col-lg-12">
                            <div class="alert alert-warning" role="alert">No Cadet(s) Has Been Registered Yet</div>
                        </div>
                        <?php else : ?>
                        <?php foreach($students as $row): ?>
                        <div class="col-md-6 col-lg-3">
                            <div class="card">
                                <div class="card-body p-4 text-center">
                                    <span class="avatar avatar-xl mb-3 rounded"
                                        style="background-image: url(<?=base_url('assets/images/profile')?>/<?php echo $row['photo'] ?>);width:100%;height:10rem;"></span>
                                    <h3 class="m-0 mb-1">
                                        <a href="<?=site_url('cadet')?>/<?php echo $row['student_id'] ?>">
                                            <?php echo $row->last_name ?>, <?php echo $row->first_name ?>
                                            <?php echo $row->mi ?>
                                        </a>
                                    </h3>
                                    <div class="text-secondary"><?php echo $row->roleName ?></div>
                                    <div class="mt-3">
                                        <span class="badge bg-success-lt"><?php echo $row->team_name ?></span>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <a href="mailto:<?php echo $row->email ?>" class="card-btn">
                                        <i class="ti ti-mail"></i>&nbsp;Email
                                    </a>
                                    <a href="<?=site_url('athletes/profile')?>/<?php echo $row->player_id ?>"
                                        class="card-btn">
                                        <i class="ti ti-address-book"></i>&nbsp;Profile
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        <?php endif; ?>
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