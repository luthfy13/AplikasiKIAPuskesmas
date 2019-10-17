<?php
  $conn = new mysqli("localhost", "root", "root", "db_kia");
  
  if ($conn->connect_error){
    die("Koneksi Gagal: " . $conn->connect_error);
  }
?>