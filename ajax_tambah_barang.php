<?php
  include 'koneksi.php';
  $kode_barang = htmlspecialchars($_GET['kode']);
  $nama_barang = htmlspecialchars($_GET['nama']);
  $harga = htmlspecialchars($_GET['harga']);
  $stok = htmlspecialchars($_GET['jumlah']);

  try {
    $query = $koneksi->prepare("INSERT INTO inventory VALUES (:kode_barang, :nama_barang, :harga_barang, :stok_barang)");
    $query->bindParam(":kode_barang", $kode_barang);
    $query->bindParam(":nama_barang", $nama_barang);
    $query->bindParam(":harga_barang", $harga);
    $query->bindParam(":stok_barang", $stok);
    $query->execute();
    throw new PDOException;
  } catch (PDOException $e) {
    if ($e->errorInfo[1] == 1062) {
      echo "<script>
      swal({
            title: 'TAMBAH DATA GAGAL!',
            text: 'Kode Barang telah terdaftar!',
            type: 'error'
          });
      </script>";
    } else if ($e->errorInfo[1] == 00000) {
      echo "<script>
      swal({
            title: 'TAMBAH DATA BERHASIL!',
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
