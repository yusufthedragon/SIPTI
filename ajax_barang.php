<?php
  include 'koneksi.php';

  session_start(); //Memulai session
  if (!isset($_SESSION['login'])) { //Jika session belum diset/user belum login
    header("location: login.php"); //Maka akan dialihkan ke halaman login
  }

  //Mengambil data barang dari table Inventory
  $no = $_GET['no'];
  $query = $koneksi->prepare("SELECT * FROM inventory WHERE kode_barang = :kode");
  $query->bindParam(":kode", $no);
  $query->execute();
  $inventori = $query->fetch();
  $data = array(
            'nama_barang' =>  $inventori['nama_barang'],
            'harga'       =>  $inventori['harga'],
            'stok'        =>  $inventori['stok']);
  echo json_encode($data);
?>
