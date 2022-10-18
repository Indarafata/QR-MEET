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
    <!-- Main content -->
    <div class="main-content" id="panel">
      <div class="header bg-primary pb-6">
        <div class="container-fluid">
          <div class="header-body">
            <div class="row align-items-center py-4">
              <div class="col-lg-6 col-7">
                <h6 class="h2 text-white d-inline-block mb-0">Form Pendaftaran</h6>
              </div>
            </div>
          </div>
        </div>
      </div>
    <!-- Page content -->
        <div class="container-fluid mt--6">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card-wrapper">
                        <!-- Form controls -->
                        <div class="card">
                        <!-- Card header -->
                            <div class="card-header">
                                <h3 class="mb-0">Form Pendaftaran User Baru</h3>
                            </div>
                            <!-- Card body -->
                              <div class="card-body">
                              <?php
                                     if($error != '')
                                     {
                                  echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                                    echo '<span class="alert-icon"><i class="ni ni-air-baloon"></i></span>';
                                    echo '<span class="alert-text"><strong>'.$error.'</strong></span>';
                                      echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
                                        echo '<span aria-hidden="true">&times;</span>';
                                      echo '</button>';
                                  echo '</div>';
                                     }
                                  ?>


                                  <?php
                                     if($success != '')
                                     {
                                  echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
                                    echo '<span class="alert-icon"><i class="ni ni-like-2"></i></span>';
                                    echo '<span class="alert-text"><strong>'.$success.'</strong></span>';
                                      echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
                                        echo '<span aria-hidden="true">&times;</span>';
                                      echo '</button>';
                                  echo '</div>';
                                     }
                                  ?>

                                  <?php
                                     if($success=='' and $txt_email !='')
                                     {
                                  echo '<div class="alert alert-info alert-dismissible fade show" role="alert">';
                                    echo '<span class="alert-icon"><i class="ni ni-air-baloon"></i></span>';
                                    echo '<span class="alert-text"><strong>Data Email '.$txt_email.' belum terdaftar , silahkan registrasi form dibawah ini</strong></span>';
                                      echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
                                        echo '<span aria-hidden="true">&times;</span>';
                                      echo '</button>';
                                  echo '</div>';
                                     }
                                  ?>


                                  <?php
                                     if($success=='' and  $txt_telp !='')
                                     {
                                  echo '<div class="alert alert-info alert-dismissible fade show" role="alert">';
                                    echo '<span class="alert-icon"><i class="ni ni-air-baloon"></i></span>';
                                    echo '<span class="alert-text"><strong>Data Telepon '.$txt_telp.' belum terdaftar , silahkan registrasi form dibawah ini</strong></span>';
                                      echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
                                        echo '<span aria-hidden="true">&times;</span>';
                                      echo '</button>';
                                  echo '</div>';
                                     }
                                  ?>

                                  <form action="<?php echo base_url();?>index.php/user/savexd" method="post">
                                      <div class="form-group">
                                          <label class="form-control-label" for="exampleFormControlInput1">Nama <span class="text-danger">*</span></label>
                                          <input type="text" class="form-control"  placeholder="Masukan Nama" name="txt_user">
                                          <input type="hidden" class="form-control" name="txt_id" id="txt_id" value="<?php echo $id?>" class="form-control col-md-7 col-xs-12">
                                          <input type="hidden" class="form-control" name="txt_ket" value="1" id="txt_ket" class="form-control col-md-7 col-xs-12">
                                      </div>
                                      <div class="form-group">
                                          <label class="form-control-label" for="exampleFormControlInput1">No Telepon <span class="text-danger">*</span></label>
                                          <input type="number" class="form-control"  placeholder="Masukan No Telp" value="<?php echo $txt_telp?>" name="txt_telp">
                                      </div>
                                      <div class="form-group">
                                          <label class="form-control-label" for="exampleFormControlInput1">Email <span class="text-danger">*</span></label>
                                          <input type="email" class="form-control"  placeholder="Masukan Email" value="<?php echo $txt_email?>" name="txt_email">
                                      </div>
                                      <div class="form-group">
                                          <label class="form-control-label" for="exampleFormControlInput1">Nama PT <span class="text-danger">*</span></label>
                                          <input type="text" class="form-control"  placeholder="Masukan Nama PT" name="txt_pt">
                                      </div>
                                      <button type="submit" class="btn btn-success btn-block">Submit</button>
                                  </form>
                              </div>
                        </div>
                    </div>
                </div>         
            </div>
        </div>
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
