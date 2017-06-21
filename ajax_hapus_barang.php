<?php
  include 'koneksi.php';

  session_start(); //Memulai session
  if (!isset($_SESSION['login'])) { //Jika session belum diset/user belum login
    header("location: login.php"); //Maka akan dialihkan ke halaman login
  }

  //Menerima Kode Barang yang diinput user
  $kode_barang = $_GET['kode'];

  //Menghapus barang dari table Pengaruh
  $query = $koneksi->prepare("DELETE FROM pengaruh WHERE kode_barang = :kode");
  $query->bindParam(":kode", $kode_barang);
  $query->execute();

  //Menghapus barang dari table Inventory
  $query = $koneksi->prepare("DELETE FROM inventory WHERE kode_barang = :kode");
  $query->bindParam(":kode", $kode_barang);
  $query->execute();

  //Mengambil jumlah record yang terpengaruh oleh query diatas
  $count = $query->rowCount();

  //Jika record tidak ada yang terpengaruh
  if ($count == 0) {
    echo "<script>
            swal({
              title: 'HAPUS DATA GAGAL!',
              text: 'Kode Barang tidak terdaftar!',
              type: 'error'
            });
          </script>";
  } else {
    echo "<script>
            swal({
              title: 'HAPUS DATA BERHASIL!',
              text: 'Data telah dihapus dari database.',
              type: 'success'
            }, function(isConfirm) {
              if (isConfirm) {
                window.location = 'daftar_barang.php';
              }
            });
          </script>";
  }
?>
