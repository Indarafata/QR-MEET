<!-- =========================================================
* Argon Dashboard PRO v1.1.0
=========================================================

* Product Page: https://www.creative-tim.com/product/argon-dashboard-pro
* Copyright 2019 Creative Tim (https://www.creative-tim.com)

* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
 -->
 <!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
  <meta name="author" content="Creative Tim">
  <title>QRMeet &#8226 Terminal Teluk Lamong</title>
  <!-- Favicon -->
  <link rel="icon" href="<?php echo base_url() ?>/assets/img/brand/favicon.png" type="image/png">
  <!-- Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
  <!-- Icons -->
  <link rel="stylesheet" href="<?php echo base_url() ?>/assets/vendor/nucleo/css/nucleo.css" type="text/css">
  <link rel="stylesheet" href="<?php echo base_url() ?>/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css" type="text/css">
  <!-- Argon CSS -->
  <link rel="stylesheet" href="<?php echo base_url() ?>/assets/css/argon.css?v=1.1.0" type="text/css">
</head>

<body class="bg-default">
  <!-- Navbar -->
  <!-- Main content -->
  <div class="main-content">
 
    <!-- Header -->
    <div class="header bg-gradient-primary py-7 py-lg-10 pt-lg-5">
      <div class="container">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
              <span class="alert-icon"><i class="ni ni-air-baloon"></i></span>
              <span class="alert-text"><strong>New Update! </strong><br> Sign In Menggunakan<strong> Akun SITTL</strong></span>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
      </div>
      <div class="container">
        <div class="header-body text-center mb-7">
          <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6 col-md-8 px-5">
              <h1 class="text-white">Welcome!</h1>
              <p class="text-lead text-white">Membuat Absensi Untuk Sebuah Acara & Meeting Menggunakan Aplikasi Qr Meet</p>
            </div>
          </div>
        </div>
      </div>
      <div class="separator separator-bottom separator-skew zindex-100">
        <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
          <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
        </svg>
      </div>
    </div>
    <!-- Page content -->
    <div class="container mt--8 pb-5">
      <div class="row justify-content-center">
        <div class="col-lg-10 col-md-7">
          <div class="card bg-secondary border-0 mb-0">
            <div class="card-body px-lg-5 py-lg-5">
            <?= $this->session->flashdata('message') ?>
              <div class="text-center text-muted mb-4">
                <small>Sign In QRMEET &#8226 PT Terminal Teluk Lamong</small>
              </div>
              <form role="form" action="<?= site_url('login/index') ?>" method="post">
                <div class="form-group mb-3">
                  <div class="input-group input-group-merge input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                    </div>
                    <input class="form-control" name="username" placeholder="Username" required>
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group input-group-merge input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                    </div>
                    <input class="form-control" type="password" id="password" name="password" placeholder="Password" required>
                  </div>
                </div>

                <div class="form-group" style="margin-top: 10px">
                    <div class="row">
                        <div class="col-md-6">
                            <div id="btn_reset_captcha" class="btn btn-warning waves-effect waves-light btn-elevate btn-pill btn-sm" style="position: absolute;" title="Refresh Captcha">
                                <i class="ni ni-ui-04 text-white"></i>
                            </div>
                            <div id="div_captcha">
                                <?= $img; ?>
                            </div>
                        </div>
                    </div>
                </div>   

                <div class="form-group">
                  <div class="input-group input-group-merge input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-caps-small"></i></span>
                    </div>
                    <input class="form-control" placeholder="Captcha" name="captcha" required>
                  </div>
                </div>
                
                <div class="text-center">
                  <button type="submit" class="btn btn-primary btn-block my-12">Login</button>
                </div>
              </form>
            </div>
          </div>
          <!-- <div class="row mt-3">
            <div class="col-6">
              <a href="#" class="text-light"><small>Forgot password?</small></a>
            </div>
            <div class="col-6 text-right">
              <a href="#" class="text-light"><small>Create new account</small></a>
            </div>
          </div> -->
        </div>
      </div>
    </div>
  </div>
 
  <script src="<?php echo base_url() ?>/assets/vendor/jquery/dist/jquery.min.js"></script>

    <script type="text/javascript">
        var site_url = '<?= site_url() ?>';
        $('#btn_reset_captcha').click(function() {
            console.log('object :>> ');
            $.ajax({
                url: site_url + '/login/recaptcha',
                type: "POST",
                dataType: "json",
                async: false,
                success: function(result) {
                    $('#div_captcha').html(result.data);
                }
            });
        });
    </script>
  
  <script src="<?php echo base_url() ?>/assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo base_url() ?>/assets/vendor/js-cookie/js.cookie.js"></script>
  <script src="<?php echo base_url() ?>/assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js"></script>
  <script src="<?php echo base_url() ?>/assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js"></script>
  <!-- Argon JS -->
  <script src="<?php echo base_url() ?>/assets/js/argon.js?v=1.1.0"></script>
  <!-- Demo JS - remove this in your project -->
  <script src="<?php echo base_url() ?>/assets/js/demo.min.js"></script>
  
</body>

</html>