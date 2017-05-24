<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Home - Toko Zati Parts</title>
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
      <br />
      <br />
      <br />
      <div class="row">
        <div class="col s12 m6 l6 center">
          <img src="images/transaksi.png" alt="Transaksi" />
          <br />
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
        <div class="col s12 m6 l6 center">
          <img src="images/daftar-transaksi.png" />
          <br />
          <br />
          <a class='dropdown-button btn waves-effect waves-light' data-activates='dropdown-daftar'>Daftar Transaksi</a>
          <ul id='dropdown-daftar' class='dropdown-content'>
            <li><a href="daftar_pembelian.php">Daftar Pembelian</a></li>
            <li class="divider"></li>
            <li><a href="daftar_penjualan.php">Daftar Penjualan</a></li>
          </ul>
        </div>
      </div>
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
          <a class='dropdown-button btn waves-effect waves-light' data-activates='dropdown-laporan'>Laporan Toko</a>
          <ul id='dropdown-laporan' class='dropdown-content'>
            <li><a href="laporan_pembelian.php">Daftar Pembelian</a></li>
            <li class="divider"></li>
            <li><a href="laporan_penjualan.php">Daftar Penjualan</a></li>
            <li class="divider"></li>
            <li><a href="laporan_inventory.php">Daftar Penjualan</a></li>
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
    <script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="js/materialize.js"></script>
  </body>

</html>
