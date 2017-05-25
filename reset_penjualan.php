<?php
  include 'koneksi.php';

  $query = $koneksi->prepare("TRUNCATE penjualan");
  $query->execute();

  $query = $koneksi->prepare("DELETE FROM pengaruh WHERE no_transaksi LIKE 'PN%'");
  $query->execute();

  header("Refresh:0; url=daftar_penjualan.php");
?>
