<?php
  include 'koneksi.php';

  $no_transaksi = htmlspecialchars($_POST['no_transaksi']);
  $tanggal = htmlspecialchars($_POST['tanggal']);
  $nama = htmlspecialchars($_POST['nama']);
  $alamat = htmlspecialchars($_POST['alamat']);
  $kurir = htmlspecialchars($_POST['kurir']);
  $ongkir = htmlspecialchars($_POST['ongkir']);
  $no_resi = htmlspecialchars($_POST['resi']);
  $total = htmlspecialchars($_POST['total']);

  try{
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
    throw new PDOException;
  } catch(PDOException $e) {
    if ($e->errorInfo[1] != 00000) {
      echo "<script>
            function status() {
              swal({
                title: 'Error!',
                text: 'Data tidak lengkap / berlebihan.',
                timer: 3000,
                type: 'error',
                showConfirmButton: false
              });
            }
            </script>";
    } else {
      echo "<script>
            function status() {
              swal({
                title: 'INPUT DATA BERHASIL!',
                text: 'Data telah masuk ke database.',
                timer: 3000,
                type: 'success',
                showConfirmButton: false
              });
            }
            </script>";
      for($n = 1; $n <11; $n++) {
        if (!isset($_POST['no'.$n])) {
          break;
        } else {
          $query = $koneksi->prepare("INSERT INTO pengaruh VALUES(:no_transaksi, :kode_barang, :nama_barang, :harga, :jumlah)");
          $query->bindParam(':no_transaksi', $no_transaksi);
          $no = htmlspecialchars($_POST['no'.$n]);
          $query->bindParam(':kode_barang', $no);
          $barang = htmlspecialchars($_POST['barang'.$n]);
          $query->bindParam(':nama_barang', $barang);
          $harga = htmlspecialchars($_POST['harga'.$n]);
          $query->bindParam(':harga', $harga);
          $jumlah = htmlspecialchars($_POST['jumlah'.$n]);
          $query->bindParam(':jumlah', $jumlah);
          $query->execute();

          $query = $koneksi->prepare("UPDATE inventory SET stok = stok - :jumlah WHERE kode_barang = :kode_barang");
          $query->bindParam(':jumlah', $jumlah);
          $query->bindParam(':kode_barang', $no);
          $query->execute();
        }
      }
    }
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Penjualan <?php if($e->errorInfo[1] == 00000) echo "Sukses"; else echo "Gagal"; ?> - Toko Zati Parts</title>
    <link rel="stylesheet" href="css/sweetalert.css" />
    <link rel="stylesheet" href="css/materialize.min.css" />
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  </head>

  <body onload="status()">

    <nav>
        <div class="nav-wrapper grey darken-3">
          <a href="index.php" class="brand-logo center">
            <i class="material-icons left">shopping_cart&nbsp;&nbsp;</i>
            <i class="material-icons left">event_note&nbsp;&nbsp;</i>
            <i class="material-icons left">store</i>
            <i class="material-icons right">exit_to_app</i>
            <i class="material-icons right">account_circle</i>
            <i class="material-icons right">assessment</i>TOKO ZATI PARTS
          </a>
        </div>
    </nav>
    <div class="container">
      <h3 class="center">PENJUALAN <?php if($e->errorInfo[1] == 00000) echo "SUKSES"; else echo "GAGAL"; ?></h3>
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
                <input type='text' class='validate' value='".$alamat."' style='width:320px;' readonly />
              </div>
          </div>";
        }
        if ($kurir != "") {
        echo "<div class='col s12'>
          Kurir Pengiriman :
          <div class='input-field inline'>
            <input type='text' class='validate' value='".$kurir."' readonly />
          </div>
        </div>";
        }
        if($ongkir != 0) {
          echo "<div class='col s12'>
            Ongkos Kirim : Rp.
            <div class='input-field inline'>
              <input type='text' class='validate' value='".$ongkir."' readonly />
            </div>
          </div>";
        }
        if($no_resi != "") {
          echo "<div class='col s12'>
            No. Resi :
            <div class='input-field inline'>
              <input type='text' class='validate' value='".$no_resi."' readonly />
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
            <input type="text" class="validate" value="<?php echo number_format($total, 0, '', '.'); ?>" readonly />
          </div>
        </div>
        <div class="row"></div>
        <div class="row"></div>
        <div class="col s6 center">
          <a class="waves-effect waves-light btn blue darken-1" href="penjualan.php"><i class="material-icons left">input</i>Input Kembali</a>
        </div>
        <div class="col s6 center">
          <a class="waves-effect waves-light btn red" href="index.php"><i class="material-icons left">arrow_forward</i>Kembali Ke Menu</a>
        </div>
      </div>
      <div class="row"></div>
      <div class="row"></div>
    </div>
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <script type="text/javascript" src="js/sweetalert.js"></script>
  </body>
</html>
