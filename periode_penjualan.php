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
    <title>Laporan Penjualan - Toko Zati Parts</title>
    <link rel="shortcut icon" href="images/logo.png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css" />
    <link rel="stylesheet" href="css/materialize.css" />
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  </head>
  <body>
    <nav>
      <div class="nav-wrapper grey darken-3">
        <a href="index.php" class="brand-logo center">TOKO ZATI PARTS</a>
      </div>
    </nav>
    <div class="container">
      <div class="row">
        <div class="col s12">
          <h3 class="center">LAPORAN PENJUALAN</h3>
        </div>
        <div class="row"></div>
        <div class="row"></div>
        <form name="myform" action="laporan_penjualan.php" method="post" target="_blank">
          <div class="col s6 push-s3 m12 l12 center">
            Pilih Periode :
            <div class="input-field inline">
              <select name="bulan">
                <option value="Januari" selected>Januari</option>
                <option value="Februari">Februari</option>
                <option value="Maret">Maret</option>
                <option value="April">April</option>
                <option value="Mei">Mei</option>
                <option value="Juni">Juni</option>
                <option value="Juli">Juli</option>
                <option value="Agustus">Agustus</option>
                <option value="September">September</option>
                <option value="Oktober">Oktober</option>
                <option value="November">November</option>
                <option value="Desember">Desember</option>
              </select>
              <label>Bulan</label>
            </div>
            <div class="input-field inline">
              <select name="tahun">
                <option value="2017" selected>2017</option>
                <option value="2018">2018</option>
                <option value="2019">2019</option>
                <option value="2020">2020</option>
              </select>
              <label>Tahun</label>
            </div>
          </div>
          <div class="row"></div>
          <div class="row"></div>
          <div class="row"></div>
          <div class="row"></div>
          <div class="row"></div>
          <div class="col s12 m5 l5 center">
            <a class="waves-effect waves-light btn green accent-4" onclick="konfirmasi()"><i class="material-icons left">done</i>Konfirmasi</a>
          </div>
          <div class="col s12 m2 l2">&nbsp;</div>
          <div class="col s12 m5 l5 center">
            <a class="waves-effect waves-light btn blue darken-1" href="index.php"><i class="material-icons left">cancel</i>Kembali</a>
          </div>
        </form>
      </div>
    </div>
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="js/materialize.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
      $('select').material_select();
    });

    function konfirmasi() {
      document.forms["myform"].submit();
    }
    </script>
  </body>
</html>
