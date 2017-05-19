<?php
  include 'koneksi.php';
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
