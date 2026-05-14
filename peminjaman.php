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
}


if (isset($_GET['kembalikan'])) {
    $id_peminjaman = $_GET['kembalikan'];

    $data = mysqli_query($koneksi, "SELECT judul_buku FROM peminjaman WHERE id_peminjaman = '$id_peminjaman'");
    $row = mysqli_fetch_assoc($data);
    
    if($row) {
        $judul_buku = $row['judul_buku'];

        mysqli_query($koneksi, "UPDATE peminjaman SET status = 'Dikembalikan' WHERE id_peminjaman = '$id_peminjaman'");
        
        mysqli_query($koneksi, "UPDATE buku SET stok = stok + 1 WHERE judul_buku = '$judul_buku'");
        
        $_SESSION['sukses'] = "Buku berhasil dikembalikan!";
    }
    
    header("Location: peminjaman.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peminjaman - Pustaka Digital</title>
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
          <a class="nav-link" aria-current="page" href="koleksiBuku.php">Koleksi Buku</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="peminjaman.php">Peminjaman</a>
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

    <h3 class="judulPinjam">Database Peminjaman</h3>
    <div class="mb-4 text-end">
        <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modalPinjam">
            <a href="catatPeminjaman.php" class="btn btn-secondary file">
                <i class="bi bi-file-earmark-plus"></i> Catat Peminjaman
            </a>
        </button>
    </div>
</div>
    
<div class="tabelPinjam">
     <table class="table table-bordered table-hover">
        <thead class="table-primary text-center">
            <tr>
                <th>No</th>
                <th>Kode Pinjam</th>
                <th>Nama Peminjam</th>
                <th>Judul Buku</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = mysqli_query($koneksi, "SELECT * FROM peminjaman ORDER BY id_peminjaman DESC");
            $no = 1;
            while($row = mysqli_fetch_assoc($query)) {
                $hari_ini = date('Y-m-d');
                $status = $row['status'];
                $warna = "secondary";

                if($status == 'Dipinjam') {
                    if($row['tanggal_kembali'] < $hari_ini) {
                        $status = "Terlambat";
                        $warna = "danger";
                    } else {
                        $warna = "warning";
                    }
                } else {
                    $warna = "success";
                }
            ?>
            <tr>
                <td class="text-center"><?php echo $no++; ?></td>
                <td><?php echo $row['kode_peminjaman']; ?></td>
                <td><?php echo $row['nama_peminjam']; ?></td>
                <td><?php echo $row['judul_buku']; ?></td>
                <td><?php echo $row['tanggal_pinjam']; ?></td>
                <td><?php echo $row['tanggal_kembali']; ?></td>
                <td>
                    <?php echo $status; ?>
                </td>
                <td class="text-center">
                    <?php if($row['status'] == 'Dipinjam') { ?>
                    <a href="peminjaman.php?kembalikan=<?php echo $row['id_peminjaman']; ?>" class="btn btnKembali"> Kembalikan </a>
                        <?php } else { ?>

                            <button class="btn btn-success btnKembali" disabled>
                                Selesai
                            </button>

                        <?php } ?>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>