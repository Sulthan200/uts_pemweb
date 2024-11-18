<?php
session_start();
include('config.php');

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$user = $_SESSION['user'];
$vehicles = readJSON(VEHICLES_FILE);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sewa Kendaraan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="mt-5 text-center">Dashboard</h1>

        <div class="d-flex justify-content-between">
            <p>Selamat datang, <?php echo $user['username']; ?></p>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>

        <h2 class="mt-4">Daftar Kendaraan</h2>
        <div class="row mt-4">
            <?php foreach ($vehicles as $vehicle): ?>
                <div class="col-md-4">
                    <div class="card">
                        <!-- Tampilkan gambar kendaraan -->
                        <img src="<?php echo $vehicle['image']; ?>" class="card-img-top" alt="<?php echo $vehicle['name']; ?>" style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $vehicle['name']; ?></h5>
                            <p class="card-text">Tipe: <?php echo $vehicle['type']; ?></p>
                            <p class="card-text">Harga per hari: Rp <?php echo number_format($vehicle['price_per_day'], 0, ',', '.'); ?></p>
                            <?php if ($vehicle['available']): ?>
                                <a href="reserve.php?id=<?php echo $vehicle['id']; ?>" class="btn btn-success">Pesan</a>
                            <?php else: ?>
                                <span class="btn btn-secondary disabled">Tidak Tersedia</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
