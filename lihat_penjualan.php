<?php
  include 'koneksi.php';

  $no_transaksi = $_GET['no_transaksi'];

  $query = $koneksi->prepare("SELECT * FROM penjualan WHERE no_transaksi = '$no_transaksi'");
  $query->execute();
  $row = $query->fetch();

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Lihat Penjualan - Toko Zati Parts</title>
    <link rel="stylesheet" href="css/materialize.min.css" />
    <link rel="stylesheet" href="css/sweetalert.css" />
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

    <div id="keterangan"></div>

    <div class="container">
      <h3 class="center">TRANSAKSI PENJUALAN</h3>
      <div class="row">
        <div class="col s12">
          No. Transaksi :
          <div class="input-field inline">
            <input type="text" class="validate" id="no_transaksi" value="<?php echo $row['no_transaksi']; ?>" readonly />
          </div>
        </div>
        <div class="col s12">
          Tanggal :
          <div class="input-field inline">
            <input type="text" id="datepicker" name="tanggal" value="<?php echo $row['tanggal']; ?>" readonly />
          </div>
        </div>
        <div class="col s12">
            Nama Konsumen :
            <div class="input-field inline">
              <input type="text" class="validate" name="faktur" value="<?php echo $row['nama']; ?>" readonly />
            </div>
        </div>
        <?php
        if($row['alamat'] != "") {
          echo "<div class='col s12'>
              Alamat Konsumen :
              <div class='input-field inline'>
                <input type='text' class='validate' value='".$row['alamat']."' readonly />
              </div>
          </div>";
        }
        if ($row['kurir'] != "") {
        echo "<div class='col s12'>
          Kurir Pengiriman :
          <div class='input-field inline'>
            <input type='text' class='validate' value='".$row['kurir']."' readonly />
          </div>
        </div>";
        }
        if($row['ongkir'] != 0) {
          echo "<div class='col s12'>
            Ongkos Kirim : Rp.
            <div class='input-field inline'>
              <input type='text' class='validate' value='".number_format($row['ongkir'], 0, '', '.')."' readonly />
            </div>
          </div>";
        }
        if($row['no_resi'] != "") {
          echo "<div class='col s12'>
            No. Resi :
            <div class='input-field inline'>
              <input type='text' class='validate' value='".$row['no_resi']."' readonly />
            </div>
          </div>";
        }
        ?>
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
                $query2 = $koneksi->prepare("SELECT * FROM pengaruh WHERE no_transaksi = '$no_transaksi'");
                $query2->execute();

                while($row2 = $query2->fetch()) {
                  echo "<tr>
                  <td>".$row2['kode_barang']."</td>
                  <td>".$row2['nama_barang']."</td>
                  <td>".$row2['jumlah']."</td>
                  </tr>";
                }
              ?>
            </tbody>
          </table>
        </div>
        <div class="row"></div>
        <div class="col s12">
          Total Pembelian : Rp.
          <div class="input-field inline">
            <input type="text" class="validate" value="<?php echo number_format($row['total'], 0, '', '.'); ?>" readonly />
          </div>
        </div>
        <div class="row"></div>
        <div class="row"></div>
        <div class="col s4 center">
          <a class="waves-effect waves-light btn red" onclick="hapus()"><i class="material-icons left">delete</i>Hapus Pembelian</a>
        </div>
        <div class="col s4 center">
          <a class="waves-effect waves-light btn green accent-4" <?php echo "href='edit_penjualan.php?no_transaksi=".$row['no_transaksi']."'"; ?>><i class="material-icons left">edit</i>Edit Pembelian</a>
        </div>
        <div class="col s4 center">
          <a class="waves-effect waves-light btn blue darken-1" href="daftar_penjualan.php"><i class="material-icons left">arrow_forward</i>Kembali</a>
        </div>
      </div>
      <div class="row"></div>
      <div class="row"></div>
    </div>
    <script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <script type="text/javascript" src="js/sweetalert.js"></script>
    <script>
      function hapus() {
        swal({
          title: "Anda yakin?",
          text: "Data tersebut akan dihapus dari database!",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Ya, saya yakin!",
          cancelButtonText: "Batal",
          closeOnConfirm: true
        }, function(isConfirm) {
          if (isConfirm) {
            var no_transaksi = $("#no_transaksi").val();
            $.ajax({
              url: 'ajax_hapus_penjualan.php',
              dataType: "html",
              data: 'no_transaksi=' + no_transaksi,
            }).success(function(data) {
                  $('#keterangan').html(data);
              });
          }
        });
      }
    </script>
  </body>
</html>
