<?php
  include 'koneksi.php';
  $no_transaksi = "PM0001";
  $query = $koneksi->prepare("SELECT kode_barang, nama_barang, jumlah FROM transaksi_barang WHERE no_transaksi='$no_transaksi'");
  $query->execute();
  $inventori = $query->fetchAll();
  while ($inventori) {
    echo "<tr>
    <td>".$inventori['kode_barang']."</td><td>".$inventori['nama_barang']."</td><td>".$inventori['jumlah']."</td>
    </tr>";
  }

?>
