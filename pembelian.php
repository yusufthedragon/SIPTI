<?php
  include 'koneksi.php';

  session_start(); //Memulai session
  if (!isset($_SESSION['login'])) { //Jika session belum diset/user belum login
    header("location: login.php"); //Maka akan dialihkan ke halaman login
  }

  //Mengambil No. Transaksi terakhir untuk digunakan sebagai No. Transaksi baru
  $query = $koneksi->prepare("SELECT no_transaksi FROM pembelian ORDER BY no_transaksi DESC LIMIT 1");
  $query->execute();
  $row = $query->fetch();
  if ($query->rowCount() < 1) { //Jika tidak ada data No. Transaksi di database
    $row[0] = "PM0000";
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Transaksi Pembelian - Toko Zati Parts</title>
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
    <div class="container">
      <h3 class="center">TRANSAKSI PEMBELIAN</h3>
      <div class="row">
        <form name="myform" action="sukses_pembelian.php" method="post">
          <div class="col s12">
            No. Transaksi :
            <div class="input-field inline">
              <input type="text" class="validate" name="no_transaksi" id="no_transaksi" value="<?php echo ++$row[0]; ?>" readonly />
            </div>
          </div>
          <div class="col s12">
            Tanggal :
            <div class="input-field inline">
              <input type="date" class="klik" id="datepicker" name="tanggal" autocomplete="off" />
            </div>
          </div>
          <div class="col s12">
            No. Faktur :
            <div class="input-field inline">
              <input type="text" class="validate" id="faktur" name="faktur" autocomplete="off" />
            </div>
          </div>
          <div class="row"></div>
          <div class="col s2">
            Pilih Toko :
          </div>
          <div class="col s10">
            <input name="toko" type="radio" id="toko1" value="Sartika Motor" onclick="autohitung()"/>
            <label for="toko1" style="color:black;">Sartika Motor</label>
            <br />
            <input name="toko" type="radio" id="toko2" value="Wijaya Motor" onchange="autohitung()" />
            <label for="toko2" style="color:black;">Wijaya Motor</label>
            <br />
            <input name="toko" type="radio" id="toko3" value="Ramayana Motor" onchange="autohitung()" />
            <label for="toko3" style="color:black;">Ramayana Motor</label>
            <br />
            <input name="toko" type="radio" id="toko4" value="Sarana Motor" onchange="autohitung()" />
            <label for="toko4" style="color:black;">Sarana Motor</label>
          </div>
          <div class="row"></div>
          <div class="row"></div>
          <div class="col s12">
            Masukkan Pembelian :
          </div>
          <div class="row"></div>
          <div id="gruppembelian">
            <div id="pembelian1">
              <div class="col s4">
                <center><label>Kode Barang #1</label></center>
                <input type="text" id="no1" name="no1" class="center autocomplete" onkeyup="autofill(this), autohitung(), upperCaseF(this)" />
              </div>
              <div class="col s4">
                <center><label>Nama Barang</label></center>
                <input type="text" name="barang1" id="barang1" class="center validate" readonly />
              </div>
              <div class="col s4">
                <center><label for="jumlah1">Jumlah Barang</label></center>
                <input type="text" name="jumlah1" id="jumlah1" class="center validate" onkeyup="autohitung()" autocomplete="off" />
              </div>
              <div class="col s12">
                <input type="text" name="harga1" id="harga1" hidden />
              </div>
            </div>
            <input type="text" name="counter" id="counter" value=2 hidden />
          </div>
          <div class="col s1 l3"></div>
          <div class="col s12 l3 center">
            <a class="waves-effect waves-light btn blue darken-1" id="tambah"><i class="material-icons left">add</i>Tambah</a>
          </div>
          <div class="col s12 l3 center">
            <a class="waves-effect waves-light btn blue darken-1" id="hapus"><i class="material-icons left">delete</i>Hapus</a>
          </div>
          <div class="col s1 l3"></div>
          <div class="col s12">
            Total Harga : Rp.
            <div class="input-field inline">
              <input type="text" id="total" name="total" class="validate" value="0" readonly />
            </div>
          </div>
          <div class="row"></div>
          <div class="row"></div>
          <div class="col s12 l6 center">
            <a class="waves-effect waves-light btn green accent-4" id="konfirmasi"><i class="material-icons left">done</i>Konfirmasi</a>
          </div>
          <div class="col s12 l6 center">
            <a class="waves-effect waves-light btn blue darken-1" id="gajadi"><i class="material-icons left">cancel</i>Kembali</a>
          </div>
          <div class="row"></div>
          <div class="row"></div>
          <div class="row"><strong>Pastikan data yang diinput sudah benar.</strong></div>
        </form>
      </div>
    </div>
    <script type="text/javascript" src="js/materialize.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script type="text/javascript" src="js/datepicker-id.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    <script type="text/javascript" src="js/pembelian.js"></script>
  </body>
</html>
