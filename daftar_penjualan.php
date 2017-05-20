<?php
  include 'koneksi.php';

  $query = $koneksi->prepare("SELECT no_transaksi, tanggal, nama, total FROM penjualan");
  $query->execute();

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>DAFTAR PENJUALAN</title>
    <link rel="stylesheet" href="css/jquery.dataTables.css" />
    <link rel="stylesheet" href="css/materialize.min.css" />
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="js/jquery.dataTables.js"></script>
  </head>
  <body>

    <nav>
        <div class="nav-wrapper grey darken-3">
            <a href="index.php" class="brand-logo">Logo</a>
            <ul id="nav-mobile" class="right hide-on-med-and-down">
                <li class="active"><a href="#">Transaksi</a></li>
                <li><a href="">Edit Transaksi</a></li>
                <li><a href="">Edit Inventory</a></li>
                <li><a href="">Daftar Transaksi</a></li>
                <li><a href="">Daftar Inventory</a></li>
                <li><a href="">Laporan Inventory</a></li>
            </ul>
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
                while ($row = $query->fetch()) {
                  echo "<tr>
                  <td><a href='lihat_penjualan.php?no_transaksi=".$row['no_transaksi']."'>".$row['no_transaksi']."</a></td>
                  <td>".$row['tanggal']."</td>
                  <td>".$row['nama']."</td>
                  <td>Rp. ".number_format($row['total'], 0, '', '.')."</td>
                  </tr>";
                }

                if ($query->rowCount() == 0) {
                  echo "<tr>
                  <td colspan = '4'><center>Tidak ada data transaksi penjualan.</center></td>
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
          <a class="waves-effect waves-light btn blue darken-1" href="reset_transaksi.php">RESET TRANSAKSI</a>
        </div>
        <div class="col s6 center">
          <a class="waves-effect waves-light btn blue darken-1" href="index.php">KEMBALI</a>
        </div>
      </div>
      <div class="row"></div>
      <div class="row"></div>
    </div>
  </body>
  <script type="text/javascript">
    $(document).ready(function(){
      $('.mytable').DataTable();
    });
  </script>
</html>
