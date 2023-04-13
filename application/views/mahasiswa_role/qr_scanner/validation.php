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
        <!-- bootstrap tabel -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"> -->
    <script src="https://webqr.com/llqrcode.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.css">

  <style>
    table {
    border-collapse: collapse;
    width: 100%;
    }
    td {
  word-wrap: break-word;
  word-break: break-all;
  }
    th, td {
        text-align: left;
        padding: 8px;
        border-bottom: 1px solid #ddd;
        color: black;
        text-decoration: none;
    }
    tr:hover {background-color: #f5f5f5;}
  </style>
  </head>
  <body>
    <nav>
      <ul>
        <li><a href="#">MANGAN</li>
      </ul>
    </nav>
<br>

   <div class="container">
      <!-- <h2>Tabel dengan Header Dark</h2> -->
      <table class="table">
        <thead class="thead-dark">
          <tr>
            <!-- <th scope="col">#</th>
            <th scope="col">First</th>
            <th scope="col">Last</th>
            <th scope="col">Handle</th> -->
            <th scope="col">NIP Mahasiswa</th>
            <th scope="col">URL Booth</th>
            <th scope="col">Tanggal Transaksi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($data as $row) : ?>
            <tr>
              <td><?= $row->NIP_MAHASISWA ?></td>
              <td><?= $row->URL_BOOTH ?></td>
              <td><?= $row->CREATED_DATE ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </body>
  <script>
      window.onload = function() {
        // Mengambil query string dari URL
        const queryString = window.location.search;

        // Parsing nilai parameter dari query string
        const urlParams = new URLSearchParams(queryString);
        const value = urlParams.get('value');

        // Menampilkan nilai parameter
        console.log(value);

        if(value == "true"){

          Swal.fire({
            title: 'Transaksi berhasil',
            icon: 'success',
            // showCancelButton: true,
            confirmButtonText: 'Ok',
            // cancelButtonText: 'Ga dulu'
        }).then((resultSwal) => {
            if (resultSwal.isConfirmed) {
            // logika untuk mengirim data ke server
            
            }
        });
    }
    else if(value == "qrfalse"){
      Swal.fire({
            title: 'Transaksi Gagal QR Code Tidak Valid',
            icon: 'error',
            // showCancelButton: true,
            confirmButtonText: 'Ok',
            // cancelButtonText: 'Ga dulu'
        }).then((resultSwal) => {
            if (resultSwal.isConfirmed) {
            // logika untuk mengirim data ke server
            window.location.replace('https://qrmeet.test/index.php/kantin');
            }
        });
    }
    else{
        Swal.fire({
            title: 'Transaksi Gagal Anda Sudah Mangan',
            icon: 'error',
            // showCancelButton: true,
            confirmButtonText: 'Ok',
            // cancelButtonText: 'Ga dulu'
        }).then((resultSwal) => {
            if (resultSwal.isConfirmed) {
            // logika untuk mengirim data ke server
            window.location.replace('https://qrmeet.test/index.php/kantin');
            }
        });
    }
        }
  </script>
</html>