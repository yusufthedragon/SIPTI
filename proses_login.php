<?php
  include 'koneksi.php';

  session_start(); // Memulai Session

  $error=''; // Variabel untuk menyimpan pesan error

  if (isset($_POST['login'])) {
  	if (empty($_POST['password'])) {
  			$error = "Username or Password is invalid";
  	}
  	else
  	{

  		$password = htmlspecialchars($_POST['password']);

      $password = password_hash($password, PASSWORD_DEFAULT);

  		// SQL query untuk memeriksa apakah karyawan terdapat di database?
  		$query = $koneksi->prepare("SELECT * FROM user WHERE password = :password");
      $query->bindParam(':password', $password);
  		$query->execute();

  			if ($query->rowCount() == 1) {
  				$_SESSION['login_user'] = 'admin'; // Membuat Sesi/session
                      header("location: index.php"); // Mengarahkan ke halaman profil
  				} else {
                      $error = "Username atau Password belum terdaftar";
  				}
  	}
  }
?>
