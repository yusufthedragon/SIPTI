<?php
  include 'koneksi.php';

  session_start(); //Memulai session
  if (!isset($_SESSION['login'])) { //Jika session belum diset/user belum login
    header("location: login.php"); //Maka akan dialihkan ke halaman login
  }

  //Menerima input yang di-submit
  $kodelama = htmlspecialchars($_GET['kodelama']);
  $kodebaru = htmlspecialchars($_GET['kodebaru']);
  $nama_barang = htmlspecialchars($_GET['nama']);
  $harga = htmlspecialchars($_GET['harga']);
  $stok = htmlspecialchars($_GET['jumlah']);

  try{
    //Memperbarui data barang
    $query = $koneksi->prepare("UPDATE inventory SET kode_barang = :kode, nama_barang = :nama_barang, harga = :harga_barang, stok = :stok_barang WHERE kode_barang = '$kodelama'");
    $query->bindParam(":kode", $kodebaru);
    $query->bindParam(":nama_barang", $nama_barang);
    $query->bindParam(":harga_barang", $harga);
    $query->bindParam(":stok_barang", $stok);
    $query->execute();
    throw new PDOException;
  } catch(PDOException $e) {
    if ($e->errorInfo[1] == 1062) { //Error 1062 menandakan duplicate key
      echo "<script>
            swal({
              title: 'EDIT DATA GAGAL!',
              text: 'Kode Barang telah terdaftar!',
              type: 'error'
            });
            </script>";
    } else {
      echo "<script>
            swal({
              title: 'EDIT DATA BERHASIL!',
              text: 'Data telah diperbarui.',
              type: 'success'
            }, function(isConfirm) {
              if (isConfirm) {
                window.location = 'daftar_barang.php';
              }
            });
            </script>";
    }
  }
?>
