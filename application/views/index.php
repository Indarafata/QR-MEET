<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
  <meta name="author" content="Creative Tim">
  <title>QRMeet &#8226 Terminal Teluk Lamong</title>
  <!-- Favicon -->
  <link rel="icon" href="<?php echo base_url();?>/assets/img/brand/favicon.png" type="image/png">
  <!-- Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
  <!-- Icons -->
  <link rel="stylesheet" href="<?php echo base_url();?>/assets/vendor/nucleo/css/nucleo.css" type="text/css">
  <link rel="stylesheet" href="<?php echo base_url();?>/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css" type="text/css">
   <!-- Page plugins -->
  <link rel="stylesheet" href="<?php echo base_url();?>/assets/vendor/select2/dist/css/select2.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>/assets/vendor/quill/dist/quill.core.css">
  <!-- Page plugins -->
  <!-- Argon CSS -->
  <link rel="stylesheet" href="<?php echo base_url();?>/assets/css/argon.css?v=1.1.0" type="text/css">
  <link href="<?= base_url() ?>/assets/plugins/jquery-multi-select/css/multi-select.css" rel="stylesheet" type="text/css" /> 

  <!-- Page plugins -->
  <link rel="stylesheet" href="<?php echo base_url();?>/assets/vendor/animate.css/animate.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>/assets/vendor/sweetalert2/dist/sweetalert2.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>/assets/vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>/assets/vendor/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>/assets/vendor/datatables.net-select-bs4/css/select.bootstrap4.min.css">
  <style>
    #datatable-buttons_filter{
      display: none;
    }
    #datatable-basic_filter{
      display: none;
    }
  </style>

  <script src="<?php echo base_url();?>/assets/vendor/jquery/dist/jquery.min.js"></script>
  <script src="<?= base_url() ?>/assets/plugins/jquery-multi-select/js/jquery.multi-select.js" type="text/javascript"></script>

  <!-- Optional JS -->
  <script src="<?php echo base_url();?>/assets/vendor/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="<?php echo base_url();?>/assets/vendor/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="<?php echo base_url();?>/assets/vendor/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
  <script src="<?php echo base_url();?>/assets/vendor/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
  <script src="<?php echo base_url();?>/assets/vendor/datatables.net-buttons/js/buttons.html5.min.js"></script>
  <script src="<?php echo base_url();?>/assets/vendor/datatables.net-buttons/js/buttons.flash.min.js"></script>
  <script src="<?php echo base_url();?>/assets/vendor/datatables.net-buttons/js/buttons.print.min.js"></script>
  <script src="<?php echo base_url();?>/assets/vendor/datatables.net-select/js/dataTables.select.min.js"></script>
 
</head>

