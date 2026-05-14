<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['tambah'])) {
    $kode_buku  = $_POST['kode_buku'];
    $judul_buku = $_POST['judul_buku'];
    $pengarang  = $_POST['pengarang'];
    $kategori   = $_POST['kategori'];
    $stok       = $_POST['stok'];


    $query = mysqli_query($koneksi, "INSERT INTO buku 
(kode_buku, judul_buku, pengarang, kategori, stok) VALUES 
('$kode_buku', '$judul_buku', '$pengarang', '$kategori', '$stok')
");
    if($query){
    header("Location: koleksiBuku.php");
    } else {
        echo "Data gagal ditambahkan";
    }
}

if (isset($_GET['hapus'])) {

    $id = $_GET['hapus'];

    $query = mysqli_query($koneksi,
    "DELETE FROM buku WHERE id_buku='$id'");

    if ($query) {

        echo "<script>
                alert('Buku berhasil dihapus!');
                window.location.href='koleksiBuku.php';
              </script>";

        exit();

    } else {

        echo "<script>
                alert('Gagal menghapus buku!');
                window.location.href='koleksiBuku.php';
              </script>";

        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koleksi Buku</title>
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

<div class="container mt-4">
    <?php if (isset($_SESSION['sukses'])): ?>
        <div class="alert alert-success"><?= $_SESSION['sukses']; unset($_SESSION['sukses']); ?></div>
    <?php endif; ?>

     <h3 class="judulKoleksi">Koleksi Buku</h3>
    <div class="mb-4 text-end">
    <button class="btn btn-secondary" 
            data-bs-toggle="modal" 
            data-bs-target="#modalTambah">
        <i class="bi bi-plus-lg"></i> Tambah Koleksi
    </button>
</div>

    <table class="table table-hover">
        <thead class="table-primary text-center">
            <tr>
                <th>ID</th>
                <th>Kode Buku</th>
                <th>Judul Buku</th>
                <th>Pengarang</th>
                <th>Kategori</th>
                <th>Stok</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = mysqli_query($koneksi, "SELECT * FROM buku ORDER BY id_buku ASC");
            while($row = mysqli_fetch_assoc($query)) {
            ?>
            <tr>
                <td class="text-center"><?php echo $row['id_buku']; ?></td>
                <td><?php echo $row['kode_buku']; ?></td>
                <td><?php echo $row['judul_buku']; ?></td>
                <td><?php echo $row['pengarang']; ?></td>
                <td><?php echo $row['kategori']; ?></td>
                <td class="text-center"><?php echo $row['stok']; ?></td>
                <td class="text-center">
                    <?php 
                    if($row['stok'] == 0) {
                        echo "Habis";
                    } else if($row['stok'] <= 5) {
                        echo "Menipis";
                    } else {
                        echo "Tersedia";
                    }
                    ?>
                </td>
                <td class="text-center">
                    <a href="editBuku.php?id=<?php echo $row['id_buku']; ?>" class="btn btn-success">Edit</a>
                    <button class="btn btn-warning btn-sm aksiBtn" 
onclick="if(confirm('Yakin hapus <?php echo $row['judul_buku']; ?> ?')) 
{ 
window.location.href='koleksiBuku.php?hapus=<?php echo $row['id_buku']; ?>'; 
}">
    Hapus
</button>
                </td>
            </tr>
            <?php 
            } 
            ?>
        </tbody>
    </table>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title tambahkoleksi">Tambah Koleksi Buku</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST">
                <input type="hidden" name="tambah" value="1">
                <div class="modal-body">
                    <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Kode Buku</label>
                        <input type="text" name="kode_buku" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label> Jumlah Stok</label>
                        <input type="number" name="stok" class="form-control" min="0" value="1" required>
                    </div>
                    <div class="mb-3">
                        <label>Judul Buku</label>
                        <input type="text" name="judul_buku" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Pengarang</label>
                        <input type="text" name="pengarang" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select name="kategori" class="form-select" required>
                            <option value="Fiksi" selected>Fiksi</option>
                            <option value="Non-Fiksi">Sejarah</option>
                            <option value="Teknologi">Sains</option>
                            <option value="Sains">Teknologi</option>
                        </select>
                    </div>
                </div>
                </div>
                <div class="modal-footer">
                    <a href="koleksiBuku.php" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>