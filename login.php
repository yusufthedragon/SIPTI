<?php
  session_start();
  if(isset($_SESSION['login'])){
    header("location: index.php");
  }

  if (isset($_GET['error'])) {
    $error = $_GET['error'];
  } else $error = '';

  $pesan = '';

  if ($error != 1) {
    $pesan = '';
  }else {
    $pesan = "Password Salah!";
  }
?>

<!DOCTYPE html>
<html>
<head>
  <link rel="shortcut icon" href="images/logo.png" />
  <title>Login</title>
  <link href='http://fonts.googleapis.com/css?family=Roboto:400' rel='stylesheet' type='text/css'>
  <style>
      h1, input::-webkit-input-placeholder, button {
        font-family: 'roboto', sans-serif;
        -webkit-transition: all 0.3s ease-in-out;
        transition: all 0.3s ease-in-out;
        background-color: white;
      }

      h1 {
        height: 100px;
        width: 100%;
        font-size: 18px;
        background: #18aa8d;
        color: white;
        line-height: 150%;
        border-radius: 3px 3px 0 0;
        box-shadow: 0 2px 5px 1px rgba(0, 0, 0, 0.2);
      }

      form {
        box-sizing: border-box;
        width: 260px;
        margin: 100px auto 0;
        box-shadow: 2px 2px 5px 1px rgba(0, 0, 0, 0.2);
        padding-bottom: 40px;
        border-radius: 3px;
        background-color: white;
      }

      form h1 {
        box-sizing: border-box;
        padding: 20px;
      }

      input {
        margin: 40px 25px;
        width: 200px;
        display: block;
        border: none;
        padding: 10px 0;
        border-bottom: solid 1px #1abc9c;
        -webkit-transition: all 0.3s cubic-bezier(0.64, 0.09, 0.08, 1);
        transition: all 0.3s cubic-bezier(0.64, 0.09, 0.08, 1);
        background: -webkit-linear-gradient(top, rgba(255, 255, 255, 0) 96%, #1abc9c 4%);
        background: linear-gradient(to bottom, rgba(255, 255, 255, 0) 96%, #1abc9c 4%);
        background-position: -200px 0;
        background-size: 200px 100%;
        background-repeat: no-repeat;
        color: #0e6252;
      }

      input:focus, input:valid {
        box-shadow: none;
        outline: none;
        background-position: 0 0;
      }

      input:focus::-webkit-input-placeholder, input:valid::-webkit-input-placeholder {
        color: #1abc9c;
        font-size: 11px;
        -webkit-transform: translateY(-20px);
        transform: translateY(-20px);
        visibility: visible !important;
      }

      button {
        border: none;
        background: #1abc9c;
        cursor: pointer;
        border-radius: 3px;
        padding: 6px;
        width: 200px;
        color: white;
        margin-left: 25px;
        box-shadow: 0 3px 6px 0 rgba(0, 0, 0, 0.2);
      }

      button:hover {
        -webkit-transform: translateY(-3px);
        -ms-transform: translateY(-3px);
        transform: translateY(-3px);
        box-shadow: 0 6px 6px 0 rgba(0, 0, 0, 0.2);
      }

      body {
        background-image: url("images/a.jpg");
        background-position: -300px -16px;
      }
  </style>
</head>
<body>
  <form method="post" action="proses_login.php">
    <center><h1>LOGIN ADMIN</h1></center>
    <input placeholder="admin" type="password" name="password" required="">
    <button type="submit" name="login">Login</button>
    <?php echo "<br /><br /><center>".$pesan."</center>"; ?>
  </form>
</body>
</html>
