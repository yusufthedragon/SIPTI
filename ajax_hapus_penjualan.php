<?php
  include 'koneksi.php';

  $no_transaksi = $_GET['no_transaksi'];

  $query = $koneksi->prepare("UPDATE inventory, pengaruh SET stok = stok + jumlah WHERE pengaruh.no_transaksi = :no_transaksi AND inventory.kode_barang = pengaruh.kode_barang");
  $query->bindParam(':no_transaksi', $no_transaksi);
  $query->execute();

  $query = $koneksi->prepare("DELETE penjualan.*, pengaruh.* FROM penjualan, pengaruh WHERE penjualan.no_transaksi = pengaruh.no_transaksi AND penjualan.no_transaksi = :no_transaksi;");
  $query->bindParam(":no_transaksi", $no_transaksi);
  $query->execute();

  if ($query->rowCount() == 0) {
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
          text: 'Data transaksi telah dihapus dari database.',
          type: 'success'
        }, function(isConfirm) {
          if (isConfirm) {
            window.location = 'daftar_penjualan.php';
          }
        });
    </script>";
  }

?>
