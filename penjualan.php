<?php
  include 'koneksi.php';

  $query = $koneksi->prepare("SELECT no_transaksi FROM penjualan ORDER BY no_transaksi DESC LIMIT 1;");
  $query->execute();
  $row = $query->fetch();
  $baris = $query->rowCount();

  if ($baris < 1) {
    $row[0] = "PN0000";
  }
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Transaksi Penjualan</title>
    <link rel="stylesheet" href="css/jquery-ui.css" />
    <link rel="stylesheet" href="css/sweetalert.css" />
    <link rel="stylesheet" href="css/materialize.min.css" />
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="js/jquery-ui.js"></script>
    <script type="text/javascript" src="js/datepicker-id.js"></script>
    <script type="text/javascript" src="js/sweetalert.js"></script>
    <script type="text/javascript" src="js/penjualan.js"></script>
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
                    <input type="date" id="datepicker" name="tanggal" />
                </div>
            </div>
            <div class="col s12">
                Masukkan Nama Konsumen :
                <div class="input-field inline">
                    <input type="text" id="nama" name="nama" class="validate" />
                </div>
            </div>
            <div class="col s12">
                Masukkan Alamat Konsumen :
                <div class="input-field inline">
                    <input type="text" id="alamat" name="alamat" style="width:320px;" class="validate" />
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
                        <input type="text" name="no1" id="no1" class="autocomplete" onkeyup="autofill(this), autohitung(), upperCaseF(this)" />
                    </div>
                    <div class="col s4">
                        <center><label>Nama Barang</label></center>
                        <input type="text" name="barang1" id="barang1" class="validate" readonly />
                    </div>
                    <div class="col s4">
                        <center><label for="jumlah1">Jumlah Barang</label></center>
                        <input type="text" name="jumlah1" id="jumlah1" class="center validate" onkeyup="autohitung()" />
                    </div>
                    <div class="col s3">
                        <input type="text" name="harga1" id="harga1" class="center validate" hidden/>
                    </div>
                    <div class="col s12">
                        <input type="text" name="hitung1" id="hitung1" hidden/>
                    </div>
                </div>
            </div>
            <div class="col s12 center">
                <input type='button' value='Tambah' id='tambah' class="waves-light btn">
                <input type='button' value='Hapus' id='hapus' class="waves-light btn">
            </div>
            <div class="row"></div>
            <div class="col s12">
                Pilih Kurir :
                <div class="inline">
                  <input name="kurir" type="radio" id="kurir1" value="JNE REGULER" />
                  <label for="kurir1" style="color:black;">JNE REGULER</label>
                  <br />
                  <input name="kurir" type="radio" id="kurir2" value="JNE YES" />
                  <label for="kurir2" style="color:black;">JNE YES</label>
                  <br />
                  <input name="kurir" type="radio" id="kurir3" value="POS KILAT" />
                  <label for="kurir3" style="color:black;">POS KILAT</label>
                  <br />
                  <input name="kurir" type="radio" id="kurir4" value="TIKI" />
                  <label for="kurir4" style="color:black;">TIKI</label>
                </div>
            </div>
            <div class="col s12">
                Ongkos Kirim : Rp.
                <div class="input-field inline">
                    <input type="text" id="ongkir" name="ongkir" class="validate" />
                </div>
            </div>
            <div class="col s12">
                Masukkan No. Resi :
                <div class="input-field inline">
                    <input type="text" id="resi" name="resi" class="validate" onkeydown="upperCaseF(this)" />
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
                <a class="waves-effect waves-light btn" id="konfirmasi">Konfirmasi</a>
            </div>
            <div class="col s6 center">
                <a class="waves-effect waves-light btn" id="gajadi">Kembali</a>
            </div>
            <div class="row"></div>
            <div class="row"></div>
            <div class="row"><strong>Pastikan data yang diinput sudah benar.</strong></div>
          </form>
        </div>
    </div>
</body>

</html>
