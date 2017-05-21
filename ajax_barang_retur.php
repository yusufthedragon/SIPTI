<?php
  include 'koneksi.php';
  $no_transaksi = $_GET['no_transaksi'];
  $query = $koneksi->prepare("SELECT * FROM pengaruh WHERE no_transaksi='$no_transaksi'");
  $query->execute();
  $counter = 1;
  while ($row = $query->fetch()) {
    echo "<tr>
    <td>".$row['kode_barang']."</td>
    <td>".$row['nama_barang']."</td>
    <td><input type='text' class='center' id='jumlah$counter' name='jumlah$counter' value=".$row['jumlah']." style='width:50px;' onkeyup='autohitung()' /></td>
    <td><input type='text' class='center' id='harga$counter' name='harga$counter' value=".$row['harga']." hidden /></td>
    <td><input type='text' class='center' id='hitung$counter' name='hitung$counter' value=".$row['harga']." hidden /></td>
    </tr>";
    $counter++;
  }
?>
