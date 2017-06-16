<?php
  include 'koneksi.php';
  $searchTerm = $_GET['term'];
  $query = $koneksi->prepare("SELECT no_transaksi FROM pembelian WHERE no_transaksi LIKE '%".$searchTerm."%' ORDER BY no_transaksi ASC LIMIT 10");
  $query->execute();
  while ($row = $query->fetch()) {
      $data[] = $row['no_transaksi'];
  }
  echo json_encode($data);
?>
