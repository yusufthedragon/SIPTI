<?php
  include 'koneksi.php';

  session_start(); //Memulai session
  if (!isset($_SESSION['login'])) { //Jika session belum diset/user belum login
    header("location: login.php"); //Maka akan dialihkan ke halaman login
  }

  //Menerima data yang diinput user
  $kode_barang = htmlspecialchars($_GET['kode']);
  $nama_barang = htmlspecialchars($_GET['nama']);
  $harga = htmlspecialchars($_GET['harga']);
  $stok = htmlspecialchars($_GET['jumlah']);

  try {
    //Memasukkan data yang diinput user ke database
    $query = $koneksi->prepare("INSERT INTO inventory VALUES (:kode_barang, :nama_barang, :harga_barang, :stok_barang)");
    $query->bindParam(":kode_barang", $kode_barang);
    $query->bindParam(":nama_barang", $nama_barang);
    $query->bindParam(":harga_barang", $harga);
    $query->bindParam(":stok_barang", $stok);
    $query->execute();
    throw new PDOException; //Mengirimkan kode eksepsi
  } catch (PDOException $e) { //Menangkap kode eksepsi
    if ($e->errorInfo[1] == 1062) { //Jika Kode Barang sudah ada / duplikat
      echo "<script>
            swal({
              title: 'TAMBAH DATA GAGAL!',
              text: 'Kode Barang telah terdaftar!',
              type: 'error'
            });
            </script>";
    } else if ($e->errorInfo[1] == 00000) { //00000 adalah kode ekspesi yang menandakan bahwa query berhasil
      echo "<script>
            swal({
              title: 'TAMBAH DATA BERHASIL!',
              text: 'Data telah masuk ke database.',
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

