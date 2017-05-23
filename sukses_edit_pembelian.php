<?php
  include 'koneksi.php';

  $no_transaksi = $_POST['no_transaksi'];
  $tanggal = $_POST['tanggal'];
  $no_faktur = $_POST['faktur'];
  $toko = $_POST['toko'];
  $total = $_POST['total'];

  $query = $koneksi->prepare("UPDATE pembelian SET tanggal = :tanggal, no_faktur = :faktur, toko = :toko, total = :total WHERE no_transaksi = :no_transaksi");
  $query->bindParam(':no_transaksi', $no_transaksi);
  $query->bindParam(':tanggal', $tanggal);
  $query->bindParam(':faktur', $no_faktur);
  $query->bindParam(':toko', $toko);
  $query->bindParam(':total', $total);
  $query->execute();

  $query = $koneksi->prepare("DELETE FROM pengaruh WHERE no_transaksi = :no_transaksi");
  $query->bindParam(":no_transaksi", $no_transaksi);
  $query->execute();

  for($n = 1; $n <11; $n++) {
    if (!isset($_POST['no'.$n])) {
      break;
    } else {    
      $query = $koneksi->prepare("INSERT INTO pengaruh VALUES(:no_transaksi, :kode_barang, :nama_barang, :harga, :jumlah)");
      $query->bindParam(':no_transaksi', $no_transaksi);
      $query->bindParam(':kode_barang', $_POST['no'.$n]);
      $query->bindParam(':nama_barang', $_POST['barang'.$n]);
      $query->bindParam(':harga', $_POST['harga'.$n]);
      $query->bindParam(':jumlah', $_POST['jumlah'.$n]);
      $query->execute();
    }
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Pembaruan <?php if($query) echo "Sukses"; else echo "Gagal"; ?></title>
    <link rel="stylesheet" href="css/sweetalert.css" />
    <link rel="stylesheet" href="css/materialize.min.css" />
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <script type="text/javascript" src="js/sweetalert.js"></script>
    <script type="text/javascript">
      function status() {
        <?php
          if($query) {
            echo "swal({
                  title: 'PEMBARUAN DATA BERHASIL!',
                  text: 'Data telah masuk ke database.',
                  timer: 3000,
                  type: 'success',
                  showConfirmButton: false
                });";
          }
        ?>
      }
    </script>
  </head>

  <body onload="status()">

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
      <h3 class="center">PEMBARUAN <?php if($query) echo "SUKSES"; else echo "GAGAL"; ?></h3>
      <div class="row">
        <div class="col s12">
          No. Transaksi :
          <div class="input-field inline">
            <input type="text" class="validate" id="no_transaksi" value="<?php echo $no_transaksi; ?>" readonly />
          </div>
        </div>
        <div class="col s12">
          Tanggal :
          <div class="input-field inline">
            <input type="text" id="datepicker" name="tanggal" value="<?php echo $tanggal; ?>" readonly />
          </div>
        </div>
        <div class="col s12">
            No. Faktur :
            <div class="input-field inline">
              <input type="text" class="validate" id="faktur" name="faktur" value="<?php echo $no_faktur; ?>" readonly />
            </div>
        </div>
        <div class="col s12">
            Nama Toko :
            <div class="input-field inline">
              <input type="text" class="validate" id="toko" value="<?php echo $toko; ?>" readonly />
            </div>
        </div>
      </div>
      <div class="row">
        <div class="col s12">
          Daftar Pembelian :
          <table class="centered bordered">
            <thead>
              <tr>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Jumlah</th>
              </tr>
            </thead>
            <tbody>
              <?php
                for ($x = 1; $x <11; $x++) {
                  if (!isset($_POST['no'.$x])) {
                    break;
                  } else {
                    echo "<tr>
                      <td>".$_POST['no'.$x]."</td>
                      <td>".$_POST['barang'.$x]."</td>
                      <td>".$_POST['jumlah'.$x]."</td>
                    </tr>";
                  }
                }
              ?>
            </tbody>
          </table>
        </div>
        <div class="col s12">
          Total Pembelian : Rp.
          <div class="input-field inline">
            <input type="text" class="validate" value="<?php echo number_format($total, 0, '', '.'); ?>" readonly />
          </div>
        </div>
        <div class="row"></div>
        <div class="row"></div>
        <div class="col s6 center">
          <a class="waves-effect waves-light btn" href="daftar_pembelian.php">Kembali Ke Daftar Pembelian</a>
        </div>
        <div class="col s6 center">
          <a class="waves-effect waves-light btn" href="index.php">Kembali Ke Menu</a>
        </div>
      </div>
      <div class="row"></div>
      <div class="row"></div>
    </div>
  </body>
</html>
