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
            <h2>Lanjutkan Transaksi Ini?</h2>
            <input type="hidden" name="booth" id="input-value" value="<?= $data; ?>">
            <div class="form-group">
                <label class="form-control-label" for="exampleFormControlInput1">Nominal <span
                        class="text-danger">*</span></label>
                <input type="text" class="form-control" placeholder="Nominal" name="payment" id="nominal-id">
            </div>
            <div class="btn-group">
                <button class="button" type="button" id="button-id" onclick="setNominal(15000)">Rp 15.000,00</button>
                <button class="button" type="button" id="button-id" onclick="setNominal(20000)">Rp
                    20.000,00</button>
                <button class="button" type="button" id="button-id" onclick="setNominal(25000)">Rp
                    25.000,00</button>
                <button class="button" style="margin-left: 20px;" type="submit">Bayar</button>

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
    function setNominal(nominal) {
        document.getElementById("nominal-id").value = nominal;
    }
  </script>
</html>