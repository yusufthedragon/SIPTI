<?php
  include 'koneksi.php';
  $no_transaksi = $_GET['no_transaksi'];
  $query = $koneksi->prepare("SELECT * FROM pembelian WHERE no_transaksi='$no_transaksi'");
  $query->execute();
  $transaksi = $query->fetch();
  $data = array(
            'tanggal' =>  $transaksi['tanggal'],
            'faktur' =>  $transaksi['no_faktur'],
            'toko' =>  $transaksi['toko'],
            'total' =>  $transaksi['total'],);
  echo json_encode($data);
?>
