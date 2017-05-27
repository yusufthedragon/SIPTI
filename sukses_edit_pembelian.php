<?php
  include 'koneksi.php';

  //Data-data yang di submit pada edit pembelian:
  $no_transaksi = htmlspecialchars($_POST['no_transaksi']);
  $tanggal = htmlspecialchars($_POST['tanggal']);
  $no_faktur = htmlspecialchars($_POST['faktur']);
  $toko = htmlspecialchars($_POST['toko']);
  $total = htmlspecialchars($_POST['total']);

  //Mengubah data pembelian berdasarkan input yang disubmit
  $query = $koneksi->prepare("UPDATE pembelian SET tanggal = :tanggal, no_faktur = :faktur, toko = :toko, total = :total WHERE no_transaksi = :no_transaksi");
  $query->bindParam(':no_transaksi', $no_transaksi);
  $query->bindParam(':tanggal', $tanggal);
  $query->bindParam(':faktur', $no_faktur);
  $query->bindParam(':toko', $toko);
  $query->bindParam(':total', $total);
  $query->execute();

  $arraykode = array();
  //Memasukkan data barang yang diinput
  for($n = 1; $n <11; $n++) { //1 - 10 berdasarkan jumlah jenis barang yang bisa dibeli
    if (!isset($_POST['no'.$n])) { //If Counter. Jika dynamic input box tidak ada / belum diisi
      break;
    } else {
      //Data-data barang yang disubmit
      $no = htmlspecialchars($_POST['no'.$n]);
      array_push($arraykode, $no);
      $jumlah = htmlspecialchars($_POST['jumlah'.$n]);

      $query2 = $koneksi->prepare("SELECT jumlah FROM pengaruh WHERE kode_barang = :kode_barang"); //Mengambil selisih antara jumlah barang di inventory dan jumlah barang yang diinput
      $query2->bindParam(':kode_barang', $no);
      $query2->execute();
      $row = $query2->fetch();
      $sum = $jumlah - $row['jumlah']; //Jumlah barang yang diinput dikurangi jumlah data yang di table pengaruh

      $query2 = $koneksi->prepare("SELECT kode_barang FROM pengaruh WHERE no_transaksi = :no_transaksi AND kode_barang = :kode_barang"); //Mengecek apakah barang tersebut ada di pengaruh atau tidak
      $query2->bindParam(':no_transaksi', $no_transaksi);
      $query2->bindParam(':kode_barang', $no);
      $query2->execute();

      if ($query2->rowCount() > 0) { //Jika ada
        $query2 = $koneksi->prepare("UPDATE inventory SET stok = stok + :stok WHERE kode_barang = :kode_barang");
        $query2->bindParam(':stok', $sum);
        $query2->bindParam(':kode_barang', $no);
        $query2->execute();
      } else { //Jika tidak ada
        $query2 = $koneksi->prepare("UPDATE inventory,pengaruh SET stok = -(stok - jumlah) WHERE pengaruh.no_transaksi = :no_transaksi AND pengaruh.kode_barang = :kode_barang AND inventory.kode_barang = pengaruh.kode_barang");
        $query2->bindParam(':no_transaksi', $no_transaksi);
        $query2->bindParam(':kode_barang', $no);
        $query2->execute();

        $query2 = $koneksi->prepare("UPDATE inventory SET stok = stok + :stok WHERE kode_barang = :kode_barang");
        $query2->bindParam(':stok', $sum);
        $query2->bindParam(':kode_barang', $no);
        $query2->execute();
      }
    }
  }

  $query2 = $koneksi->prepare("SELECT kode_barang FROM pengaruh WHERE no_transaksi = :no_transaksi");
  $query2->bindParam(':no_transaksi', $no_transaksi);
  $query2->execute();
  $row = $query2->fetchAll(PDO::FETCH_COLUMN);

  $result = array_diff($row, $arraykode);

  foreach ($result as $value) {
    $query2 = $koneksi->prepare("UPDATE inventory, pengaruh SET stok = stok - jumlah WHERE pengaruh.no_transaksi = :no_transaksi AND pengaruh.kode_barang = :kode_barang AND inventory.kode_barang = pengaruh.kode_barang");
    $query2->bindParam(':no_transaksi', $no_transaksi);
    $query2->bindParam(':kode_barang', $value);
    $query2->execute();
  }

  /*for ($i = 1; $i <= $n; $i++) {
    $no = htmlspecialchars($_POST['no'.$i]);
    while ($row = $query2->fetch();) {
      if ($row['kode_barang'] != $no) {
        $query2 = $koneksi->prepare("DELETE")
      }
    }
  }*/


  $query2 = $koneksi->prepare("DELETE FROM pengaruh WHERE no_transaksi = :no_transaksi");
  $query2->bindParam(':no_transaksi', $no_transaksi);
  $query2->execute();

  for($n = 1; $n <11; $n++) {
    if (!isset($_POST['no'.$n])) {
      break;
    } else {
      $query2 = $koneksi->prepare("INSERT INTO pengaruh VALUES(:no_transaksi, :kode_barang, :nama_barang, :harga, :jumlah)");
      $query2->bindParam(':no_transaksi', $no_transaksi);
      $no = htmlspecialchars($_POST['no'.$n]);
      $query2->bindParam(':kode_barang', $no);
      $barang = htmlspecialchars($_POST['barang'.$n]);
      $query2->bindParam(':nama_barang', $barang);
      $harga = htmlspecialchars($_POST['harga'.$n]);
      $query2->bindParam(':harga', $harga);
      $jumlah = htmlspecialchars($_POST['jumlah'.$n]);
      $query2->bindParam(':jumlah', $jumlah);
      $query2->execute();
    }
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Pembaruan <?php if($query) echo "Sukses"; else echo "Gagal"; ?> - Toko Zati Parts</title>
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
            <i class="material-icons right">assessment</i>
            TOKO ZATI PARTS
          </a>
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
          <a class="waves-effect waves-light btn blue darken-1" href="daftar_pembelian.php"><i class="material-icons left">arrow_forward</i>Kembali Ke Daftar Pembelian</a>
        </div>
        <div class="col s6 center">
          <a class="waves-effect waves-light btn blue darken-1" href="index.php"><i class="material-icons left">arrow_forward</i>Kembali Ke Menu</a>
        </div>
      </div>
      <div class="row"></div>
      <div class="row"></div>
    </div>
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
  </body>
</html>
