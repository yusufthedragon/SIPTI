<?php
  include 'koneksi.php';

  session_start(); //Memulai session
  if (!isset($_SESSION['login'])){ //Jika session belum diset/user belum login
    header("location: login.php"); //Maka akan dialihkan ke halaman login
  }

  //Mengambil Kode Barang yang sedang diinput user
  $searchTerm = $_GET['term'];
  $query = $koneksi->prepare("SELECT kode_barang FROM inventory WHERE kode_barang LIKE '%".$searchTerm."%' ORDER BY kode_barang ASC LIMIT 7");
  $query->execute();
  while ($row = $query->fetch()) {
      $data[] = $row['kode_barang'];
  }
  echo json_encode($data);
?>
