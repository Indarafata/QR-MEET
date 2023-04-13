<!DOCTYPE html>
<html>
<head>
   <title>Contoh Menampilkan Data dalam Tabel</title>
   <style>
      table {
         border-collapse: collapse;
         width: 100%;
      }
      th, td {
         text-align: left;
         padding: 8px;
         border-bottom: 1px solid #ddd;
      }
      tr:hover {background-color: #f5f5f5;}
   </style>
</head>
<body>

   <!-- <h1>Contoh Menampilkan Data dalam Tabel</h1> -->

   <table>
      <thead>
         <tr>
            <th>NIP Mahasiswa</th>
            <th>URL Booth</th>
            <th>Tanggal Transaksi</th>
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

</body>
</html>
