<?php
include 'koneksi.php';
$i = 4;
for (; $i < 40; $i++) {
  $query = $koneksi->prepare("INSERT INTO penjualan VALUES ('$i', '11 Juli 2017', 'Yusuf', 'Konoha', 'JNE YES', 18000, '1726384759837261', 2000000)");
    $query->execute();
}
?>
