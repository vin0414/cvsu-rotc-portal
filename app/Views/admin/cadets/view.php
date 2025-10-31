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
                                <?php if($cadet['is_enroll']!=1):?>
                                <button type="button" class="btn btn-primary enroll" value="<?=$cadet['student_id']?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-pencil-plus">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" />
                                        <path d="M13.5 6.5l4 4" />
                                        <path d="M16 19h6" />
                                        <path d="M19 16v6" />
                                    </svg>
                                    Enroll
                                </button>
                                <?php else : ?>
                                <button type="button" class="btn btn-primary" value="<?=$cadet['student_id']?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-user-check">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                        <path d="M6 21v-2a4 4 0 0 1 4 -4h4" />
                                        <path d="M15 19l2 2l4 -4" />
                                    </svg>
                                    Enrolled
                                </button>
                                <?php endif;?>
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
                                                    <div class="row g-3">
                                                        <div class="col-lg-12">
                                                            <label class="form-label">Mother's Name</label>
                                                            <input type="text" class="form-control"
                                                                value="<?=$info['mother_sname']?>, <?=$info['mother_fname']?> <?=$info['mother_mname']?>">
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="row g-3">
                                                                <div class="col-lg-6">
                                                                    <label class="form-label">Contact No</label>
                                                                    <input type="text" class="form-control"
                                                                        value="<?=$info['mother_contact']?>">
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <label class="form-label">Occupation</label>
                                                                    <input type="text" class="form-control"
                                                                        value="<?=$info['mother_work']?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <label class="form-label">Father's Name</label>
                                                            <input type="text" class="form-control"
                                                                value="<?=$info['father_sname']?>, <?=$info['father_fname']?> <?=$info['father_mname']?>">
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="row g-3">
                                                                <div class="col-lg-6">
                                                                    <label class="form-label">Contact No</label>
                                                                    <input type="text" class="form-control"
                                                                        value="<?=$info['father_contact']?>">
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <label class="form-label">Occupation</label>
                                                                    <input type="text" class="form-control"
                                                                        value="<?=$info['father_work']?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <h3>Emergency Contact</h3>
                                                            <label class="form-label">Address</label>
                                                            <textarea class="form-control"><?=$info['emergency_address']?>
                                                            </textarea>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="row g-3">
                                                                <div class="col-lg-4">
                                                                    <label class="form-label">Relationship</label>
                                                                    <input type="text" class="form-control"
                                                                        value="<?=$info['relationship']?>">
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <label class="form-label">Contact Person</label>
                                                                    <input type="text" class="form-control"
                                                                        value="<?=$info['emergency_contact']?>">
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <label class="form-label">Email Address</label>
                                                                    <input type="text" class="form-control"
                                                                        value="<?=$info['emergency_email']?>">
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
                        </div>
                        <div class="col-lg-4">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="card-title">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-paperclip">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M15 7l-6.5 6.5a1.5 1.5 0 0 0 3 3l6.5 -6.5a3 3 0 0 0 -6 -6l-6.5 6.5a4.5 4.5 0 0 0 9 9l6.5 -6.5" />
                                        </svg>
                                        Attachments
                                    </div>
                                    <div class="list-group list-group-hoverable mb-3">
                                        <?php if(!empty($attachment)): ?>
                                        <div class="list-group-item">
                                            <?=$attachment['file']?>
                                            <a href="<?=base_url('Upload/')?><?=$attachment['file']?>"
                                                class="btn btn-primary btn-sm" style="padding:5px;float:right;">
                                                <i class="ti ti-download"></i>
                                            </a>
                                        </div>
                                        <?php else: ?>
                                        <div class="list-group-item">
                                            No Attachment(s) found
                                        </div>
                                        <?php endif;?>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-brand-databricks">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M3 17l9 5l9 -5v-3l-9 5l-9 -5v-3l9 5l9 -5v-3l-9 5l-9 -5l9 -5l5.418 3.01" />
                                        </svg>
                                        Training(s)
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
    <div class="modal" id="modal-loading" data-backdrop="static">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <div class="mb-2">
                        <dotlottie-wc src="https://lottie.host/ed13f8d5-bc3f-4786-bbb8-36d06a21a6cb/XMPpTra572.lottie"
                            style="width: 100%;height: auto;" autoplay loop></dotlottie-wc>
                    </div>
                    <div>Loading</div>
                </div>
            </div>
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
    <script src="https://unpkg.com/@lottiefiles/dotlottie-wc@0.8.1/dist/dotlottie-wc.js" type="module"></script>
    <script>
    $(document).on('click', '.enroll', function() {
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to enroll this cadet?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Continue',
            cancelButtonText: 'No, cancel!',
        }).then((result) => {
            // Action based on user's choice
            if (result.isConfirmed) {
                $('#modal-loading').modal('show');
                const value = $(this).val();
                $.ajax({
                    url: "<?=site_url('enroll-cadet')?>",
                    method: "POST",
                    data: {
                        value: value,
                    },
                    success: function(response) {
                        $('#modal-loading').modal('hide');
                        if (response.success) {
                            location.reload();
                        } else {
                            alert(response.errors);
                        }
                    }
                });
            }
        });
    });
    </script>
</body>

</html>