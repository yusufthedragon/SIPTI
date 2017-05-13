<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Transaksi Retur Pembelian</title>
    <link rel="stylesheet" href="css/jquery-ui.css" />
    <link rel="stylesheet" href="css/sweetalert.css" />
    <link rel="stylesheet" href="css/materialize.min.css" />
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="js/jquery-ui.js"></script>
    <script type="text/javascript" src="js/sweetalert.js"></script>
    <script type="text/javascript" src="js/retur_pembelian.js"></script>
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
        <h3 class="center">TRANSAKSI RETUR PEMBELIAN</h3>
        <div class="row">
          <form name="myform" action="sukses_retur_pembelian.php" method="post">
            <div class="col s12 l6">
                No. Transaksi :
                <div class="input-field inline">
                    <input type="text" class="validate" name="no_transaksi" id="no_transaksi" onkeydown="upperCaseF(this), autofill_retur(), autofill_barang()" />
                </div>
            </div>
            <div class="col s12 l6">
                Tanggal :
                <div class="input-field inline">
                    <input type="date" id="tanggal" name="tanggal" readonly />
                </div>
            </div>
            <div class="col s12 l6">
                No. Faktur :
                <div class="input-field inline">
                    <input type="text" class="validate" id="faktur" name="faktur" readonly />
                </div>
            </div>
            <div class="col s12 l6">
                Nama Toko :
                <div class="input-field inline">
                  <input type="text" class="validate" id="toko" name="toko" readonly />
                </div>
            </div>
            <div class="row"></div>
            <div class="row"></div>
            <div class="col s12">
                Masukkan Retur Pembelian :
            </div>
            <div class="row"></div>
            <table class="bordered centered">
              <thead>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Jumlah Barang</th>
              </thead>
              <tbody id="retur_barang">
              </tbody>
            </table>
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
                <a class="waves-effect waves-light btn" href="index.php" >Kembali</a>
            </div>
            <div class="row"></div>
            <div class="row"></div>
            <div class="row"><strong>Pastikan data yang diinput sudah benar.</strong></div>
          </form>
        </div>
    </div>
</body>

</html>
