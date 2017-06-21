<?php
  include 'koneksi.php';

  session_start(); //Memulai session
  if (!isset($_SESSION['login'])) { //Jika session belum diset/user belum login
    header("location: login.php"); //Maka akan dialihkan ke halaman login
  }

  //Menghapus seluruh data di table Penjualan
  $query = $koneksi->prepare("TRUNCATE penjualan");
  $query->execute();

  //Menghapus seluruh data penjualan di table Pengaruh
  $query = $koneksi->prepare("DELETE FROM pengaruh WHERE no_transaksi LIKE 'PN%'");
  $query->execute();

  //Me-refresh halaman Daftar Penjualan
  header("Refresh:0; url=daftar_penjualan.php");
?>
