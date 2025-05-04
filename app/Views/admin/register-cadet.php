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
                        <div class="col-auto ms-auto d-print-none">
                            <div class="btn-list">
                                <a href="<?=site_url('cadet-information')?>"
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
                                <a href="<?=site_url('cadet-information')?>"
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
                                    <div class="card-title">
                                        <i class="ti ti-user-plus"></i>&nbsp;ROTC Enrolment Form
                                    </div>
                                    <form method="POST" class="row g-3" id="frmRegister">
                                        <?=csrf_field()?>
                                        <div class="col-lg-12">
                                            <div class="row g-3">
                                                <div class="col-lg-4">
                                                    <label class="form-label">Last Name</label>
                                                    <input type="text" class="form-control" name="lastname"
                                                        placeholder="Last Name" required>
                                                </div>
                                                <div class="col-lg-4">
                                                    <label class="form-label">First Name</label>
                                                    <input type="text" class="form-control" name="firstname"
                                                        placeholder="First Name" required>
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="form-label">M.I.</label>
                                                    <input type="text" class="form-control" name="middlename"
                                                        placeholder="Middle Initial" required>
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="form-label">Suffix</label>
                                                    <input type="text" class="form-control" name="suffix"
                                                        placeholder="Suffix" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <label class="form-label">Student No</label>
                                            <input type="text" class="form-control" name="student_no"
                                                placeholder="Student No" required />
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="row g-3">
                                                <div class="col-lg-3">
                                                    <label class="form-label">House No</label>
                                                    <input type="text" class="form-control" name="house_no"
                                                        placeholder="House No" required>
                                                </div>
                                                <div class="col-lg-3">
                                                    <label class="form-label">Street</label>
                                                    <input type="text" class="form-control" name="street"
                                                        placeholder="Street" required>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label class="form-label">Barangay/Subdivision</label>
                                                    <input type="text" class="form-control" name="barangay"
                                                        placeholder="Barangay/Subdivision" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="row g-3">
                                                <div class="col-lg-6">
                                                    <label class="form-label">City/Municipality</label>
                                                    <input type="text" class="form-control" name="city"
                                                        placeholder="City/Municipality" required>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label class="form-label">Province</label>
                                                    <input type="text" class="form-control" name="province"
                                                        placeholder="Province" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="row g-3">
                                                <div class="col-lg-4">
                                                    <label class="form-label">Course</label>
                                                    <input type="text" class="form-control" name="course"
                                                        placeholder="Course" required>
                                                </div>
                                                <div class="col-lg-4">
                                                    <label class="form-label">Year/Level</label>
                                                    <input type="text" class="form-control" name="year_level"
                                                        placeholder="Year/Level" required>
                                                </div>
                                                <div class="col-lg-4">
                                                    <label class="form-label">Section</label>
                                                    <input type="text" class="form-control" name="section"
                                                        placeholder="Section" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <label class="form-label">Last School Attended</label>
                                            <textarea name="last_school" class="form-control"></textarea>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <label class="form-label">Birth Date</label>
                                                    <input type="date" class="form-control" name="birth_date" required>
                                                </div>
                                                <div class="col-lg-4">
                                                    <label class="form-label">Height (ft)</label>
                                                    <input type="text" class="form-control" name="height" required>
                                                </div>
                                                <div class="col-lg-4">
                                                    <label class="form-label">Weight (kg)</label>
                                                    <input type="text" class="form-control" name="weight" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="row g-3">
                                                <div class="col-lg-3">
                                                    <label class="form-label">Blood Type</label>
                                                    <input type="text" class="form-control" name="blood_type"
                                                        placeholder="Blood Type" required>
                                                </div>
                                                <div class="col-lg-3">
                                                    <label class="form-label">Gender</label>
                                                    <select name="gender" class="form-select" required>
                                                        <option value="">Choose...</option>
                                                        <option>Male</option>
                                                        <option>Female</option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-3">
                                                    <label class="form-label">Religion</label>
                                                    <input type="text" class="form-control" name="religion"
                                                        placeholder="Religion" required>
                                                </div>
                                                <div class="col-lg-3">
                                                    <label class="form-label">Contact No</label>
                                                    <input type="phone" class="form-control" name="contact_no"
                                                        placeholder="Contact No" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="row g-3">
                                                <div class="col-lg-6">
                                                    <label class="form-label">Facebook Account</label>
                                                    <input type="text" class="form-control" name="fb_account"
                                                        placeholder="Facebook Account" required>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label class="form-label">Email Address</label>
                                                    <input type="email" class="form-control" name="email"
                                                        placeholder="Email Address" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <label class="form-label">Parent's Information</label>
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped">
                                                    <thead>
                                                        <th>Surname</th>
                                                        <th>First Name</th>
                                                        <th>M.I.</th>
                                                        <th>Contact No</th>
                                                        <th>Occupation</th>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><input type="text" class="form-control" name="surname[]"
                                                                    placeholder="Mother's Surname"></td>
                                                            <td><input type="text" class="form-control"
                                                                    name="firstname[]" placeholder="Mother's Firstname">
                                                            </td>
                                                            <td><input type="text" class="form-control" name="mi[]"
                                                                    placeholder="Mother's M.I."></td>
                                                            <td><input type="text" class="form-control" name="phone[]"
                                                                    placeholder="Mother's Contact"></td>
                                                            <td><input type="text" class="form-control" name="work[]"
                                                                    placeholder="Mother's Occupation"></td>
                                                        </tr>
                                                        <tr>
                                                            <td><input type="text" class="form-control" name="surname[]"
                                                                    placeholder="Father's Surname"></td>
                                                            <td><input type="text" class="form-control"
                                                                    name="firstname[]" placeholder="Father's Firstname">
                                                            </td>
                                                            <td><input type="text" class="form-control" name="mi[]"
                                                                    placeholder="Father's M.I."></td>
                                                            <td><input type="text" class="form-control" name="phone[]"
                                                                    placeholder="Father's Contact"></td>
                                                            <td><input type="text" class="form-control" name="work[]"
                                                                    placeholder="Father's Occupation"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <label class="form-label">Emergency Contact Information</label>
                                            <input type="text" class="form-control" name="emergency_contact"
                                                placeholder="Emergency Contact" required>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="row g-3">
                                                <div class="col-lg-3">
                                                    <label class="form-label">House No</label>
                                                    <input type="text" class="form-control" name="house_no"
                                                        placeholder="House No" required>
                                                </div>
                                                <div class="col-lg-3">
                                                    <label class="form-label">Street</label>
                                                    <input type="text" class="form-control" name="street"
                                                        placeholder="Street" required>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label class="form-label">Barangay/Subdivision</label>
                                                    <input type="text" class="form-control" name="barangay"
                                                        placeholder="Barangay/Subdivision" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="row g-3">
                                                <div class="col-lg-6">
                                                    <label class="form-label">City/Municipality</label>
                                                    <input type="text" class="form-control" name="city"
                                                        placeholder="City/Municipality" required>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label class="form-label">Province</label>
                                                    <input type="text" class="form-control" name="province"
                                                        placeholder="Province" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-">
                                            <div class="row g-3">
                                                <div class="col-lg-4">
                                                    <label class="form-label">Relationship</label>
                                                    <input type="text" class="form-control" name="relationship"
                                                        placeholder="Relationship" required>
                                                </div>
                                                <div class="col-lg-4">
                                                    <label class="form-label">Contact No</label>
                                                    <input type="phone" class="form-control" name="contact_no"
                                                        placeholder="Contact No" required>
                                                </div>
                                                <div class="col-lg-4">
                                                    <label class="form-label">Email</label>
                                                    <input type="text" class="form-control" name="email"
                                                        placeholder="Email" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <button type="submit" class="btn btn-success">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-device-floppy">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path
                                                        d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" />
                                                    <path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                                    <path d="M14 4l0 4l-6 0l0 -4" />
                                                </svg>
                                                Register
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-header">Recent Cadets</div>
                                <div class="position-relative">

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