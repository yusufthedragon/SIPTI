<?php
  include 'koneksi.php';

  session_start(); //Memulai session
  if (!isset($_SESSION['login'])) { //Jika session belum diset/user belum login
    header("location: login.php"); //Maka akan dialihkan ke halaman login
  }

  //Mengambil data pembelian dari database berdasarkan No. Transaksi dari Detail Penjualan
  $no_transaksi = $_GET['no_transaksi'];
  $query = $koneksi->prepare("SELECT * FROM penjualan WHERE no_transaksi = :no_transaksi");
  $query->bindParam(':no_transaksi', $no_transaksi);
  $query->execute();
  $row = $query->fetch();
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Edit Penjualan - Toko Zati Parts</title>
    <link rel="shortcut icon" href="images/logo.png" />
    <link rel="stylesheet" href="css/jquery-ui.css" />
    <link rel="stylesheet" href="css/sweetalert.css" />
    <link rel="stylesheet" href="css/materialize.css" />
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
      <h3 class="center">EDIT PENJUALAN</h3>
      <div class="row">
        <form name="myform" action="sukses_edit_penjualan.php" method="post">
          <div class="col s12">
            No. Transaksi :
            <div class="input-field inline">
              <input type="text" id="no_transaksi" name="no_transaksi" class="validate" value="<?php echo $row['no_transaksi']; ?>" readonly />
            </div>
          </div>
          <div class="col s12">
            Tanggal :
            <div class="input-field inline">
              <input type="date" class="klik" id="datepicker" name="tanggal" autocomplete="off" value="<?php echo $row['tanggal']; ?>" />
            </div>
          </div>
          <div class="col s12">
            Masukkan Nama Konsumen :
            <div class="input-field inline">
              <input type="text" id="nama" name="nama" class="validate" onkeyup="firstUpperF(this)" autocomplete="off" value="<?php echo $row['nama']; ?>" />
            </div>
          </div>
          <div class="col s12">
            Masukkan Alamat Konsumen :
            <div class="input-field inline">
              <input type="text" id="alamat" name="alamat" style="width:320px;" class="validate" autocomplete="off" value="<?php echo $row['alamat']; ?>" />
            </div>
          </div>
          <div class="row"></div>
          <div class="col s12">
            Masukkan Penjualan :
          </div>
          <div class="row"></div>
          <div id="gruppenjualan">
            <?php
              //Mengambil data barang yang dijual dan stok yang ada di table Inventory
              $query2 = $koneksi->prepare("SELECT pengaruh.*, inventory.stok FROM pengaruh, inventory WHERE no_transaksi = :no_transaksi AND inventory.kode_barang = pengaruh.kode_barang");
              $query2->bindParam(':no_transaksi', $no_transaksi);
              $query2->execute();

              $i = 1;
              while ($row2 = $query2->fetch()) {
                echo "<div id = 'penjualan".$i."'>
                        <div class = 'col s4'>
                          <center><label>No. Barang #".$i."</label></center>
                          <input type='text' id='no".$i."' name='no".$i."' class='center autocomplete' onkeyup='autofill(this), autohitung(), upperCaseF(this)' value='".$row2['kode_barang']."' />
                        </div>
                        <div class='col s4'>
                            <center><label>Nama Barang</label></center>
                            <input type='text' name='barang".$i."' id='barang".$i."' class='center validate' readonly value='".$row2['nama_barang']."'/>
                        </div>
                        <div class='col s4'>
                            <center><label for='jumlah".$i."'>Jumlah Barang</label></center>
                            <input type='text' name='jumlah".$i."' id='jumlah".$i."' class='center validate' onkeyup='autohitung()' value='".$row2['jumlah']."' autocomplete='off' />
                        </div>
                        <div class='col s3'>
                            <input type='text' name='harga".$i."' id='harga".$i."' class='validate' value='".$row2['harga']."' hidden />
                        </div>
                        <div class='col s12'>
                            <input type='text' name='hitung".$i."' id='hitung".$i."'value='".$row2['harga']."' hidden  />
                        </div>
                        <div class='col s12'>
                          <input type='text' name='stok".$i."' id='stok".$i."'value='".($row2['stok']+$row2['jumlah'])."' hidden />
                        </div>
                      </div>";
                $i++;
              }
              echo "<input type='text' id='counter' name='counter' value='".$i."' hidden />";
            ?>
          </div>
          <div class="col s3"></div>
          <div class="col s3 center">
            <a class="waves-effect waves-light btn blue darken-1" id="tambah"><i class="material-icons left">add</i>Tambah</a>
          </div>
          <div class="col s3 center">
            <a class="waves-effect waves-light btn blue darken-1" id="hapus"><i class="material-icons left">delete</i>Hapus</a>
          </div>
          <div class="col s3"></div>
          <div class="row"></div>
          <div class="col s12">
            Pilih Kurir :
            <div class="inline">
              <input name="kurir" type="radio" id="kurir1" value="" <?php if ($row['kurir'] == "") echo "checked"; ?> />
              <label for="kurir1" style="color:black;">TIDAK ADA</label>
              <br />
              <input name="kurir" type="radio" id="kurir2" value="JNE REGULER" <?php if ($row['kurir'] == "JNE REGULER") echo "checked"; ?> />
              <label for="kurir2" style="color:black;">JNE REGULER</label>
              <br />
              <input name="kurir" type="radio" id="kurir3" value="JNE YES" <?php if ($row['kurir'] == "JNE YES") echo "checked"; ?> />
              <label for="kurir3" style="color:black;">JNE YES</label>
              <br />
              <input name="kurir" type="radio" id="kurir4" value="POS KILAT" <?php if ($row['kurir'] == "POS KILAT") echo "checked"; ?> />
              <label for="kurir4" style="color:black;">POS KILAT</label>
              <br />
              <input name="kurir" type="radio" id="kurir5" value="TIKI" <?php if ($row['kurir'] == "TIKI") echo "checked"; ?> />
              <label for="kurir5" style="color:black;">TIKI</label>
            </div>
          </div>
          <div class="col s12">
            Ongkos Kirim : Rp.
            <div class="input-field inline">
              <input type="text" id="ongkir" name="ongkir" class="validate" autocomplete="off" value="<?php echo $row['ongkir']; ?>" />
            </div>
          </div>
          <div class="col s12">
            Masukkan No. Resi :
            <div class="input-field inline">
              <input type="text" id="resi" name="resi" class="validate" onkeydown="upperCaseF(this)" autocomplete="off" value="<?php echo $row['no_resi']; ?>" />
            </div>
          </div>
          <div class="col s12">
            Total Harga : Rp.
            <div class="input-field inline">
              <input type="text" id="total" name="total" class="validate" value="<?php echo $row['total']; ?>" readonly />
            </div>
          </div>
          <div class="row"></div>
          <div class="row"></div>
          <div class="col s6 center">
            <a class="waves-effect waves-light btn green accent-4" id="konfirmasi"><i class="material-icons left">edit</i>Perbarui</a>
          </div>
          <div class="col s6 center">
            <a class="waves-effect waves-light btn blue darken-1" <?php echo "href = 'lihat_penjualan.php?no_transaksi=".$row['no_transaksi']."'" ?> ><i class="material-icons left">cancel</i>Batal</a>
          </div>
          <div class="row"></div>
          <div class="row"></div>
          <div class="row"><strong>Pastikan data yang diinput sudah benar.</strong></div>
        </form>
      </div>
    </div>
    <script type="text/javascript" src="js/materialize.js"></script>
    <script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="js/jquery-ui.js"></script>
    <script type="text/javascript" src="js/datepicker-id.js"></script>
    <script type="text/javascript" src="js/sweetalert.js"></script>
    <script type="text/javascript" src="js/penjualan.js"></script>
  </body>
</html>
