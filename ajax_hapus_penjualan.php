<?php
  include 'koneksi.php';

  session_start(); //Memulai session
  if (!isset($_SESSION['login'])) { //Jika session belum diset/user belum login
    header("location: login.php"); //Maka akan dialihkan ke halaman login
  }

  //Mengambil No. Transaksi yang dijadikan parameter pada Detail Penjualan
  $no_transaksi = $_GET['no_transaksi'];

  //Mengembalikan stok di table Inventory seperti sedia kala sebelum dilakukan penjualan
  $query = $koneksi->prepare("UPDATE inventory, pengaruh SET stok = stok + jumlah WHERE pengaruh.no_transaksi = :no_transaksi AND inventory.kode_barang = pengaruh.kode_barang");
  $query->bindParam(':no_transaksi', $no_transaksi);
  $query->execute();

  //Menghapus data penjualan yang memiliki No. Transaksi terkait
  $query = $koneksi->prepare("DELETE penjualan.*, pengaruh.* FROM penjualan, pengaruh WHERE penjualan.no_transaksi = pengaruh.no_transaksi AND penjualan.no_transaksi = :no_transaksi;");
  $query->bindParam(":no_transaksi", $no_transaksi);
  $query->execute();

  //Jika tidak ada record yang terpengaruh oleh query DELETE
  if ($query->rowCount() == 0) {
    echo "<script>
          swal({
            title: 'HAPUS DATA GAGAL!',
            text: 'Data tidak berhasil dihapus.',
            type: 'error'
          });
          </script>";
  } else {
    echo "<script>
          swal({
            title: 'HAPUS DATA BERHASIL!',
            text: 'Data transaksi telah dihapus dari database.',
            type: 'success'
          }, function(isConfirm) {
            if (isConfirm) {
              window.location = 'daftar_penjualan.php';
            }
          });
          </script>";
  }

?>
