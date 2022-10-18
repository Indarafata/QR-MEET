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

  <style>
    td{
      font-size: 12px;
    }
  </style>
</head>

<body onload="window.print();window.onafterprint = window.close;">
    <div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">
            <div class="col-lg-6 col-7">
              <h6 class="h2 text-white d-inline-block mb-0">List Absen Meeting</h6>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
      <!-- Table -->
      <div class="row">
        <div class="col">
          <div class="card">
            <div class="text-center mb-5">
                <img src="<?= base_url();?>/assets/img/brand/logo.png" alt="" width="300px">
                <div class="row text-center">
                    <div class="col">
                    <h4>ID MEETING : <?php echo $data2->ID_MEETING?></h4>
                    <h4>NAMA : <?php echo $data2->EVENT?></h4>
                    <h4>TANGGAL : <?php echo date("Y-M-d", strtotime($data2->EVENT_DATE))?></h4>
                    <h4>JAM : <?php echo date("H:i", strtotime($data2->START_DATE))?> - <?php echo date("H:i", strtotime($data2->END_DATE))?></h4>
                    <h4>LOKASI : <?php echo $data2->LOCATION?></h4>
                    </div>
                </div>
            </div>
        <!-- Light table -->
            <div >
              <table style="table-layout: fixed; width: 100%;" border="1" >
                <thead>
                  <tr>
                    <th scope="col">ID USER</th>
                    <th scope="col">USERNAME</th>
                    <th scope="col">ID MEETING</th>
                    <th scope="col">EMAIL</th>
                    <th scope="col">NAMA DEPARTEMENT</th>
                    <th scope="col">COMPANY</th>
                    <th scope="col">JABATAN</th>
                    <th scope="col">CHECKIN DATE</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    foreach($data as $data)
                    {
                  ?>
                    <tr>
                      <td scope="col"><?php echo $data->ID_USER?></td> 
                      <td scope="col"><?php echo $data->ID_MEETING ?></td> 
                      <td scope="col"><?php echo $data->NAME ?></td>                                   
                      <td scope="col"><?php echo $data->EMAIL?></td>   
                      <td scope="col"><?php echo $data->ID_DEPT?></td>                                     
                      <td scope="col"><?php echo $data->COMPANY?></td>
                      <td scope="col"><?php echo $data->NAMA_SEK?></td>
                      <td scope="col"><?php echo $data->CHECKIN_DATE?></td>
                    </tr>
                  <?php
                    }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
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
   