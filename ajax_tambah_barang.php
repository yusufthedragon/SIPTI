<?php
  include 'koneksi.php';
  $kode_barang = $_GET['kode'];
  $nama_barang = $_GET['nama'];
  $harga = $_GET['harga'];
  $stok = $_GET['jumlah'];

  $query = $koneksi->prepare("SELECT kode_barang FROM inventory WHERE kode_barang = '$kode_barang'");
  $query->execute();

  if($query->fetch()) {
    echo "<script>
    swal({
          title: 'INPUT DATA GAGAL!',
          text: 'Kode Barang telah terdaftar!',
          type: 'error'
        });
    </script>";
  } else {
    $query = $koneksi->prepare("INSERT INTO inventory VALUES (:kode_barang, :nama_barang, :harga_barang, :stok_barang)");
    $query->bindParam(":kode_barang", $kode_barang);
    $query->bindParam(":nama_barang", $nama_barang);
    $query->bindParam(":harga_barang", $harga);
    $query->bindParam(":stok_barang", $stok);
    $query->execute();
    
    echo "<script>
    swal({
          title: 'INPUT DATA BERHASIL!',
          text: 'Data telah masuk ke database.',
          type: 'success'
        }, function(isConfirm) {
          if (isConfirm) {
            window.location = 'daftar_barang.php';
          }
        });
    </script>";
  }
?>