<body>
  <!-- Sidenav -->
  <nav class="sidenav navbar navbar-vertical fixed-left navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
      <!-- Brand -->
      <div class="sidenav-header d-flex align-items-center">
        <a class="navbar-brand" href="#">
          <img src="<?php echo base_url();?>/assets/img/brand/qrmeet.png" class="navbar-brand-img" alt="...">
        </a>
        <div class="ml-auto">
          <!-- Sidenav toggler -->
          <div class="sidenav-toggler d-none d-xl-block" data-action="sidenav-unpin" data-target="#sidenav-main">
            <div class="sidenav-toggler-inner">
              <i class="sidenav-toggler-line"></i>
              <i class="sidenav-toggler-line"></i>
              <i class="sidenav-toggler-line"></i>
            </div>
          </div>
        </div>
      </div>
      <div class="navbar-inner">
        <?php $this->load->view('menu') ?>
      </div>
    </div>
  </nav>
  <!-- Main content -->
  <div class="main-content" id="panel">
    <!-- Topnav -->
    <nav class="navbar navbar-top navbar-expand navbar-dark bg-primary border-bottom">
      <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <!-- Navbar links -->
          <ul class="navbar-nav align-items-center ml-md-auto">
            <li class="nav-item d-xl-none">
              <!-- Sidenav toggler -->
              <div class="pr-3 sidenav-toggler sidenav-toggler-dark" data-action="sidenav-pin" data-target="#sidenav-main">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                </div>
              </div>
            </li>
          </ul>
          <ul class="navbar-nav align-items-center ml-auto ml-md-0">
            <li class="nav-item dropdown">
              <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <div class="media align-items-center">
                  <span class="avatar avatar-sm rounded-circle">
                    <img alt="Image placeholder" src="<?=base_url();?>/assets/img/theme/vector_user.jpg">
                  </span>
                  <div class="media-body ml-2 d-none d-lg-block">
                  <span class="mb-0 text-sm  font-weight-bold"><?= $this->session->userdata('session_meeting')->HAKAKSES_ACTIVE->NAMA ?></span>
                  </div>
                </div>
              </a>
              <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-header noti-title">
                  <h5 class="text-overflow m-0">Welcome! <br> <b><?= $this->session->userdata('session_meeting')->NAMA ? substr($this->session->userdata('session_meeting')->NAMA, 0, 100) : 'X' ?></b></h5>
                </div>
                <a href="#" class="dropdown-item">
                  <i class="ni ni-single-02"></i>
                  <span><?= $this->session->userdata('session_meeting')->HAKAKSES_ACTIVE->NAMA ?></span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="<?= site_url('login/logout') ?>" class="dropdown-item">
                  <i class="ni ni-button-power"></i>
                  <span>Logout</span>
                </a>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </nav>
        <?php $this->load->view($content); ?>      
      <!-- Page content -->
    <div class="container-fluid mt--5">
      <!-- Footer -->
      <footer class="footer pt-5">
        <div class="row align-items-center justify-content-lg-between">
          <div class="col-lg-6">
            <div class="copyright text-center text-lg-left text-muted">
              &copy; 2019 <a href="https://www.creative-tim.com" class="font-weight-bold ml-1" target="_blank">Creative Tim</a>
            </div>
          </div>
          <div class="col-lg-6">
            <ul class="nav nav-footer justify-content-center justify-content-lg-end">
              <li class="nav-item">
                <a href="https://www.creative-tim.com" class="nav-link" target="_blank">Creative Tim</a>
              </li>
              <li class="nav-item">
                <a href="https://www.creative-tim.com/presentation" class="nav-link" target="_blank">About Us</a>
              </li>
              <li class="nav-item">
                <a href="http://blog.creative-tim.com" class="nav-link" target="_blank">Blog</a>
              </li>
              <li class="nav-item">
                <a href="https://www.creative-tim.com/license" class="nav-link" target="_blank">License</a>
              </li>
            </ul>
          </div>
        </div>
      </footer>
    </div>
  </div>
  </div>
  <!-- Argon Scripts -->
  <!-- Core -->
  <!-- Optional JS -->
  <script src="<?php echo base_url();?>/assets/vendor/select2/dist/js/select2.min.js"></script>
  <script src="<?php echo base_url();?>/assets/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
  <script src="<?php echo base_url();?>/assets/vendor/nouislider/distribute/nouislider.min.js"></script>
  <script src="<?php echo base_url();?>/assets/vendor/quill/dist/quill.min.js"></script>
  <script src="<?php echo base_url();?>/assets/vendor/dropzone/dist/min/dropzone.min.js"></script>
  <script src="<?php echo base_url();?>/assets/vendor/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
  <script src="<?php echo base_url();?>/assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo base_url();?>/assets/vendor/js-cookie/js.cookie.js"></script>
  <script src="<?php echo base_url();?>/assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js"></script>
  <script src="<?php echo base_url();?>/assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js"></script>
  <!-- Optional JS -->
  <script src="<?php echo base_url();?>/assets/vendor/chart.js/dist/Chart.min.js"></script>
  <script src="<?php echo base_url();?>/assets/vendor/chart.js/dist/Chart.extension.js"></script>
   <!-- Optional JS -->
   <script src="<?php echo base_url();?>/assets/vendor/sweetalert2/dist/sweetalert2.min.js"></script>
  <script src="<?php echo base_url();?>/assets/vendor/bootstrap-notify/bootstrap-notify.min.js"></script>
  <!-- Argon JS -->
  <script src="<?php echo base_url();?>/assets/js/argon.js?v=1.1.0"></script>
  <!-- Demo JS - remove this in your project -->
  <script src="<?php echo base_url();?>/assets/js/demo.min.js"></script>
</body>

</html>