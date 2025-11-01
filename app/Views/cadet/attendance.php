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
                    <div class="row g-3">
                        <div class="col-lg-9">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-chart-histogram">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M3 3v18h18" />
                                            <path d="M20 18v3" />
                                            <path d="M16 16v5" />
                                            <path d="M12 13v8" />
                                            <path d="M8 16v5" />
                                            <path d="M3 11c6 0 5 -5 9 -5s3 5 9 5" />
                                        </svg>
                                        Attendance Chart
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-clock">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M10.5 21h-4.5a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v3" />
                                            <path d="M16 3v4" />
                                            <path d="M8 3v4" />
                                            <path d="M4 11h10" />
                                            <path d="M18 18m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                                            <path d="M18 16.5v1.5l.5 .5" />
                                        </svg>
                                        Recent
                                    </div>
                                </div>
                                <div class="list-group list-group-flush">
                                    <?php if(empty($attendance)): ?>
                                    <div class="list-group-item">
                                        <div class="text-center text-muted py-3">
                                            No attendance found
                                        </div>
                                    </div>
                                    <?php else :?>
                                    <?php foreach($attendance as $row): ?>
                                    <div class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col text-truncate">
                                                <a href="javascript:void(0);"
                                                    class="text-reset d-block"><?=date('F d, Y',strtotime($row['date']))?></a>
                                                <div class="d-block text-secondary text-truncate mt-n1">
                                                    <?=date('h:i:s a',strtotime($row['time']))?> | Status :
                                                    <?=$row['remarks']?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach;?>
                                    <?php endif;?>
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