<!DOCTYPE html>
<!-- Coding By CodingNepal - youtube.com/codingnepal -->
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">  
    <title>Kantin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Font Awesome CDN Link for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>/assets/css/qr_scanner.css">
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"> -->
    <script src="https://webqr.com/llqrcode.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.css">
  <style>
    input[type=text] {
    border: 2px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
    padding: 12px 16px;
    transition: border-color 0.2s ease-in-out;
    width: 100%;
    }
    input[type=text]:focus {
    border-color: #4CAF50;
    outline: none;
    }
    .btn-group .button:not(:last-child),
.btn-group #button-id:not(:last-child) {
  margin-right: 5px;
}
    </style>
  </head>
  <body>
    <nav>
      <ul>
        <li><a href="#">MANGAN</li>
      </ul>
    </nav>

    <div class="wrapper">
      <form action="<?= site_url('kantin/insert')?>" method="post">
        <!-- <i class="fas fa-hamburger fa-3x text-warning"></i>-->
            <h2>Terima Kasih</h2>
      </form>
    </div>
  </body>

        
    <!-- Font Awesome CDN Link for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>/assets/css/qr_scanner.css">
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"> -->
    <script src="https://webqr.com/llqrcode.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.css">

  <script>
    function setNominal(nominal) {
        document.getElementById("nominal-id").value = nominal;
    }
  </script>
</html>