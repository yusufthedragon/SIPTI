<?php
include 'koneksi.php';

$no_transaksi = 'PM0002';

$coba = array('1562341200');
print_r($coba);
echo "<br />";

$query2 = $koneksi->prepare("SELECT kode_barang FROM pengaruh WHERE no_transaksi = :no_transaksi");
$query2->bindParam(':no_transaksi', $no_transaksi);
$query2->execute();
$row = $query2->fetchAll(PDO::FETCH_COLUMN);
print_r($row);

$result = array_diff($row, $coba);
echo "<br />";

$beda = count($result);
echo "<br />";
if ($beda == 0) {
  $result = array_diff($coba, $row);
} else $result = array_diff($row, $coba);
print_r($result);
?>
