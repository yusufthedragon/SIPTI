<?php
  include 'koneksi.php';

  //Mengambil No. Transaksi terakhir untuk digunakan sebagai No. Transaksi baru
  $query = $koneksi->prepare("SELECT no_transaksi FROM penjualan ORDER BY no_transaksi DESC LIMIT 1");
  $query->execute();
  $row = $query->fetch();

  if ($query->rowCount() < 1) {
    $row[0] = "PN0000";
  }
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Transaksi Penjualan - Toko Zati Parts</title>
    <link rel="stylesheet" href="css/jquery-ui.css" />
    <link rel="stylesheet" href="css/sweetalert.css" />
    <link rel="stylesheet" href="css/materialize.min.css" />
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
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
                    <input type="date" class="klik" id="datepicker" name="tanggal" autocomplete="off" />
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
                    <input type="text" id="alamat" name="alamat" style="width:320px;" class="validate" autocomplete="off" />
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
                        <input type="text" name="no1" id="no1" class="center autocomplete" onkeyup="autofill(this), autohitung(), upperCaseF(this)" />
                    </div>
                    <div class="col s4">
                        <center><label>Nama Barang</label></center>
                        <input type="text" name="barang1" id="barang1" class="center validate" readonly />
                    </div>
                    <div class="col s4">
                        <center><label for="jumlah1">Jumlah Barang</label></center>
                        <input type="text" name="jumlah1" id="jumlah1" class="center validate" onkeyup="autohitung()" autocomplete="off" />
                    </div>
                    <div class="col s3">
                        <input type="text" name="harga1" id="harga1" hidden/>
                    </div>
                    <div class="col s12">
                        <input type="text" name="hitung1" id="hitung1" hidden/>
                    </div>
                    <div class="col s12">
                        <input type="text" name="stok1" id="stok1" hidden/>
                    </div>
                </div>
                <input type="text" name="counter" id="counter" value=2 hidden />
            </div>
            <div class="col s3"></div>
            <div class="col s3 center">
                <a class="waves-effect waves-light btn blue darken-1" id="tambah"><i class="material-icons left">add</i>Tambah</a>
            </div>
            <div class="col s3 center">
                <a class="waves-effect waves-light btn blue darken-1" id="hapus"><i class="material-icons left">delete</i>Hapus</a>
            </div>
            <div class="col s3"></div>
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
            <div class="col s6 center">
                <a class="waves-effect waves-light btn green accent-4" id="konfirmasi"><i class="material-icons left">done</i>Konfirmasi</a>
            </div>
            <div class="col s6 center">
                <a class="waves-effect waves-light btn red" id="gajadi"><i class="material-icons left">cancel</i>Kembali</a>
            </div>
            <div class="row"></div>
            <div class="row"></div>
            <div class="row"><strong>Pastikan data yang diinput sudah benar.</strong></div>
          </form>
        </div>
    </div>
    <script type="text/javascript" src="js/materialize.js"></script>
    <script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="js/jquery-ui.js"></script>
    <script type="text/javascript" src="js/datepicker-id.js"></script>
    <script type="text/javascript" src="js/sweetalert.js"></script>
    <script type="text/javascript" src="js/penjualan.js"></script>
</body>

</html>
