<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="ubah.css">
</head>

<body>

<section class="login">

    <h1 class="log">Pustaka Digital</h1>
    <p class="sistem">Sistem Perpustakaan Nasional</p>

    <?php if(isset($_SESSION['login_error'])): ?>
        <div class="alert alert-danger">
            <?= $_SESSION['login_error']; ?>
        </div>
    <?php unset($_SESSION['login_error']); endif; ?>

    <form method="POST" action="otwLogin.php">

        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username">
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>

        <button type="submit" class="btn btn-primary submit">
            Masuk
        </button>

    </form>

</section>

</body>
</html>