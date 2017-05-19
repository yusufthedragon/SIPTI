<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>DAFTAR BARANG</title>
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
          <center><h3>DAFTAR BARANG</h3></center>
        </div>
        <table class="centered striped mytable">
          <thead>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Harga Barang</th>
            <th>Stok Barang</th>
          </thead>
          <tbody>
            <?php
              include 'koneksi.php';

              $query = $koneksi->prepare("SELECT kode_barang, nama_barang, harga, stok FROM inventory");
              $query->execute();

              while ($row = $query->fetch()) {
                echo "<tr>
                <td>".$row['kode_barang']."</td>
                <td>".$row['nama_barang']."</td>
                <td> Rp. ".number_format($row['harga'], 0, ".", ".")."</td>
                <td>".$row['stok']."</td>
                </tr>";
              }
            ?>
          </tbody>
        </table>
      </div>
      <div class="row"></div>
      <div class="row">
        <div class="col s3 l3 center">
          <a class="waves-effect waves-light btn blue darken-1" href="tambah_barang.php">TAMBAH BARANG</a>
        </div>
        <div class="col s3 l3 center">
          <a class="waves-effect waves-light btn blue darken-1" href="edit_barang.php">EDIT BARANG</a>
        </div>
        <div class="col s3 l3 center">
          <a class="waves-effect waves-light btn blue darken-1" href="hapus_barang.php">HAPUS BARANG</a>
        </div>
        <div class="col s3 l3 center">
          <a class="waves-effect waves-light btn blue darken-1" href="index.php">KEMBALI</a>
        </div>
      </div>
      <div class="row"></div>
    </div>
  </body>
  <script type="text/javascript">
    $(document).ready(function(){
      $('.mytable').DataTable();
    });
    </script>
</html>
