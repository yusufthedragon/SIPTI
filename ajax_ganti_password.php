<?php
  include 'koneksi.php';

  session_start(); //Memulai session
  if (!isset($_SESSION['login'])) { //Jika session belum diset/user belum login
    header("location: login.php"); //Maka akan dialihkan ke halaman login
  }

  //Mengambil Password Lama dan Password Baru yang diinput user
  $lama = $_GET['lama'];
  $baru = $_GET['baru'];

  //Mengambil password user di database
  $query = $koneksi->prepare("SELECT * FROM user");
  $query->execute();
  $row = $query->fetch();

  if (!password_verify($lama, $row['password'])) { //Jika Password Lama berbeda dengan password di database
    echo "<script>
            swal({
             title: 'GANTI PASSWORD GAGAL!',
             text: 'Password Lama anda salah!',
             type: 'error'
            });
          </script>";
  } else {
    $baru = password_hash($baru, PASSWORD_DEFAULT); //Melakukan hashing pada Password Baru
    $query = $koneksi->prepare("UPDATE user SET password = :password"); //Memperbarui password di database
    $query->bindParam(':password', $baru);
    $query->execute();
    echo "<script>
            swal({
              title: 'GANTI PASSWORD BERHASIL!',
              text: 'Password Lama telah diganti dengan Password Baru.',
              type: 'success'
            }, function(isConfirm) {
              if (isConfirm) {
                window.location = 'index.php';
              }
            });
          </script>";
  }
?>
