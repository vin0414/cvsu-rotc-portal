<?=view('cadet/templates/header') ?>

<body>
    <div class="page">
        <!-- BEGIN GLOBAL THEME SCRIPT -->
        <script src="<?=base_url('assets/js/demo-theme.min.js')?>"></script>
        <!-- END GLOBAL THEME SCRIPT -->
        <!-- BEGIN NAVBAR  -->
        <?=view('cadet/templates/navbar') ?>
        <!-- END NAVBAR  -->
        <div class="page-wrapper">
            <!-- BEGIN PAGE HEADER -->
            <div class="page-header d-print-none">
                <div class="container-xl">
                    <div class="row g-2 align-items-center">
                        <div class="col">
                            <h2 class="page-title"><?=$title?></h2>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END PAGE HEADER -->
            <!-- BEGIN PAGE BODY -->
            <div class="page-body">
                <div class="container-xl">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-user-square-rounded">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 13a3 3 0 1 0 0 -6a3 3 0 0 0 0 6z" />
                                    <path d="M12 3c7.2 0 9 1.8 9 9s-1.8 9 -9 9s-9 -1.8 -9 -9s1.8 -9 9 -9z" />
                                    <path d="M6 20.05v-.05a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v.05" />
                                </svg>
                                My Profile
                            </div>
                            <form method="POST" class="row g-2" id="frmProfile">
                                <?=csrf_field()?>
                                <input type="hidden" name="cadet_id" value="<?=$cadet['cadet_id'] ?? '' ?>" />
                                <div class="col-lg-12">
                                    <label class="form-label">Complete Name</label>
                                    <p class="form-control"><?=session()->get('fullname')?></p>
                                </div>
                                <div class="col-lg-12">
                                    <div class="row g-2">
                                        <div class="col-lg-2">
                                            <label class="form-label">Birth Date</label>
                                            <input type="date" class="form-control" name="birth_date"
                                                value="<?=$cadet['birthdate'] ?? '' ?>">
                                        </div>
                                        <div class="col-lg-2">
                                            <label class="form-label">Height</label>
                                            <input type="text" class="form-control" name="height"
                                                value="<?=$cadet['height'] ?? '' ?>">
                                        </div>
                                        <div class="col-lg-2">
                                            <label class="form-label">Weight</label>
                                            <input type="text" class="form-control" name="weight"
                                                value="<?=$cadet['weight'] ?? '' ?>">
                                        </div>
                                        <div class="col-lg-2">
                                            <label class="form-label">Blood Type</label>
                                            <input type="text" class="form-control" name="blood_type"
                                                value="<?=$cadet['blood_type'] ?? '' ?>">
                                        </div>
                                        <div class="col-lg-2">
                                            <label class="form-label">Gender</label>
                                            <select class="form-select" name="gender">
                                                <option value="">Choose</option>
                                                <option>Male</option>
                                                <option>Female</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-2">
                                            <label class="form-label">Religion</label>
                                            <input type="text" class="form-control" name="religion"
                                                value="<?=$cadet['religion'] ?? '' ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="row g-2">
                                        <div class="col-lg-3">
                                            <label class="form-label">House No</label>
                                            <input type="text" class="form-control" name="house_no">
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="form-label">Street</label>
                                            <input type="text" class="form-control" name="street">
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label">Village/Subdivision</label>
                                            <input type="text" class="form-control" name="village">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="row g-2">
                                        <div class="col-lg-6">
                                            <label class="form-label">Municipality</label>
                                            <input type="text" class="form-control" name="municipality">
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label">Province</label>
                                            <input type="text" class="form-control" name="province">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="row g-2">
                                        <div class="col-lg-6">
                                            <label class="form-label">Course</label>
                                            <input type="text" class="form-control" name="course">
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="form-label">Year</label>
                                            <input type="text" class="form-control" name="year">
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="form-label">Section</label>
                                            <input type="text" class="form-control" name="section">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <label class="form-label">School Attended</label>
                                    <textarea name="school" class="form-control"></textarea>
                                </div>
                                <div class="col-lg-12">
                                    <div class="row g-2">
                                        <div class="col-lg-4">
                                            <label class="form-label">Contact No</label>
                                            <input type="phone" class="form-control" name="contact_no">
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="form-label">Facebook Account</label>
                                            <input type="text" class="form-control" name="fb_account">
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="form-label">Email Address</label>
                                            <input type="email" class="form-control" name="email">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="card-title">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-users-group">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M10 13a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                            <path d="M8 21v-1a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v1" />
                                            <path d="M15 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                            <path d="M17 10h2a2 2 0 0 1 2 2v1" />
                                            <path d="M5 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                            <path d="M3 13v-1a2 2 0 0 1 2 -2h2" />
                                        </svg>
                                        Other Informations
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="row g-2">
                                        <div class="col-lg-2">
                                            <label>Mother's Surname</label>
                                            <input type="text" class="form-control" name="m_surname">
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Mother's First Name</label>
                                            <input type="text" class="form-control" name="m_firstname">
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Mother's Middlename</label>
                                            <input type="text" class="form-control" name="m_middlename">
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Contact No</label>
                                            <input type="phone" class="form-control" name="m_contact_no">
                                        </div>
                                        <div class="col-lg-4">
                                            <label>Occupation</label>
                                            <input type="text" class="form-control" name="m_occupation">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="row g-2">
                                        <div class="col-lg-2">
                                            <label>Mother's Surname</label>
                                            <input type="text" class="form-control" name="f_surname">
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Father's First Name</label>
                                            <input type="text" class="form-control" name="f_firstname">
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Father's Middlename</label>
                                            <input type="text" class="form-control" name="f_middlename">
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Contact No</label>
                                            <input type="phone" class="form-control" name="f_contact_no">
                                        </div>
                                        <div class="col-lg-4">
                                            <label>Occupation</label>
                                            <input type="text" class="form-control" name="f_occupation">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="card-title">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-user-cog">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                            <path d="M6 21v-2a4 4 0 0 1 4 -4h2.5" />
                                            <path d="M19.001 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                            <path d="M19.001 15.5v1.5" />
                                            <path d="M19.001 21v1.5" />
                                            <path d="M22.032 17.25l-1.299 .75" />
                                            <path d="M17.27 20l-1.3 .75" />
                                            <path d="M15.97 17.25l1.3 .75" />
                                            <path d="M20.733 20l1.3 .75" />
                                        </svg>
                                        Emergency
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <div class="row g-2">
                                        <div class="col-lg-4">
                                            <label class="form-label">Complete Address</label>
                                            <input type="text" class="form-control" name="address">
                                        </div>
                                        <div class="col-lg-2">
                                            <label class="form-label">Relationship</label>
                                            <input type="text" class="form-control" name="relationship">
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="form-label">Contact Person</label>
                                            <input type="text" class="form-control" name="contact_person">
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="form-label">Email Address</label>
                                            <input type="email" class="form-control" name="contact_email">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <button type="submit" class="btn btn-primary" id="btnSave">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-device-floppy">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" />
                                            <path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                            <path d="M14 4l0 4l-6 0l0 -4" />
                                        </svg>
                                        Save Data
                                    </button>
                                </div>
                            </form>
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
                                    Copyright &copy; <?=date('Y')?>
                                    <a href="." class="link-secondary">CvSU-CCC ROTC Unit Portal</a>. All rights
                                    reserved.
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </footer>
            <!--  END FOOTER  -->
        </div>
    </div>
    <?=view('cadet/templates/footer') ?>
</body>

</html>