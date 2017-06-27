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
    <title>Daftar Inventory - Toko Zati Parts</title>
    <link rel="shortcut icon" href="images/logo.png" />
    <link rel="stylesheet" href="css/jquery.dataTables.css" />
    <link rel="stylesheet" href="css/materialize.css" />
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script type="text/javascript" src="js/materialize.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="js/jquery.dataTables.js"></script>
  </head>
  <body>
    <nav>
      <div class="nav-wrapper grey darken-3">
        <a href="index.php" class="brand-logo center">
          <i class="material-icons left hide-on-med-and-down">shopping_cart&nbsp;&nbsp;</i>
          <i class="material-icons left hide-on-med-and-down">event_note&nbsp;&nbsp;</i>
          <i class="material-icons left hide-on-med-and-down">store</i>
          <i class="material-icons right hide-on-med-and-down">exit_to_app</i>
          <i class="material-icons right hide-on-med-and-down">account_circle</i>
          <i class="material-icons right hide-on-med-and-down">assessment</i>
          TOKO ZATI PARTS
        </a>
      </div>
    </nav>
    <div class="container">
      <div class="row">
        <div class="col s12">
          <center><h3>DAFTAR INVENTORY</h3></center>
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
              //Mengambil data barang yang ada di Inventory
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

              if ($query->rowCount() == 0) {
                echo "<tr>
                <td colspan='4'><center>Tidak ada data barang.</center></td>
                </tr>";
              }
            ?>
          </tbody>
        </table>
      </div>
      <div class="row"></div>
      <div class="row">
        <div class="col s12 m3 l3 center">
          <a class="waves-effect waves-light btn green accent-4" href="tambah_barang.php"><i class="material-icons left">add</i>TAMBAH DATA</a>
          <div class="row"></div>
        </div>
        <div class="col s12 m3 l3 center">
          <a class="waves-effect waves-light btn green accent-4" href="edit_barang.php"><i class="material-icons left">edit</i>EDIT DATA</a>
          <div class="row"></div>
        </div>
        <div class="col s12 m3 l3 center">
          <a class="waves-effect waves-light btn red" href="hapus_barang.php"><i class="material-icons left">delete</i>HAPUS DATA</a>
          <div class="row"></div>
        </div>
        <div class="col s12 m3 l3 center">
          <a class="waves-effect waves-light btn blue darken-1" href="index.php"><i class="material-icons left">arrow_forward</i>KEMBALI</a>
          <div class="row"></div>
        </div>
      </div>
    </div>
  </body>
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
  </script>
</html>
