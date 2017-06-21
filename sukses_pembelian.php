<?php
  include 'koneksi.php';

  session_start(); //Memulai session
  if (!isset($_SESSION['login'])) { //Jika session belum diset/user belum login
    header("location: login.php"); //Maka akan dialihkan ke halaman login
  }

  //Menerima variabel counter
  $counter = htmlspecialchars($_POST['counter']);

  //Menerima data yang diinput user
  $no_transaksi = htmlspecialchars($_POST['no_transaksi']);
  $tanggal = htmlspecialchars($_POST['tanggal']);
  $no_faktur = htmlspecialchars($_POST['faktur']);
  $toko = htmlspecialchars($_POST['toko']);
  $total = str_replace(".", "", htmlspecialchars($_POST['total'])); //Untuk menghilangkan titik di nominal total

  try {
    //Memasukkan data ke database
    $query = $koneksi->prepare("INSERT INTO pembelian VALUES (:no_transaksi, :tanggal, :faktur, :toko, :total)");
    $query->bindParam(':no_transaksi', $no_transaksi);
    $query->bindParam(':tanggal', $tanggal);
    $query->bindParam(':faktur', $no_faktur);
    $query->bindParam(':toko', $toko);
    $query->bindParam(':total', $total);
    $query->execute();
    throw new PDOException; //Membuat sebuah error code
  } catch (PDOException $e) {
    for($n = 1; $n < $counter; $n++) {
      $no = htmlspecialchars($_POST['no'.$n]);
      $barang = htmlspecialchars($_POST['barang'.$n]);
      $harga = htmlspecialchars($_POST['harga'.$n]);
      $jumlah = htmlspecialchars($_POST['jumlah'.$n]);

      //Memasukkan data ke database
      $query = $koneksi->prepare("INSERT INTO pengaruh VALUES(:no_transaksi, :kode_barang, :nama_barang, :harga, :jumlah)");
      $query->bindParam(':no_transaksi', $no_transaksi);
      $query->bindParam(':kode_barang', $no);
      $query->bindParam(':nama_barang', $barang);
      $query->bindParam(':harga', $harga);
      $query->bindParam(':jumlah', $jumlah);
      $query->execute();

      //Memperbarui stok pada inventory
      $query = $koneksi->prepare("UPDATE inventory SET stok = stok + :jumlah WHERE kode_barang = :kode_barang");
      $query->bindParam(':jumlah', $jumlah);
      $query->bindParam(':kode_barang', $no);
      $query->execute();
    }
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Pembelian <?php if($e->errorInfo[1] == 00000) echo "Sukses"; else echo "Gagal"; ?> - Toko Zati Parts</title>
    <link rel="shortcut icon" href="images/logo.png" />
    <link rel="stylesheet" href="css/sweetalert.css" />
    <link rel="stylesheet" href="css/materialize.css" />
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  </head>
  <body onload="status()">
    <nav>
      <div class="nav-wrapper grey darken-3">
        <a href="index.php" class="brand-logo center">
          <i class="material-icons left hide-on-med-and-down">shopping_cart&nbsp;&nbsp;</i>
          <i class="material-icons left hide-on-med-and-down">event_note&nbsp;&nbsp;</i>
          <i class="material-icons left hide-on-med-and-down">store</i>
          <i class="material-icons right hide-on-med-and-down">exit_to_app</i>
          <i class="material-icons right hide-on-med-and-down">account_circle</i>
          <i class="material-icons right hide-on-med-and-down">assessment</i>
          TOKO ZATI PARTS
        </a>
      </div>
    </nav>
    <div class="container">
      <h3 class="center">PEMBELIAN <?php if($e->errorInfo[1] == 00000) echo "SUKSES"; else echo "GAGAL"; ?></h3>
      <div class="row">
        <div class="col s12 l12">
          No. Transaksi :
          <div class="input-field inline">
            <input type="text" class="validate" id="no_transaksi" value="<?php echo $no_transaksi; ?>" readonly />
          </div>
        </div>
        <div class="col s12 l12">
          Tanggal :
          <div class="input-field inline">
            <input type="text" id="datepicker" name="tanggal" value="<?php echo $tanggal; ?>" readonly />
          </div>
        </div>
        <div class="col s12 l12">
          No. Faktur :
          <div class="input-field inline">
            <input type="text" class="validate" id="faktur" name="faktur" value="<?php echo $no_faktur; ?>" readonly />
          </div>
        </div>
        <div class="col s12 l12">
          Nama Toko :
          <div class="input-field inline">
            <input type="text" class="validate" id="toko" value="<?php echo $toko; ?>" readonly />
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col s12 l12">
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
                for ($x = 1; $x < $counter; $x++) {
                  echo "<tr>
                    <td>".$_POST['no'.$x]."</td>
                    <td>".$_POST['barang'.$x]."</td>
                    <td>".$_POST['jumlah'.$x]."</td>
                  </tr>";
                }
              ?>
            </tbody>
          </table>
        </div>
        <div class="col s12 l12">
          Total Pembelian : Rp.
          <div class="input-field inline">
            <input type="text" class="validate" value="<?php echo number_format($total, 0, '', '.'); ?>" readonly />
          </div>
        </div>
        <div class="row"></div>
        <div class="row"></div>
        <div class="col s12 l6 center">
          <a class="waves-effect waves-light btn blue darken-1" href="pembelian.php"><i class="material-icons left">input</i>Input Kembali</a>
        </div>
        <div class="col s12 l6 center">
          <a class="waves-effect waves-light btn blue darken-1" href="index.php"><i class="material-icons left">arrow_forward</i>Kembali Ke Menu</a>
        </div>
      </div>
      <div class="row"></div>
      <div class="row"></div>
    </div>
    <script type="text/javascript" src="js/materialize.js"></script>
    <script type="text/javascript" src="js/sweetalert.js"></script>
    <script type="text/javascript">
      function status() {
        <?php
          if($e->errorInfo[1] == 00000) {
            echo "swal({
                    title: 'INPUT TRANSAKSI BERHASIL!',
                    text: 'Data telah masuk ke database.',
                    timer: 3000,
                    type: 'success',
                    showConfirmButton: false
                  });";
          } else {
            echo "swal({
                    title: 'INPUT TRANSAKSI GAGAL!',
                    text: 'Data gagal masuk ke database.',
                    timer: 3000,
                    type: 'error',
                    showConfirmButton: false
                  });";
          }
        ?>
      }
    </script>
  </body>
</html>
