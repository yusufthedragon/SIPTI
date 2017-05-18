<?php
  include 'koneksi.php';
  $no = $_GET['no'];
  $query = $koneksi->prepare("SELECT nama_barang, harga, stok FROM inventory WHERE kode_barang='$no'");
  $query->execute();
  $inventori = $query->fetch();
  $data = array(
            'nama_barang' =>  $inventori['nama_barang'],
            'harga'       =>  $inventori['harga'],
            'stok'        =>  $inventori['stok']);
  echo json_encode($data);
?>
