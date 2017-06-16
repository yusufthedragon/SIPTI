<?php
  include 'koneksi.php';

  session_start();

  $error = "";

  if (isset($_POST['login'])) {
      $password = htmlspecialchars($_POST['password']);
    	// SQL query untuk memeriksa apakah karyawan terdapat di database?
    	$query = $koneksi->prepare("SELECT * FROM user");
      $query->bindParam(':password', $password);
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
