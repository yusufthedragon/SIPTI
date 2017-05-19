<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>HAPUS BARANG</title>
    <link rel="stylesheet" href="css/jquery-ui.css" />
    <link rel="stylesheet" href="css/sweetalert.css" />
    <link rel="stylesheet" href="css/materialize.min.css" />
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="js/jquery-ui.js"></script>
    <script type="text/javascript" src="js/sweetalert.js"></script>
    <script type="text/javascript">
      function upperCaseF(a) { //Fungsi untuk membuat input kapital secara otomatis
        setTimeout(function() {
          a.value = a.value.toUpperCase();
        }, 1);
      }

      $(function() { //Fungsi untuk mengambil daftar barang dari database
        $("#kode").autocomplete({ //dan mempopulasikannya di input kode barang secara otomatis
          source: 'search_barang.php'
        });
      });

      function autofill() {
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
             title: "Error!",
             text: "Harap mengisi data Kode Barang!",
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

      function batal() {
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
    </script>
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

    <div id="keterangan"></div>

    <div class="container">
      <h3 class="center">HAPUS BARANG</h3>
      <div class="row">
        <form name="myform" method="post" action="daftar_barang.php">
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
          <a class="waves-effect waves-light btn blue darken-1" onclick="hapus()">HAPUS</a>
        </div>
        <div class="col s6 l6 center">
          <a class="waves-effect waves-light btn blue darken-1" onclick="batal()">BATAL</a>
        </div>
      </div>
      <div class="row"></div>
    </div>
  </body>
</html>