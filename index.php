<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Sistem Informasi Manajemen Inventori</title>
    <link rel="stylesheet" href="css/materialize.min.css" />
    <script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="js/materialize.min.js"></script>
  </head>
  <body>
    <nav>
      <div class="nav-wrapper grey darken-3">
        <img src="images/edit.png" width="50px" class="brand-logo" style="float:right;" />
        <a href="index.php" class="brand-logo center">Sistem Informasi Manajemen Inventory</a>
      </div>
    </nav>
    <div class="container">
      <br />
      <br />
      <br />
      <br />
      <div class="row">
        <div class="col s12 m6 l6 center">
          <img src="images/edit.png" alt="Edit" />
          <br />
          <br />
          <a class="btn waves-effect waves-light" href="daftar_barang.php">Daftar Inventory</a>
        </div>
        <div class="col s12 m6 l6 center">
          <img src="images/daftar-transaksi.png" />
          <br />
          <br />
          <a class="btn waves-effect waves-light" href="daftar_transaksi.html">Daftar Transaksi</a>
        </div>
      </div>
      <div class="row">
        <div class="col s12 m12 l12 center">
          <img src="images/transaksi.png" alt="Transaksi" />
          <br />
          <a class='dropdown-button btn waves-effect waves-light' data-activates='dropdown-transaksi'>Buat Transaksi</a>
          <ul id='dropdown-transaksi' class='dropdown-content'>
            <li><a href="pembelian.php">Pembelian</a></li>
            <li class="divider"></li>
            <li><a href="penjualan.php">Penjualan</a></li>
            <li class="divider"></li>
            <li><a href="retur_pembelian.php">Retur Pembelian</a></li>
            <li class="divider"></li>
            <li><a href="#">Retur Penjualan</a></li>
          </ul>
        </div>
      </div>
      <br />
      <br />
      <div class="row">
        <div class="col s6 m6 l6 center">
          <img src="images/daftar-inventory.png" />
          <br />
          <br />
          <a class="btn waves-effect waves-light" href="laporan_inventory.html">Laporan Inventory</a>
        </div>
        <div class="col s6 m6 l6 center">
          <img src="images/laporan.png" />
          <br />
          <br />
          <a class="btn waves-effect waves-light" href="laporan_transaksi.html">Laporan Transaksi</a>
        </div>
      </div>
      <br />
    </div>
    <footer class="page-footer grey darken-3">
      <div class="container">
        <div class="row">
          <div class="col s12 l6">
            <h5 class="white-text">Sistem Informasi Manajemen Inventori</h5>
            <p class="grey-text text-lighten-4">Sistem Informasi Manajemen Inventori Toko Adi Parts</p>
          </div>
          <div class="col 14 offset-12 s12">
            <h5 class="white-text">Links</h5>
            <ul>
              <li><a class="grey-text text-lighten-3" href="#"></a></li>
            </ul>
          </div>
        </div>
      </div>
      <div class="footer-copyright">
        <div class="container">
           © Yusuf Ardi
           <a class="grey-text text-lighten-4 right">More Links</a>
        </div>
      </div>
    </footer>
  </body>

</html>
