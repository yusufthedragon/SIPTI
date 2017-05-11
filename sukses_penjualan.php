<?php
  include 'koneksi.php';

  $no_transaksi = $_POST['no_transaksi'];
  $tanggal = $_POST['tanggal'];
  $nama = $_POST['nama'];
  $alamat = $_POST['alamat'];
  $ongkir = $_POST['ongkir'];
  $no_resi = $_POST['resi'];
  $total = $_POST['total'];

  if(!isset($_POST['kurir'])) {
    $kurir = "";
  } else $kurir = $_POST['kurir'];
  if($ongkir == "") {
    $ongkir = 0;
  }

  $query = $koneksi->prepare("INSERT INTO penjualan VALUES (:no_transaksi, :tanggal, :nama, :alamat, :kurir, :ongkir, :resi, :total)");
  $query->bindParam(':no_transaksi', $no_transaksi);
  $query->bindParam(':tanggal', $tanggal);
  $query->bindParam(':nama', $nama);
  $query->bindParam(':alamat', $alamat);
  $query->bindParam(':kurir', $kurir);
  $query->bindParam(':ongkir', $ongkir);
  $query->bindParam(':resi', $no_resi);
  $query->bindParam(':total', $total);
  $query->execute();

  for($n = 1; $n <11; $n++) {
    if (!isset($_POST['no'.$n])) {
      break;
    } else {
      $query = $koneksi->prepare("INSERT INTO transaksi_barang VALUES(:no_transaksi, :kode_barang, :nama_barang, :harga, :jumlah)");
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
    <title>Penjualan <?php if($query) echo "SUKSES"; else echo "GAGAL"; ?></title>
    <link rel="stylesheet" href="css/jquery-ui.css" />
    <link rel="stylesheet" href="css/sweetalert.css" />
    <link rel="stylesheet" href="css/materialize.min.css" />
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="js/jquery-ui.js"></script>
    <script type="text/javascript" src="js/datepicker-id.js"></script>
    <script type="text/javascript" src="js/sweetalert.js"></script>
    <script type="text/javascript">
      function status() {
        <?php
          if($query) {
            echo "swal({
                  title: 'INPUT DATA BERHASIL!',
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
      <h3 class="center">PENJUALAN <?php if($query) echo "SUKSES"; else echo "GAGAL"; ?></h3>
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
            Nama Konsumen :
            <div class="input-field inline">
              <input type="text" class="validate" name="faktur" value="<?php echo $nama; ?>" readonly />
            </div>
        </div>
        <?php
        if($alamat != "") {
          echo "<div class='col s12'>
              Alamat Konsumen :
              <div class='input-field inline'>
                <input type='text' class='validate' value=$alamat readonly />
              </div>
          </div>";
        }
        if ($kurir != "") {
        echo "<div class='col s12'>
          Kurir Pengiriman :
          <div class='input-field inline'>
            <input type='text' class='validate' value=$kurir readonly />
          </div>
        </div>";
        }
        if($ongkir != 0) {
          echo "<div class='col s12'>
            Ongkos Kirim : Rp.
            <div class='input-field inline'>
              <input type='text' class='validate' value=$ongkir readonly />
            </div>
          </div>";
        }
        if($no_resi != "") {
          echo "<div class='col s12'>
            No. Resi :
            <div class='input-field inline'>
              <input type='text' class='validate' value=$no_resi readonly />
            </div>
          </div>";
        }
        ?>
      </div>
      <div class="row">
        <div class="col s12">
          Daftar Penjualan :
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
        <div class="row"></div>
        <div class="col s12">
          Total Penjualan : Rp.
          <div class="input-field inline">
            <input type="text" class="validate" value="<?php echo $total; ?>" readonly />
          </div>
        </div>
        <div class="row"></div>
        <div class="row"></div>
        <div class="col s6 center">
          <a class="waves-effect waves-light btn" href="penjualan.php">Input Kembali</a>
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
