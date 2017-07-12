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
   <title>Tambah Data Barang - Toko Zati Parts</title>
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
   <div id="keterangan"></div>
   <div class="container">
     <h3 class="center">TAMBAH BARANG</h3>
     <div class="row">
       <form name="myform">
         <div class="col s12 m12 l12">
           Masukkan Kode Barang:
           <div class="input-field inline">
             <input type="text" name="kode" id="kode" class="validate" onkeydown="upperCaseF(this)" />
           </div>
         </div>
         <div class="col s12 m12 l12">
           Masukkan Nama Barang:
           <div class="input-field inline">
             <input type="text" name="nama" id="nama" class="validate" onkeydown="upperCaseF(this)" autocomplete="off" />
           </div>
         </div>
         <div class="col s12 m12 l12">
           Masukkan Harga Barang: Rp.
           <div class="input-field inline">
             <input type="text" name="harga" id="harga" class="validate" />
           </div>
         </div>
         <div class="col s12 m12 l12">
           Masukkan Jumlah Barang:
           <div class="input-field inline">
             <input type="text" name="jumlah" id="jumlah" class="validate" />
           </div>
         </div>
       </form>
     </div>
     <div class="row"></div>
     <div class="row">
       <div class="col s6 l6 center">
         <a class="waves-effect waves-light btn green accent-4" onclick="tambah()"><i class="material-icons left">add</i>TAMBAH</a>
       </div>
       <div class="col s6 l6 center">
         <a class="waves-effect waves-light btn blue darken-1" onclick="batal()"><i class="material-icons left">cancel</i>BATAL</a>
       </div>
     </div>
   </div>
   <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
   <script type="text/javascript" src="js/materialize.js"></script>
   <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
   <script type="text/javascript">
     function upperCaseF(a) { //Fungsi untuk membuat input kapital secara otomatis
       setTimeout(function() {
         a.value = a.value.toUpperCase();
       }, 1);
     }

     function batal() {
       //Mengecek apakah form input terisi atau tidak
       if ((myform.kode.value != "") || (myform.nama.value != "") || (myform.harga.value != "") || (myform.jumlah.value != "")) {
         swal({
           title: "Anda yakin?",
           text: "Semua data yang telah dimasukkan akan hilang!",
           type: "warning",
           showCancelButton: true,
           confirmButtonColor: "#DD6B55",
           confirmButtonText: "Ya, saya yakin!",
           cancelButtonText: "Batal",
           closeOnConfirm: false
         }, function(isConfirm) {
           if (isConfirm) {
             window.location = "daftar_barang.php";
           }
         });
       } else {
         window.location = "daftar_barang.php";
       }
     }

     function tambah() {
       //Mengecek apakah form input ada yang kosong atau tidak
       if ((myform.kode.value == "") || (myform.nama.value == "") || (myform.harga.value == "") || (myform.jumlah.value == "")) {
         swal({
            title: "Error!",
            text: "Harap mengisi seluruh data!",
            timer: 2000,
            type: "error"
          });
        } else {
         swal({
           title: "Anda yakin?",
           text: "Semua data yang telah dimasukkan akan masuk ke database!",
           type: "warning",
           showCancelButton: true,
           confirmButtonColor: "#DD6B55",
           confirmButtonText: "Ya, saya yakin!",
           cancelButtonText: "Batal",
           closeOnConfirm: true
         }, function(isConfirm) {
           if (isConfirm) {
             var kode = myform.kode.value;
             var nama = myform.nama.value;
             var harga = myform.harga.value;
             var jumlah = myform.jumlah.value;
             $.ajax({
               url: 'ajax_tambah_barang.php',
               dataType: "html",
               data: {'kode': kode, 'nama': nama, 'harga': harga, 'jumlah': jumlah},
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
