<?php
session_start();
include 'koneksi.php';

$username = $_POST['username'];
$password = $_POST['password'];

if(empty($username) || empty($password)){

    $_SESSION['login_error'] = "Username dan password tidak boleh kosong!";

    header("Location: login.php");
    exit();
}

$query = "SELECT * FROM login 
WHERE username='$username' 
AND password='$password'";

$result = mysqli_query($koneksi, $query);

if(mysqli_num_rows($result) > 0){

    $user = mysqli_fetch_assoc($result);

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_name'] = $user['username'];
    $_SESSION['logged_in'] = true;

    header("Location: koleksiBuku.php");
    exit();

} else {

    $_SESSION['login_error'] = "Username atau password salah!";
    header("Location: login.php");
    exit();
}
?>