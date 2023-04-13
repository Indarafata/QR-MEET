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
          <h2>Anda Yakin Ingin Melanjutkan Transaksi Ini?</h2>
          <input type="hidden" name="booth" id="input-value">    
        <div class="btn-group">
          <button class="button" type="button" id="button-id" onclick="goBack()">Kembali</button>
          <button class="button" style="margin-left: 20px;" type="submit">Lanjutkan</button>
        </div>
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
    window.onload = function() {
      // Mengambil query string dari URL
      const queryString = window.location.search;

      // Parsing nilai parameter dari query string
      const urlParams = new URLSearchParams(queryString);
      const value = urlParams.get('value');

      // Menampilkan nilai parameter
      console.log(value);

      // Menetapkan nilai input dengan nilai parameter
      const input = document.getElementById('input-value');
      input.value = value;
    }

    function goBack() {
      event.preventDefault(); // Mencegah pengiriman formulir
      window.history.back(); // Kembali ke halaman sebelumnya
    }
  </script>
</html>