<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Edit Data Barang - Toko Zati Parts</title>
    <link rel="stylesheet" href="css/jquery-ui.css" />
    <link rel="stylesheet" href="css/sweetalert.css" />
    <link rel="stylesheet" href="css/materialize.css" />
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script type="text/javascript" src="js/sweetalert.js"></script>
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

    <div id="keterangan"></div>

    <div class="container">
      <h3 class="center">EDIT BARANG</h3>
      <div class="row">
        <form name="myform" method="post" action="daftar_barang.php">
          <div class="col s12">
            Masukkan Kode Barang Lama:
            <div class="input-field inline">
              <input type="text" name="kodelama" id="kodelama" class="validate" onkeyup="upperCaseF(this), autofill()" autocomplete="off" />
            </div>
          </div>
          <div class="col s12">
            Masukkan Kode Barang Baru:
            <div class="input-field inline">
              <input type="text" name="kodebaru" id="kodebaru" class="validate" onkeydown="upperCaseF(this)" />
            </div>
          </div>
          <div class="col s12">
            Masukkan Nama Barang:
            <div class="input-field inline">
              <input type="text" name="nama" id="nama" class="validate" onkeydown="upperCaseF(this)" autocomplete="off" />
            </div>
          </div>
          <div class="col s12">
            Masukkan Harga Barang: Rp.
            <div class="input-field inline">
              <input type="text" name="harga" id="harga" class="validate" />
            </div>
          </div>
          <div class="col s12">
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
          <a class="waves-effect waves-light btn green accent-4" onclick="edit()"><i class="material-icons left">edit</i>EDIT</a>
        </div>
        <div class="col s6 l6 center">
          <a class="waves-effect waves-light btn blue darken-1" onclick="batal()"><i class="material-icons left">cancel</i>BATAL</a>
        </div>
      </div>
      <div class="row"></div>
    </div>
    <script type="text/javascript" src="js/materialize.js"></script>
    <script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="js/jquery-ui.js"></script>
    <script type="text/javascript">
      function upperCaseF(a) { //Fungsi untuk membuat input kapital secara otomatis
        setTimeout(function() {
          a.value = a.value.toUpperCase();
        }, 1);
      }

      $(function() { //Fungsi untuk mengambil daftar barang dari database
        $("#kodelama").autocomplete({ //dan mempopulasikannya di input kode barang secara otomatis
          source: 'search_barang.php'
        });
      });

      function autofill() {
        var no = $("#kodelama").val();
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

      function edit() {
        if ((myform.kodelama.value == "") || (myform.nama.value == "") || (myform.harga.value == "") || (myform.jumlah.value == "")) {
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
              var kodelama = $("#kodelama").val();
              var kodebaru = $("#kodebaru").val();
              if (kodebaru == "") {
                kodebaru = kodelama;
              }
              var nama = $("#nama").val();
              var harga = $("#harga").val();
              var jumlah = $("#jumlah").val();
              $.ajax({
                url: 'ajax_edit_barang.php',
                dataType: "html",
                data: {'kodelama': kodelama, 'kodebaru': kodebaru, 'nama': nama, 'harga': harga, 'jumlah': jumlah},
              }).success(function(data) {
                console.log(kodebaru);
                    $('#keterangan').html(data);
                });
            }
          });
        }
      }

      function batal() {
        if ((myform.kodelama.value != "") || (myform.kodebaru.value != "") || (myform.nama.value != "") || (myform.harga.value != "") || (myform.jumlah.value != "")) {
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
    </script>
  </body>
</html>
