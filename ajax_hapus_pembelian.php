<?php  
  include 'koneksi.php';

  $no_transaksi = $_GET['no_transaksi'];

  $query = $koneksi->prepare("DELETE FROM pembelian, transaksi_barang WHERE no_transaksi = :no_transaksi");

?>
