<?php
  session_start(); //Memulai session
  if (!isset($_SESSION['login'])) { //Jika session belum diset/user belum login
    header("location: login.php"); //Maka akan dialihkan ke halaman login
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Toko Zati Parts</title>
    <link rel="shortcut icon" href="images/logo.png" />
    <link rel="stylesheet" href="css/materialize.css" />
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
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
      <br />
      <br />
      <div class="row">
        <div class="col s12 m4 l5 center">
          <img src="images/transaksi.png" alt="Transaksi" />
          <br />
          <br />
          <a class='dropdown-button btn waves-effect waves-light grey darken-3' data-activates='dropdown-transaksi'><i class="material-icons left">shopping_cart</i>Buat Transaksi</a>
          <ul id='dropdown-transaksi' class='dropdown-content'>
            <li><a href="pembelian.php">Pembelian</a></li>
            <li class="divider"></li>
            <li><a href="penjualan.php">Penjualan</a></li>
            <li class="divider"></li>
          </ul>
        </div>
        <div class="col s12 m4 l2">&nbsp;</div>
        <div class="col s12 m4 l5 center">
          <img src="images/daftar-transaksi.png" />
          <br />
          <br />
          <a class='dropdown-button btn waves-effect waves-light grey darken-3' data-activates='dropdown-daftar'><i class="material-icons left">event_note</i>Daftar Transaksi</a>
          <ul id='dropdown-daftar' class='dropdown-content'>
            <li><a href="daftar_pembelian.php">Daftar Pembelian</a></li>
            <li class="divider"></li>
            <li><a href="daftar_penjualan.php">Daftar Penjualan</a></li>
          </ul>
        </div>
        <div class="row"></div>
        <div class="col s12 m4 l5 center">
          <img src="images/daftar-inventory.png" alt="Edit" />
          <br />
          <br />
          <a class="btn waves-effect waves-light grey darken-3" href="daftar_barang.php"><i class="material-icons left">store</i>Daftar Inventory</a>
        </div>
        <div class="col s12 m4 l2">&nbsp;</div>
        <div class="col s12 m4 l5 center">
          <img src="images/laporan-toko.png" />
          <br />
          <br />
          <a class='dropdown-button btn waves-effect waves-light grey darken-3' data-activates='dropdown-laporan'><i class="material-icons left">assessment</i>Laporan Toko</a>
          <ul id='dropdown-laporan' class='dropdown-content'>
            <li><a href="periode_pembelian.php">Laporan Pembelian</a></li>
            <li class="divider"></li>
            <li><a href="periode_penjualan.php">Laporan Penjualan</a></li>
            <li class="divider"></li>
            <li><a href="laporan_inventory.php" target="_blank">Laporan Inventory</a></li>
          </ul>
        </div>
        <div class="row"></div>
        <div class="col s12 m4 l5 center">
          <img src="images/password.png" />
          <br />
          <br />
          <a class="btn waves-effect waves-light grey darken-3" href="ganti_password.php"><i class="material-icons left">account_circle</i>Ganti Password</a>
        </div>
        <div class="col s12 m4 l2">&nbsp;</div>
        <div class="col s12 m4 l5 center">
          <img src="images/logout.png" />
          <br />
          <br />
          <a class="btn waves-effect waves-light grey darken-3" href="logout.php"><i class="material-icons left">exit_to_app</i>Sign Out</a>
        </div>
      </div>
      <br />
    </div>
    <footer class="page-footer grey darken-3">
      <div class="container">
        <div class="row">
          <div class="col s12 l12">
            <h5 class="white-text">Sistem Informasi Manajemen Transaksi &amp; Inventori</h5>
            <h5 class="white-text text-lighten-4">Toko Zati Parts</h5>
          </div>
          <div class="row"></div>
          <div class="col s12 l6">
            <h6 class="white-text">Visit profile :</h6>
            <ul class="browser-default" style="color:white;">
              <li><a class="grey-text text-lighten-3" href="https://www.facebook.com/mahadin.zatirahman">Mahadin Jatirahman - Facebook</a></li>
            </ul>
          </div>
          <div class="col s12 l6">
            <h6 class="white-text">Visit shop :</h6>
            <ul class="browser-default" style="color:white;">
              <li><a class="grey-text text-lighten-3" href="https://www.bukalapak.com/mzatirahman">Toko Zati Parts - Bukalapak</a></li>
              <li><a class="grey-text text-lighten-3" href="https://www.tokopedia.com/mahadin">Toko Zati Parts - Tokopedia</a></li>
            </ul>
          </div>
        </div>
      </div>
      <div class="footer-copyright">
        <div class="container">
           Yusuf Ardi © 2017
           <a class="grey-text text-lighten-4 right" href="https://github.com/yusufthedragon/PI">GPL License</a>
        </div>
      </div>
    </footer>
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="js/materialize.js"></script>
  </body>
</html>
