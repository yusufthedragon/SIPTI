<?php
  include 'koneksi.php';

  $no_transaksi = $_GET['no_transaksi'];

  $query = $koneksi->prepare("SELECT * FROM pembelian WHERE no_transaksi = '$no_transaksi'");
  $query->execute();
  $row = $query->fetch();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Edit Pembelian</title>
    <link rel="stylesheet" href="css/jquery-ui.css" />
    <link rel="stylesheet" href="css/sweetalert.css" />
    <link rel="stylesheet" href="css/materialize.min.css" />
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="js/jquery-ui.js"></script>
    <script type="text/javascript" src="js/datepicker-id.js"></script>
    <script type="text/javascript" src="js/sweetalert.js"></script>
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
        <h3 class="center">EDIT PEMBELIAN</h3>
        <div class="row">
          <form name="myform" method="post" action="sukses_edit_pembelian.php">
            <div class="col s12">
                No. Transaksi :
                <div class="input-field inline">
                    <input type="text" class="validate" name="no_transaksi" id="no_transaksi" value="<?php echo $row['no_transaksi']; ?>" readonly />
                </div>
            </div>
            <div class="col s12">
                Tanggal :
                <div class="input-field inline">
                    <input type="date" id="datepicker" name="tanggal" value="<?php echo $row['tanggal']; ?>" />
                </div>
            </div>
            <div class="col s12">
                No. Faktur :
                <div class="input-field inline">
                    <input type="text" class="validate" id="faktur" name="faktur" value="<?php echo $row['no_faktur']; ?>" />
                </div>
            </div>
            <div class="row"></div>
            <div class="col s2">
                Pilih Toko :
            </div>
            <div class="col s10">
                <input name="toko" type="radio" id="toko1" value="Sartika Motor" onclick="autohitung()" <?php if ($row['toko'] == "Sartika Motor") echo "checked"; ?> />
                <label for="toko1" style="color:black;">Sartika Motor</label>
                <br />
                <input name="toko" type="radio" id="toko2" value="Wijaya Motor" onchange="autohitung()" <?php if ($row['toko'] == "Wijaya Motor") echo "checked"; ?> />
                <label for="toko2" style="color:black;">Wijaya Motor</label>
                <br />
                <input name="toko" type="radio" id="toko3" value="Ramayana Motor" onchange="autohitung()" <?php if ($row['toko'] == "Ramayana Motor") echo "checked"; ?> />
                <label for="toko3" style="color:black;">Ramayana Motor</label>
                <br />
                <input name="toko" type="radio" id="toko4" value="Sarana Motor" onchange="autohitung()" <?php if ($row['toko'] == "Sarana Motor") echo "checked"; ?> />
                <label for="toko4" style="color:black;">Sarana Motor</label>
            </div>
            <div class="row"></div>
            <div class="row"></div>
            <div class="col s12">
                Masukkan Pembelian :
            </div>
            <div class="row"></div>
            <div id="gruppembelian">
              <?php
                $query2 = $koneksi->prepare("SELECT * FROM pengaruh WHERE no_transaksi = '$no_transaksi'");
                $query2->execute();
                $i = 1;

                while ($row2 = $query2->fetch()) {
                  echo "<div id = 'pembelian".$i."'>
                          <div class = 'col s4'>
                            <center><label>No. Barang #".$i."</label></center>
                            <input type='text' id='no".$i."' name='no".$i."' class='autocomplete' onkeyup='autofill(this), autohitung(), upperCaseF(this)' value='".$row2['kode_barang']."' />
                          </div>
                          <div class='col s4'>
                              <center><label>Nama Barang</label></center>
                              <input type='text' name='barang".$i."' id='barang".$i."' class='validate' readonly value='".$row2['nama_barang']."'/>
                          </div>
                          <div class='col s4'>
                              <center><label for='jumlah".$i."'>Jumlah Barang</label></center>
                              <input type='text' name='jumlah".$i."' id='jumlah".$i."' class='center validate' onkeyup='autohitung()' value='".$row2['jumlah']."' />
                          </div>
                          <div class='col s3'>
                              <input type='text' name='harga".$i."' id='harga".$i."' class='center validate' hidden value='".$row2['harga']."' />
                          </div>
                          <div class='col s12'>
                              <input type='text' name='hitung".$i."' id='hitung".$i."' hidden value='".$row2['harga']."' />
                          </div>
                        </div>";
                  $i++;
                }
                echo "<input type='text' id='counter' value='".$i."' hidden />";
              ?>
            </div>
            <div class="col s12 center">
                <input type='button' value='Tambah' id='tambah' class="waves-light btn">
                <input type='button' value='Hapus' id='hapus' class="waves-light btn">
            </div>
            <div class="col s12">
                Total Harga : Rp.
                <div class="input-field inline">
                  <input type="text" id="total" name="total" class="validate" value="<?php echo number_format($row['total'], 0, '', '.'); ?>" readonly />
                </div>
            </div>
            <div class="row"></div>
            <div class="row"></div>
            <div class="col s6 center">
                <a class="waves-effect waves-light btn" id="edit">Perbarui</a>
            </div>
            <div class="col s6 center">
                <a class="waves-effect waves-light btn" <?php echo "href = 'lihat_pembelian.php?no_transaksi=".$row['no_transaksi']."'" ?> >Batal</a>
            </div>
            <div class="row"></div>
            <div class="row"></div>
            <div class="row"><strong>Pastikan data yang diinput sudah benar.</strong></div>
          </form>
        </div>
    </div>
    <script type="text/javascript" src="js/pembelian.js"></script>
</body>

</html>
