<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
        <meta name="author" content="Creative Tim">
        <title>Argon Dashboard PRO - Premium Bootstrap 4 Admin Template</title>
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

    <body>
        <div class="page-wrapper-img">
            <div class="page-wrapper-img-inner">
                
                <!-- Page-Title -->
                
                <!-- end page title end breadcrumb -->
            </div><!--end page-wrapper-img-inner-->
        </div><!--end page-wrapper-img-->
        
        <div class="page-wrapper">
            <div class="page-wrapper-inner">

                <!-- Page Content-->
                <div class="page-content">
                    <div class="container-fluid"> 
                        
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row d-flex justify-content-center">
                                            <h5>PILIH ROLE ANDA</h5>
                                        </div><!-- End portfolio  -->
                                    </div><!--end card-body-->
                                </div><!--end card-->
                                
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row  d-flex justify-content-center">
                                            <form novalidate="" action="<?= site_url('login/chooserole') ?>" method="POST">
                                                <div class="form-group">
                                                    <select name="role" class="form-control" id="role">
                                                        <?php foreach ($hakakses as $i => $val) : ?>
                                                            <option value="<?= $val ?>"><?= $hakakses_desc[$i] ?></option>
                                                        <?php endforeach ?>
                                                    </select>
                                                </div>
                                                <center>
                                                <div class="row no-gutters">
                                                    <div class="col-md-12">
                                                        <button id="js-login-btn" type="submit" class="btn btn-primary btn-block btn-lg">Choose</button>
                                                    </div>
                                                </div>
                                                </center>
                                            </form> 
                                        </div><!--end row-->
                                    </div><!--end card-body-->
                                </div><!--end card-->
                            </div><!--end col-->
                        </div><!--end row-->          
            
                    </div><!-- container -->
                </div>
                <!-- end page content -->
            </div>
            <!--end page-wrapper-inner -->
        </div>
        <!-- end page-wrapper -->

        <script src="<?php echo base_url() ?>/assets/vendor/jquery/dist/jquery.min.js"></script>
        <script src="<?php echo base_url() ?>/assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        <script src="<?php echo base_url() ?>/assets/vendor/js-cookie/js.cookie.js"></script>
        <script src="<?php echo base_url() ?>/assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js"></script>
        <script src="<?php echo base_url() ?>/assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js"></script>
        <!-- Argon JS -->
        <script src="<?php echo base_url() ?>/assets/js/argon.js?v=1.1.0"></script>
        <!-- Demo JS - remove this in your project -->
        <script src="<?php echo base_url() ?>/assets/js/demo.min.js"></script>

        <script>
             $(window).on('load', function() {
                // Filter 
                //PORTFOLIO FILTER 
                var $container = $('.projects-wrapper');
                var $filter = $('#filter');
                // Initialize isotope 
                $container.isotope({
                    filter: '*',
                    layoutMode: 'masonry',
                    animationOptions: {
                        duration: 750,
                        easing: 'linear'
                    }
                });
                // Filter items when filter link is clicked
                $filter.find('a').click(function() {
                    var selector = $(this).attr('data-filter');
                    $filter.find('a').removeClass('active');
                    $(this).addClass('active');
                    $container.isotope({
                        filter: selector,
                        animationOptions: {
                            animationDuration: 750,
                            easing: 'linear',
                            queue: false,
                        }
                    });
                    return false;
                });
                /*END*/
            });
            $('.mfp-image').magnificPopup({
                type: 'image',
                closeOnContentClick: true,
                mainClass: 'mfp-fade',
                gallery: {
                    enabled: true,
                    navigateByImgClick: true,
                    preload: [0, 1]
                        // Will preload 0 - before current, and 1 after the current image 
                }
            });
        </script>

    </body>
</html>