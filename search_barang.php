<?php
  include 'koneksi.php';
  $searchTerm = $_GET['term'];
  $query = $koneksi->prepare("SELECT kode_barang FROM daftar_barang WHERE kode_barang LIKE '%".$searchTerm."%' ORDER BY kode_barang ASC LIMIT 7");
  $query->execute();
  while ($row = $query->fetch()) {
      $data[] = $row['kode_barang'];
  }
  echo json_encode($data);
?>
