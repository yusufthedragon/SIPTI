<?php
  $host       =   "localhost";
  $user       =   "root";
  $password   =   "22102012nyan";
  $database   =   "adi_parts";

  try {
    $koneksi = new PDO('mysql:host='.$host.';dbname='.$database.';charset=utf8mb4', $user, $password); //membuat koneksi dengan PDO
    $koneksi->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); //Disable 'emulated' prepared statements and use 'real' prepared statement
    $koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //set error mode
  } catch (Exception $e) {
    print "Koneksi atau Query bermasalah: ".$e->getMessage()."<br/>"; //tampilkan pesan kesalahan kalau koneksi gagal
    die();
  }
  
?>
