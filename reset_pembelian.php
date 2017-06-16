<?php
  include 'koneksi.php';

  $query = $koneksi->prepare("TRUNCATE pembelian");
  $query->execute();

  $query = $koneksi->prepare("DELETE FROM pengaruh WHERE no_transaksi LIKE 'PM%'");
  $query->execute();

  header("Refresh:0; url=daftar_pembelian.php");
?>
