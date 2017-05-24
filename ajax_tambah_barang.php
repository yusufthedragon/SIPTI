<?php
  include 'koneksi.php';
  $kode_barang = htmlspecialchars($_GET['kode']);
  $nama_barang = htmlspecialchars($_GET['nama']);
  $harga = htmlspecialchars($_GET['harga']);
  $stok = htmlspecialchars($_GET['jumlah']);

  $query = $koneksi->prepare("SELECT kode_barang FROM inventory WHERE kode_barang = :kode_barang");
  $query->bindParam(':kode_barang', $kode_barang);
  $query->execute();
  $baris = $query->rowCount();

  if ($baris > 0) {
    echo "<script>
            sweetAlert('TAMBAH DATA GAGAL!', 'Kode Barang telah terdaftar.', 'error');
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
?>
