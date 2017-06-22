<?php
  include 'koneksi.php';

  session_start(); //Memulai session
  if (!isset($_SESSION['login'])) { //Jika session belum diset/user belum login
    header("location: login.php"); //Maka akan dialihkan ke halaman login
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Daftar Penjualan - Toko Zati Parts</title>
    <link rel="shortcut icon" href="images/logo.png" />
    <link rel="stylesheet" href="css/jquery.dataTables.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css" />
    <link rel="stylesheet" href="css/materialize.css" />
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  </head>
  <body>
    <nav>
      <div class="nav-wrapper grey darken-3">
        <a href="index.php" class="brand-logo center">
          <i class="material-icons left">shopping_cart&nbsp;&nbsp;</i>
          <i class="material-icons left">event_note&nbsp;&nbsp;</i>
          <i class="material-icons left">store</i>
          <i class="material-icons right">exit_to_app</i>
          <i class="material-icons right">account_circle</i>
          <i class="material-icons right">assessment</i>
          TOKO ZATI PARTS
        </a>
      </div>
    </nav>
    <div class="container">
      <div class="row">
        <div class="col s12">
          <center><h3>DAFTAR PENJUALAN</h3></center>
        </div>
        <div class="col s12">
          <table class="highlight centered mytable">
            <thead>
              <th>No. Transaksi</th>
              <th>Tanggal</th>
              <th>Nama Konsumen</th>
              <th>Total</th>
            </thead>
            <tbody>
              <?php
                //Mengambil data transaksi dari table penjualan
                $query = $koneksi->prepare("SELECT no_transaksi, tanggal, nama, total FROM penjualan");
                $query->execute();

                while ($row = $query->fetch()) {
                  echo "<tr>
                  <td><a href='detail_penjualan.php?no_transaksi=".$row['no_transaksi']."'>".$row['no_transaksi']."</a></td>
                  <td>".$row['tanggal']."</td>
                  <td>".$row['nama']."</td>
                  <td>Rp. ".number_format($row['total'], 0, '', '.')."</td>
                  </tr>";
                }

                if ($query->rowCount() == 0) {
                  echo "<tr>
                  <td colspan='4'><center>Tidak ada data transaksi penjualan.</center></td>
                  </tr>";
                }
              ?>
            </tbody>
          </table>
        </div>
      </div>
      <strong>*) Pilih pada nomor transaksi untuk melihat transaksi.</strong>
      <div class="row"></div>
      <div class="row">
        <div class="col s6 center">
          <a class="waves-effect waves-light btn red" onclick="reset()"><i class="material-icons left">delete_forever</i>RESET DATA PENJUALAN</a>
        </div>
        <div class="col s6 center">
          <a class="waves-effect waves-light btn blue darken-1" href="index.php"><i class="material-icons left">arrow_forward</i>KEMBALI</a>
        </div>
      </div>
      <div class="row"></div>
      <div class="row"></div>
    </div>
    <script type="text/javascript" src="js/materialize.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function(){
        $('.mytable').DataTable({
          "bLengthChange": false,
          "oLanguage": {
           "sSearch": "Pencarian:",
           "sInfo": "Menampilkan _START_ - _END_ dari _TOTAL_ data",
           "oPaginate": {
             "sPrevious": "Sebelumnya",
             "sNext": "Selanjutnya"
           }
         }
        });
      });

      function reset() {
        swal({
          title: "Anda yakin?",
          text: "Semua data penjualan akan dihapus dari database!<br />Stok Barang yang telah dijual akan tetap di database!",
          html: true,
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Ya, saya yakin!",
          cancelButtonText: "Batal",
          closeOnConfirm: true
        }, function(isConfirm) {
          if (isConfirm) {
            window.location = 'reset_penjualan.php';
          }
        });
      }
    </script>
  </body>
</html>
