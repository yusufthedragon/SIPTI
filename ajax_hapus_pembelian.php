<?php
  include 'koneksi.php';

  $no_transaksi = $_GET['no_transaksi'];

  $query = $koneksi->prepare("DELETE pembelian.*, transaksi_barang.* FROM pembelian, transaksi_barang WHERE pembelian.no_transaksi = transaksi_barang.no_transaksi AND pembelian.no_transaksi = :no_transaksi;");
  $query->bindParam(":no_transaksi", $no_transaksi);
  $query->execute();

  $baris = $query->rowCount();

  if ($baris == 0) {
    echo "<script>
    swal({
          title: 'HAPUS DATA GAGAL!',
          text: 'Data tidak berhasil dihapus.',
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
            window.location = 'daftar_pembelian.php';
          }
        });
    </script>";
  }

?>
