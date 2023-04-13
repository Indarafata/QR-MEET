<!DOCTYPE html>
<!-- Coding By CodingNepal - youtube.com/codingnepal -->
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Kantin</title>
  <link rel="stylesheet" href="<?php echo base_url() ?>/assets/css/qr_scanner.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Font Awesome CDN Link for Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
  <script src="https://webqr.com/llqrcode.js"></script>
  <script src="<?php echo base_url() ?>/assets/js/script_qrcode.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.css">
  <meta http-equiv="Cache-control" content="no-cache">
  <meta http-equiv="Expires" content="-1">
  <meta http-equiv="Pragma" content="no-cache">

</head>

<body>
  <nav>
    <ul>
      <li><a href="#">MANGAN</a></li>
    </ul>
  </nav>

  <div class="wrapper">
    <form action="#">
      <div class="content">
        <div id="qrcodescanner"></div>
      </div>

    </form>
    <div type="" id="message"></div>
</body>
  <script>
    window.onload = function() {
      QRCodeScanner({
        element: document.getElementById('qrcodescanner'),
        width: 300,
        height: 300,
        onScanSuccess: function(result) {
          // console.log('Scan Success', result);
          // document.getElementById('message').textContent = result;
          $(location).prop('href', 'https://qrmeet.test/index.php/kantin/confirmation?value='+result)

          
          window.location.replace('https://qrmeet.test/index.php/kantin/confirmation?value='+result);
          // $this->load->view('mahasiswa_role/qr_scanner/confirmation');

      //     Swal.fire({
      //   title: 'Anda yakin ingin meneruskan transaksi ini?',
      //   icon: 'warning',
      //   showCancelButton: true,
      //   confirmButtonText: 'GAS AKU LUWE',
      //   cancelButtonText: 'Ga dulu'
      // }).then((resultSwal) => {
      //   if (resultSwal.isConfirmed) {
      //     // logika untuk mengirim data ke server
          
      //   }
      // });
      // scanner.stop();
      // stopScan();
      // clearTimeout(scanTimeout);
      // scanTimeout = undefined;

        },
        onScanError: function(error) {
          console.log('Scan Error', error);
          // document.getElementById('message').textContent = 'No QR Code found';
        }
      });
    }
      </script>

</html>