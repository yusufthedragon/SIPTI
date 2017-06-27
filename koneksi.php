<?php
  $host       =   "localhost";
  $user       =   "root";
  $password   =   "";
  $database   =   "zati_parts";

  try {
    $koneksi = new PDO('mysql:host='.$host.';dbname='.$database.';charset=utf8mb4', $user, $password); //Membuat koneksi dengan PDO
    $koneksi->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); //Disable 'emulated' prepared statements and use 'real' prepared statement
    $koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //Set error mode
  } catch (Exception $e) {
    print "Koneksi atau Query bermasalah: ".$e->getMessage()."<br/>"; //Tampilkan pesan kesalahan kalau koneksi gagal
    die();
  }

?>
