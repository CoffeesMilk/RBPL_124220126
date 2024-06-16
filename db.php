<?php
session_start();
include 'connect.php';

$username = $_POST['username'];
$password = $_POST['password'];

$query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
$result = mysqli_query($koneksi, $query);

if (mysqli_num_rows($result) == 1) {
  $row = mysqli_fetch_assoc($result);
  $_SESSION['username'] = $row['username'];
  $_SESSION['roles'] = $row['roles'];
  
  if ($_SESSION['roles'] == 'Manajer') {
      header('Location: index.php?cari=');
      exit();
  } elseif ($_SESSION['roles'] == 'Staff Gudang') {
      header('Location: index.php?cari=');
      exit();
  } elseif ($_SESSION['roles'] == 'Kasir') {
      header('Location: pemesanan.php?cari=');
      exit();
  } else {
      header('Location: login_form.php');
      exit();
  }

  
} else {
  header('Location: login_form.php?pesan=gagal');
}
?>