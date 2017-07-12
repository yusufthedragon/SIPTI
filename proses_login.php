<?php
  include 'koneksi.php';

  session_start();

  $error = "";

  if (isset($_POST['login'])) {
    $password = htmlspecialchars($_POST['password']);
  	$query = $koneksi->prepare("SELECT * FROM user");
  	$query->execute();
    $row = $query->fetch();

  	if (password_verify($password, $row['password'])) {
  		$_SESSION['login'] = true; // Membuat Sesi/session
      header("Location: index.php"); // Mengarahkan ke halaman profil
  	} else {
      $error = 1;
  	}
  }
?>
