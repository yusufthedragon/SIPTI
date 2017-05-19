<?php
  include 'koneksi.php';

  $kode_barang = $_GET['kode'];
  $query = $koneksi->prepare("DELETE FROM inventory WHERE kode_barang = :kode");
  $query->bindParam(":kode", $kode_barang);
  $query->execute();
  $count = $query->rowCount();

  if ($count == 0) {
    echo "<script>
            swal({
                  title: 'HAPUS DATA GAGAL!',
                  text: 'Kode Barang tidak terdaftar!',
                  type: 'error'
                });
          </script>";
  } else {
    echo "<script>
            swal({
                  title: 'HAPUS DATA BERHASIL!',
                  text: 'Data telah dihapus dari database.',
                  type: 'success'
                }, function(isConfirm) {
                  if (isConfirm) {
                    window.location = 'daftar_barang.php';
                  }
                });
          </script>";
  }
?>
