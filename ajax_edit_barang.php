<?php
  include 'koneksi.php';
  $kodelama = $_GET['kodelama'];
  $kodebaru = $_GET['kodebaru'];
  $nama_barang = $_GET['nama'];
  $harga = $_GET['harga'];
  $stok = $_GET['jumlah'];

  try{
    $query = $koneksi->prepare("UPDATE inventory SET kode_barang = :kode, nama_barang = :nama_barang, harga = :harga_barang, stok = :stok_barang WHERE kode_barang = '$kodelama'");
    $query->bindParam(":kode", $kodebaru);
    $query->bindParam(":nama_barang", $nama_barang);
    $query->bindParam(":harga_barang", $harga);
    $query->bindParam(":stok_barang", $stok);
    $query->execute();
    throw new PDOException;
  } catch(PDOException $e) {
    if ($e->errorInfo[1] == 1062) {
      echo "<script>
      swal({
            title: 'EDIT DATA GAGAL!',
            text: 'Kode Barang telah terdaftar!',
            type: 'error'
          });
      </script>";
    } else if ($e->errorInfo[1] == 00000) {
      echo "<script>
      swal({
            title: 'EDIT DATA BERHASIL!',
            text: 'Data telah masuk ke database.',
            type: 'success',
            closeOnConfirm: true
          }, function(isConfirm) {
            if (isConfirm) {
              window.location = 'daftar_barang.php';
            }
          });
      </script>";
    }
  }

?>
