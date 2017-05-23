<?php
  include 'koneksi.php';

  $query = $koneksi->prepare("TRUNCATE pembelian");
  $query->execute();

  $query = $koneksi->prepare("DELETE FROM pengaruh WHERE no_transaksi LIKE 'PM%'");
  $query->execute();

  header('Location: daftar_pembelian.php');
?>
