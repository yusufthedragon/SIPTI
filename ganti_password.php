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
    <title>Ganti Password - Toko Zati Parts</title>
    <link rel="shortcut icon" href="images/logo.png" />
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
      <h3 class="center">GANTI PASSWORD</h3>
      <div class="row"></div>
      <div class="row">
        <form name="myform">
          <div class="col s12 center">
            Masukkan Password Lama :
            <div class="input-field inline">
              <input type="password" class="validate" name="lama" />
            </div>
          </div>
          <div class="col s12 center">
            Masukkan Password Baru :
            <div class="input-field inline">
              <input type="password" class="validate" name="baru" />
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
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    <script type="text/javascript">
      function konfirmasi() {
        if ((myform.lama.value == "") || (myform.baru.value == "")) {
          swal({
            title: "Error!",
            text: "Harap mengisi data Password Lama dan Password Baru!",
            timer: 2000,
            type: "error"
           });
        } else {
          swal({
            title: "Anda yakin?",
            text: "Password anda akan diganti!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, saya yakin!",
            cancelButtonText: "Batal",
            closeOnConfirm: true
          }, function(isConfirm) {
            if (isConfirm) {
              var lama = myform.lama.value;
              var baru = myform.baru.value;
              $.ajax({
                url: 'ajax_ganti_password.php',
                dataType: "html",
                data: {'lama': lama, 'baru': baru},
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
