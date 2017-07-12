<?php
  include 'koneksi.php';

  session_start(); //Memulai session
  if (!isset($_SESSION['login'])) { //Jika session belum diset/user belum login
    header("location: login.php"); //Maka akan dialihkan ke halaman login
  }

  //Data-data yang di submit pada edit penjualan:
  $no_transaksi = htmlspecialchars($_POST['no_transaksi']);
  $tanggal = htmlspecialchars($_POST['tanggal']);
  $nama = htmlspecialchars($_POST['nama']);
  $alamat = htmlspecialchars($_POST['alamat']);
  $kurir = htmlspecialchars($_POST['kurir']);
  $ongkir = htmlspecialchars($_POST['ongkir']);
  $no_resi = htmlspecialchars($_POST['resi']);
  $total = str_replace(".", "", htmlspecialchars($_POST['total'])); //Untuk menghilangkan titik di nominal total

  //Menerima variabel counter
  $counter = htmlspecialchars($_POST['counter']);

  //Mengubah data penjualan berdasarkan input yang disubmit
  $query = $koneksi->prepare("UPDATE penjualan SET tanggal = :tanggal, nama = :nama, alamat = :alamat, kurir = :kurir, ongkir = :ongkir, no_resi = :no_resi, total = :total WHERE no_transaksi = :no_transaksi");
  $query->bindParam(':no_transaksi', $no_transaksi);
  $query->bindParam(':tanggal', $tanggal);
  $query->bindParam(':nama', $nama);
  $query->bindParam(':alamat', $alamat);
  $query->bindParam(':kurir', $kurir);
  $query->bindParam(':ongkir', $ongkir);
  $query->bindParam(':no_resi', $no_resi);
  $query->bindParam(':total', $total);
  $query->execute();

  //Mendeklarasikan array yang memuat kode barang dari masing-masing barang yang diinput user
  $arraykode = array();

  //Memasukkan data barang yang diinput
  for($n = 1; $n < $counter; $n++) { //1 s/d Counter berdasarkan jumlah jenis barang yang bisa dibeli
    //Data-data barang yang disubmit
    $no = htmlspecialchars($_POST['no'.$n]);
    $jumlah = htmlspecialchars($_POST['jumlah'.$n]);

    //Memasukkan kode barang ke dalam array
    array_push($arraykode, $no);

    //Mengecek apakah barang tersebut ada di pengaruh atau tidak
    //Mengambil selisih antara jumlah barang di inventory dan jumlah barang yang diinput
    $query2 = $koneksi->prepare("SELECT kode_barang, jumlah FROM pengaruh WHERE kode_barang = :kode_barang AND no_transaksi = :no_transaksi");
    $query2->bindParam(':kode_barang', $no);
    $query2->bindParam(':no_transaksi', $no_transaksi);
    $query2->execute();
    $row = $query2->fetch();
    //Mengambil selisih antara jumlah barang di pengaruh dan jumlah barang yang diinput
    $sum = $jumlah - $row['jumlah']; //Jumlah barang yang diinput dikurangi jumlah data yang di table pengaruh

    if ($query2->rowCount() > 0) { //Jika ada
      //Menambah stok barang yang dijual dengan selisih antara jumlah barang di table pengaruh dan jumlah barang yang dinput
      $query2 = $koneksi->prepare("UPDATE inventory SET stok = stok - :stok WHERE kode_barang = :kode_barang");
      $query2->bindParam(':stok', $sum);
      $query2->bindParam(':kode_barang', $no);
      $query2->execute();
    } else { //Jika tidak ada
      //Mengembalikan stok barang di table inventory ke sedia kala sebelum terjadinya penjualan
      $query2 = $koneksi->prepare("UPDATE inventory,pengaruh SET stok = -(stok - jumlah) WHERE pengaruh.no_transaksi = :no_transaksi AND pengaruh.kode_barang = :kode_barang AND inventory.kode_barang = pengaruh.kode_barang");
      $query2->bindParam(':no_transaksi', $no_transaksi);
      $query2->bindParam(':kode_barang', $no);
      $query2->execute();

      //Menambah stok barang yang dijual dengan selisih antara jumlah barang di table pengaruh dan jumlah barang yang dinput
      $query2 = $koneksi->prepare("UPDATE inventory SET stok = stok - :stok WHERE kode_barang = :kode_barang");
      $query2->bindParam(':stok', $sum);
      $query2->bindParam(':kode_barang', $no);
      $query2->execute();
    }
  }

  //Mengambil data kode barang yang ada di tabel pengaruh dengan No. Transaksi sekarang
  //Untuk mencari apakah data barang di tabel pengaruh sama dengan data barang diinput
  $query2 = $koneksi->prepare("SELECT kode_barang FROM pengaruh WHERE no_transaksi = :no_transaksi");
  $query2->bindParam(':no_transaksi', $no_transaksi);
  $query2->execute();
  $row = $query2->fetchAll(PDO::FETCH_COLUMN);

  //Mencari data barang yang berbeda antara barang di tabel pengaruh dan barang yang diinput
  $result = array_diff($row, $arraykode);

  //Untuk setiap data barang yang berbeda, maka data stok barang tersebut di tabel inventory akan dikurangi dengan jumlah barang di tabel pengaruh
  //Agar data stok barang tersebut menjadi sama dengan data stok sebelum barang tersebut dijual
  foreach ($result as $value) {
    $query2 = $koneksi->prepare("UPDATE inventory, pengaruh SET stok = stok + jumlah WHERE pengaruh.no_transaksi = :no_transaksi AND pengaruh.kode_barang = :kode_barang AND inventory.kode_barang = pengaruh.kode_barang");
    $query2->bindParam(':no_transaksi', $no_transaksi);
    $query2->bindParam(':kode_barang', $value);
    $query2->execute();
  }

  //Menghapus data penjualan di tabel pengaruh dengan no. transaksi sekarang
  $query2 = $koneksi->prepare("DELETE FROM pengaruh WHERE no_transaksi = :no_transaksi");
  $query2->bindParam(':no_transaksi', $no_transaksi);
  $query2->execute();

  //Memasukkan data barang yang diinput ke dalam tabel pengaruh
  for($n = 1; $n < $counter; $n++) {
    $no = htmlspecialchars($_POST['no'.$n]);
    $barang = htmlspecialchars($_POST['barang'.$n]);
    $harga = htmlspecialchars($_POST['harga'.$n]);
    $jumlah = htmlspecialchars($_POST['jumlah'.$n]);

    $query2 = $koneksi->prepare("INSERT INTO pengaruh VALUES(:no_transaksi, :kode_barang, :nama_barang, :harga, :jumlah)");
    $query2->bindParam(':no_transaksi', $no_transaksi);
    $query2->bindParam(':kode_barang', $no);
    $query2->bindParam(':nama_barang', $barang);
    $query2->bindParam(':harga', $harga);
    $query2->bindParam(':jumlah', $jumlah);
    $query2->execute();
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembaruan <?php if($query) echo "Sukses"; else echo "Gagal"; ?> - Toko Zati Parts</title>
    <link rel="shortcut icon" href="images/logo.png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css" />
    <link rel="stylesheet" href="css/materialize.css" />
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  </head>
  <body onload="status()">
    <nav>
      <div class="nav-wrapper grey darken-3">
        <a href="index.php" class="brand-logo center">TOKO ZATI PARTS</a>
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
          Nama Konsumen :
          <div class="input-field inline">
            <input type="text" class="validate" name="faktur" value="<?php echo $nama; ?>" readonly />
          </div>
        </div>
        <?php
          if($alamat != "") { //Jika user mengisi Alamat
            echo "<div class='col s12'>
                    Alamat Konsumen :
                    <div class='input-field inline'>
                      <input type='text' class='validate' value='".$alamat."' style='width:320px;' readonly />
                    </div>
                  </div>";
          }

          if ($kurir != "") { //Jika user mengisi Kurir
          echo "<div class='col s12'>
                  Kurir Pengiriman :
                  <div class='input-field inline'>
                    <input type='text' class='validate' value='".$kurir."' readonly />
                  </div>
                </div>";
          }

          if ($ongkir != 0) { //Jika user mengisi Ongkir
            echo "<div class='col s12'>
                    Ongkos Kirim : Rp.
                    <div class='input-field inline'>
                      <input type='text' class='validate' value='".$ongkir."' readonly />
                    </div>
                  </div>";
          }

          if ($no_resi != "") { //Jika user mengisi No. Resi
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
        <div class="col s12">
          Total Pembelian : Rp.
          <div class="input-field inline">
            <input type="text" class="validate" value="<?php echo number_format($total, 0, '', '.'); ?>" readonly />
          </div>
        </div>
        <div class="row"></div>
        <div class="row"></div>
        <div class="col s12 m5 l5 center">
          <a class="waves-effect waves-light btn blue darken-1" href="daftar_penjualan.php"><i class="material-icons left">arrow_forward</i>Kembali Ke Daftar Penjualan</a>
        </div>
        <div class="col s12 m2 l2">&nbsp;</div>
        <div class="col s12 m5 l5 center">
          <a class="waves-effect waves-light btn blue darken-1" href="index.php"><i class="material-icons left">arrow_forward</i>Kembali Ke Menu</a>
        </div>
      </div>
      <div class="row"></div>
      <div class="row"></div>
    </div>
    <script type="text/javascript" src="js/materialize.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
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
          } else {
            echo "swal({
                    title: 'PEMBARUAN DATA GAGAL!',
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
