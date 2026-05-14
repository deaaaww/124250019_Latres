<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id_buku    = $_POST['id_buku'];
    $kode_buku  = $_POST['kode_buku'];
    $judul_buku = $_POST['judul_buku'];
    $pengarang  = $_POST['pengarang'];
    $kategori   = $_POST['kategori'];
    $stok       = $_POST['stok'];

    $update = mysqli_query($koneksi, "UPDATE buku SET

        kode_buku='$kode_buku',
        judul_buku='$judul_buku',
        pengarang='$pengarang',
        kategori='$kategori',
        stok='$stok'

        WHERE id_buku='$id_buku'
    ");

    if($update){
        header("Location: koleksiBuku.php");
        exit();
    }else{
        echo "Gagal update data";
    }
}

$id = isset($_GET['id']) ? $_GET['id'] : $_POST['id_buku'];

$query = mysqli_query($koneksi, "SELECT * FROM buku WHERE id_buku='$id'");
$buku = mysqli_fetch_assoc($query);

?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Buku - Pustaka Digital</title>
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
        <h3 class="judulEdit">Form Edit Buku</h3>
    </div>

    <form method="POST">
        <input type="hidden" name="id_buku" value="<?php echo $buku['id_buku']; ?>">
            <div class="row">
                <div class="mb-3">
                    <label class="form-label">ID Buku</label>
                    <input type="text" class="form-control" value="<?php echo $buku['id_buku']; ?>" readonly>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kode Buku</label>
                    <input type="text" name="kode_buku" class="form-control" 
                        value="<?php echo $buku['kode_buku']; ?>" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Stok</label>
                    <input type="number" name="stok" class="form-control" 
                        value="<?php echo $buku['stok']; ?>" min="0" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Judul Buku</label>
                    <input type="text" name="judul_buku" class="form-control" 
                        value="<?php echo $buku['judul_buku']; ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Pengarang</label>
                    <input type="text" name="pengarang" class="form-control" 
                        value="<?php echo $buku['pengarang']; ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Kategori</label>
                    <select name="kategori" class="form-select" required>
                        <option value="Fiksi" <?php echo ($buku['kategori']=='Fiksi')?'selected':''; ?>>Fiksi</option>
                        <option value="Non-Fiksi" <?php echo ($buku['kategori']=='Non-Fiksi')?'selected':''; ?>>Non-Fiksi</option>
                        <option value="Sejarah" <?php echo ($buku['kategori']=='Sejarah')?'selected':''; ?>>Sejarah</option>
                        <option value="Teknologi" <?php echo ($buku['kategori']=='Teknologi')?'selected':''; ?>>Teknologi</option>
                        <option value="Sains" <?php echo ($buku['kategori']=='Sains')?'selected':''; ?>>Sains</option>
                    </select>
                </div>

                
                        
                        <div class="formButton">
                            <a href="koleksiBuku.php" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>