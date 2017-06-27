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
    <title>Hapus Data Barang - Toko Zati Parts</title>
    <link rel="shortcut icon" href="images/logo.png" />
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css" />
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
    <div id="keterangan"></div>
    <div class="container">
      <h3 class="center">HAPUS BARANG</h3>
      <div class="row">
        <form name="myform">
          <div class="col s12">
            Masukkan Kode Barang:
            <div class="input-field inline">
              <input type="text" name="kode" id="kode" class="validate" onkeyup="upperCaseF(this), autofill()" />
            </div>
          </div>
          <div class="col s12">
            Masukkan Nama Barang:
            <div class="input-field inline">
              <input type="text" name="nama" id="nama" class="validate" readonly />
            </div>
          </div>
          <div class="col s12">
            Masukkan Harga Barang: Rp.
            <div class="input-field inline">
              <input type="text" name="harga" id="harga" class="validate" readonly />
            </div>
          </div>
          <div class="col s12">
            Masukkan Jumlah Barang:
            <div class="input-field inline">
              <input type="text" name="jumlah" id="jumlah" class="validate" readonly />
            </div>
          </div>
        </form>
      </div>
      <div class="row"></div>
      <div class="row">
        <div class="col s6 l6 center">
          <a class="waves-effect waves-light btn red" onclick="hapus()"><i class="material-icons left">delete</i>HAPUS</a>
        </div>
        <div class="col s6 l6 center">
          <a class="waves-effect waves-light btn blue darken-1" href="daftar_barang.php"><i class="material-icons left">cancel</i>BATAL</a>
        </div>
      </div>
      <div class="row"></div>
    </div>
    <script type="text/javascript" src="js/materialize.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    <script type="text/javascript">
      function upperCaseF(a) { //Fungsi untuk membuat input kapital secara otomatis
        setTimeout(function() {
          a.value = a.value.toUpperCase();
        }, 1);
      }

      $(function() { //Fungsi untuk mengambil daftar barang dari database
        $("#kode").autocomplete({ //dan mempopulasikannya di input Kode Barang secara otomatis
          source: 'search_barang_pembelian.php'
        });
      });

      function autofill() { //Fungsi untuk mengisi form Nama Barang, Harga, dan Jumlah secara otomatis
        var no = $("#kode").val();
        $.ajax({
          url: 'ajax_barang.php',
          dataType: "html",
          data: "no=" + no,
        }).success(function(data) {
          var json = data,
            obj = JSON.parse(json);
          $('#nama').val(obj.nama_barang);
          $('#harga').val(obj.harga);
          $('#jumlah').val(obj.stok);
        });
      }

      function hapus() {
        if (myform.kode.value == "") {
          swal({
            title: "KODE BARANG KOSONG!",
            text: "Harap mengisi data Kode Barang!",
            timer: 2000,
            type: "error"
           });
        } else if (myform.nama.value == "") {
          swal({
            title: "KODE BARANG TIDAK TERDAFTAR!",
            text: "Pastikan Kode Barang terdaftar di database!",
            timer: 2000,
            type: "error"
           });
        } else {
          swal({
            title: "Anda yakin?",
            text: "Data tersebut akan dihapus dari database!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, saya yakin!",
            cancelButtonText: "Batal",
            closeOnConfirm: true
          }, function(isConfirm) {
            if (isConfirm) {
              var kode = $("#kode").val();
              $.ajax({
                url: 'ajax_hapus_barang.php',
                dataType: "html",
                data: 'kode=' + kode,
              }).success(function(data) {
                $('#keterangan').html(data);
              });
            }
          });
        }
      }
    </script>
  </body>
</html>
