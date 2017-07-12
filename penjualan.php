<?php
  include 'koneksi.php';

  session_start(); //Memulai session
  if (!isset($_SESSION['login'])) { //Jika session belum diset/user belum login
    header("location: login.php"); //Maka akan dialihkan ke halaman login
  }

  //Mengambil No. Transaksi terakhir untuk digunakan sebagai No. Transaksi baru
  $query = $koneksi->prepare("SELECT no_transaksi FROM penjualan ORDER BY no_transaksi DESC LIMIT 1");
  $query->execute();
  $row = $query->fetch();

  if ($query->rowCount() < 1) { //Jika tidak ada data No. Transaksi di database
    $row[0] = "PN0000";
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi Penjualan - Toko Zati Parts</title>
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
      <h3 class="center">TRANSAKSI PENJUALAN</h3>
      <div class="row">
        <form name="myform" action="sukses_penjualan.php" method="post">
          <div class="col s12">
            No. Transaksi :
            <div class="input-field inline">
              <input type="text" id="no_transaksi" name="no_transaksi" class="validate" value="<?php echo ++$row[0]; ?>" readonly />
            </div>
          </div>
          <div class="col s12">
            Tanggal :
            <div class="input-field inline">
              <input type="text" class="klik" id="datepicker" name="tanggal" autocomplete="off" readonly />
            </div>
          </div>
          <div class="col s12">
            Masukkan Nama Konsumen :
            <div class="input-field inline">
              <input type="text" id="nama" name="nama" class="validate" onkeyup="firstUpperF(this)" autocomplete="off" />
            </div>
          </div>
          <div class="col s12">
            Masukkan Alamat Konsumen :
            <div class="input-field inline">
              <input type="text" id="alamat" name="alamat" style="width:320px;" class="validate" onkeyup="firstUpperF(this)" autocomplete="off" />
            </div>
          </div>
          <div class="row"></div>
          <div class="col s12">
            Masukkan Penjualan :
          </div>
          <div class="row"></div>
          <div id="gruppenjualan">
            <div id="penjualan1">
              <div class="col s4">
                <center><label>No. Barang #1</label></center>
                <input type="text" name="no1" id="no1" class="center autocomplete" onkeyup="autofill(this), autohitung(), upperCaseF(this)" onblur="autofill(this), autohitung(), upperCaseF(this)" />
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
                <input type="text" name="harga1" id="harga1" hidden/>
              </div>
              <div class="col s12">
                <input type="text" name="stok1" id="stok1" hidden />
              </div>
            </div>
            <input type="text" name="counter" id="counter" value=2 hidden />
          </div>
          <div class="col s12 m4 push-m2 l4 push-l2 center">
            <a class="waves-effect waves-light btn blue darken-1" id="tambah"><i class="material-icons left">add</i>Tambah</a>
          </div>
          <div class="col s12 m4 l4">&nbsp;</div>
          <div class="col s12 m4 pull-m2 l4 pull-l2 center">
            <a class="waves-effect waves-light btn blue darken-1" id="hapus"><i class="material-icons left">delete</i>Hapus</a>
          </div>
          <div class="row"></div>
          <div class="col s12">
            Pilih Kurir :
            <div class="inline">
              <input name="kurir" type="radio" id="kurir1" value="" checked />
              <label for="kurir1" style="color:black;">TIDAK ADA</label>
              <br />
              <input name="kurir" type="radio" id="kurir2" value="JNE REGULER" />
              <label for="kurir2" style="color:black;">JNE REGULER</label>
              <br />
              <input name="kurir" type="radio" id="kurir3" value="JNE YES" />
              <label for="kurir3" style="color:black;">JNE YES</label>
              <br />
              <input name="kurir" type="radio" id="kurir4" value="POS KILAT" />
              <label for="kurir4" style="color:black;">POS KILAT</label>
              <br />
              <input name="kurir" type="radio" id="kurir5" value="TIKI" />
              <label for="kurir5" style="color:black;">TIKI</label>
            </div>
          </div>
          <div class="col s12">
            Ongkos Kirim : Rp.
            <div class="input-field inline">
              <input type="text" id="ongkir" name="ongkir" class="validate" value=0 autocomplete="off" />
            </div>
          </div>
          <div class="col s12">
            Masukkan No. Resi :
            <div class="input-field inline">
              <input type="text" id="resi" name="resi" class="validate" onkeydown="upperCaseF(this)" autocomplete="off" />
            </div>
          </div>
          <div class="col s12">
            Total Harga : Rp.
            <div class="input-field inline">
              <input type="text" id="total" name="total" class="validate" value="0" readonly />
            </div>
          </div>
          <div class="row"></div>
          <div class="row"></div>
          <div class="col s12 m5 l5 center">
            <a class="waves-effect waves-light btn green accent-4" id="konfirmasi"><i class="material-icons left">done</i>Konfirmasi</a>
          </div>
          <div class="col s12 m2 l2">&nbsp;</div>
          <div class="col s12 m5 l5 center">
            <a class="waves-effect waves-light btn red" id="gajadi"><i class="material-icons left">cancel</i>Kembali</a>
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
    <script type="text/javascript" src="js/penjualan.js"></script>
  </body>
</html>
