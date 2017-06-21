<?php
  include 'koneksi.php';

  session_start(); //Memulai session
  if (!isset($_SESSION['login'])) { //Jika session belum diset/user belum login
    header("location: login.php"); //Maka akan dialihkan ke halaman login
  }

  //Menghapus seluruh data di table Pembelian
  $query = $koneksi->prepare("TRUNCATE pembelian");
  $query->execute();

  //Menghapus seluruh data pembelian di table Pengaruh
  $query = $koneksi->prepare("DELETE FROM pengaruh WHERE no_transaksi LIKE 'PM%'");
  $query->execute();

  //Me-refresh halaman Daftar Pembelian
  header("Refresh:0; url=daftar_pembelian.php");
?>
