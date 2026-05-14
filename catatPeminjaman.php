<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['pinjam'])) {
    $kode_peminjaman = $_POST['kode_peminjaman'];
    $nama_peminjam   = $_POST['nama_peminjam'];
    $judul_buku      = $_POST['judul_buku'];
    $tanggal_pinjam  = $_POST['tanggal_pinjam'];
    $tanggal_kembali = $_POST['tanggal_kembali'];

    mysqli_query($koneksi, "INSERT INTO peminjaman 
        (kode_peminjaman, nama_peminjam, judul_buku, tanggal_pinjam, tanggal_kembali, status) 
        VALUES ('$kode_peminjaman', '$nama_peminjam', '$judul_buku', '$tanggal_pinjam', '$tanggal_kembali', 'Dipinjam')");

    mysqli_query($koneksi, "UPDATE buku SET stok = stok - 1 WHERE judul_buku = '$judul_buku'");
    header("Location: peminjaman.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catat Peminjaman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="ubah.css" rel="stylesheet">
</head>
<body class="koleksi">

<nav class="navbar navbar-expand-lg navbar-dark warnaNavbar">
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item pustaka">
          <a class="nav-link active" aria-current="page" href="#">Pustaka Digital</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="koleksiBuku.php">Koleksi Buku</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="peminjaman.php">Peminjaman</a>
        </li>
        
      </ul>
    
        <div class="d-flex keluar">
                <a href="logout.php" class="btn btn-light">
                    <i class="bi bi-box-arrow-right"></i> Keluar
                </a>
            </div>
    </div>
  </div>
</nav>

<div class="formEdit">
    <div class="text-center mb-4">
        <h3 class="judulEdit">Form Data Peminjaman</h3>
    </div>

    <form method="POST">
        <input type="hidden" name="id_buku" value="<?php echo $buku['id_buku']; ?>">
            <div class="row">
                <div class="mb-3">
                    <label class="form-label">Kode Peminjaman</label>
                    <input type="text" name="kode_peminjaman" class="form-control" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Nama Peminjam</label>
                    <input type="text" name="nama_peminjam" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Pilih Buku Tersedia</label>
                    <select name="judul_buku" class="form-select" required>
                    <option value="">Pilih Buku</option>
                        <?php
                        $query = mysqli_query($koneksi,
                        "SELECT * FROM buku WHERE stok > 0");
                        while($row = mysqli_fetch_assoc($query)) {
                        ?>
                    <option value="<?php echo $row['judul_buku']; ?>">
                        <?php echo $row['judul_buku']; ?>
                        (Stok: <?php echo $row['stok']; ?>)
                    </option>
                    <?php } ?>
                    </select>
                </div>

                <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal Pinjam</label>
                    <input type="date" name="tanggal_pinjam" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal Kembali</label>
                    <input type="date" name="tanggal_kembali" class="form-control" required>
                </div>
                </div>
                        <div class="formButton">
                            <a href="koleksiBuku.php" class="btn btn-secondary">Kembali</a>
                            <button type="submit" name="pinjam" class="btn btn-primary">Simpan</button>
                        </div>
                </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>