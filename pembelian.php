<?php
  include 'koneksi.php';

  $query = $koneksi->prepare("SELECT no_transaksi FROM pembelian ORDER BY no_transaksi DESC LIMIT 1");
  $query->execute();
  $row = $query->fetch();
  $baris = $query->rowCount();
  
  if ($baris < 1) {
    $row[0] = "PM0000";
  }
?>

 <!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Transaksi Pembelian</title>
    <link rel="stylesheet" href="css/jquery-ui.css" />
    <link rel="stylesheet" href="css/sweetalert.css" />
    <link rel="stylesheet" href="css/materialize.min.css" />
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="js/jquery-ui.js"></script>
    <script type="text/javascript" src="js/datepicker-id.js"></script>
    <script type="text/javascript" src="js/sweetalert.js"></script>
    <script type="text/javascript" src="js/pembelian.js"></script>
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
                    <input type="date" id="datepicker" name="tanggal" />
                </div>
            </div>
            <div class="col s12">
                No. Faktur :
                <div class="input-field inline">
                    <input type="text" class="validate" id="faktur" name="faktur" />
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
                        <center><label>No. Barang #1</label></center>
                        <input type="text" id="no1" name="no1" class="autocomplete" onkeyup="autofill(this), autohitung()" />
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
            <div class="col s12">
                Total Harga : Rp.
                <div class="input-field inline">
                    <input type="text" id="total" name="total" class="validate" readonly />
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