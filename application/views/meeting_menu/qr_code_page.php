<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
  <meta name="author" content="Creative Tim">
  <title><?php echo $data->EVENT?></title>
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

<body onload="window.print();">
    <div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">
            <div class="col-lg-6 col-7">
              <h6 class="h2 text-white d-inline-block mb-0">QR CODE</h6>
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
                        <h1 style="font-size:30px;font-weight:bolder"><?php echo $data->EVENT ?></h1>
                        <br>
                        <h4>TANGGAL : <?php echo date("Y-M-d" , strtotime($data->EVENT_DATE))?></h4>
                        <h4>LOKASI : <?php echo $data->LOCATION ?></h4>
                    </div>
                </div>
                <div class="text-center">
                    <img src="<?= base_url();?>/temp/qr/<?php echo $data->FILE_QR ?>" style="display:block;margin-left:auto;margin-right:auto;width:70%">
                    <br>
                    <h4>Link URL</h4>
                    <h4 style="font-size:20px;font-weight:bolder"><?php echo $data->URL_QR?></h4>
                </div>
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

  <script>
    $url = window.location.href
    $split =$url.split("/");
    for(var i = 0 ; i < $split.length ; i++){
        $url = ($split[i])
    }

    $(document).ready(function() {
        showData($url);
        showList($url);
    });
     // funsgi menampilkan data kedalam input html
     function showData($url){
        $.ajax({
            type  : 'GET',
            url   : '<?php echo base_url('index.php/')?>meeting_menu/meeting_detail/'+$url,
            async : false,
            dataType : 'json',
            success : function(data){
              
                $("#kode").text('ID MEETING : '+data.ID_MEETING);
                $("#nama").text('NAMA MEETING : '+data.EVENT);
                $("#tanggal").text('TANGGAL MEETING : '+data.EVENT_DATE);
                $("#lokasi").text('LOKASI MEETING : '+data.LOCATION);
                var a = document.getElementById('print'); //or grab it by tagname etc
                a.href = "<?php echo site_url();?>/meeting_menu/list_print_absen_page/"+data.ID_MEETING;
            }
        });
    }
  </script>
</body>

</html>
   