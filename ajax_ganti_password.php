<?php
  include 'koneksi.php';

  $lama = $_GET['lama'];
  $baru = $_GET['baru'];

  $query = $koneksi->prepare("SELECT * FROM user");
  $query->execute();
  $row = $query->fetch();

  if (!password_verify($lama, $row['password'])) {
    echo "<script>
            swal({
               title: 'GANTI PASSWORD GAGAL!',
               text: 'Password Lama anda salah!',
               type: 'error'
             });
          </script>";
  } else {
    $baru = password_hash($baru, PASSWORD_DEFAULT);
    $query = $koneksi->prepare("UPDATE user SET password = :password");
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
