<?php
session_start();
include('config.php');

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$user = $_SESSION['user'];
$vehicles = readJSON(VEHICLES_FILE);
$vehicleId = $_GET['id'];
$vehicle = null;

foreach ($vehicles as $v) {
    if ($v['id'] == $vehicleId) {
        $vehicle = $v;
        break;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $startDate = $_POST['start_date'];
    $endDate = $_POST['end_date'];

    $diffTime = strtotime($endDate) - strtotime($startDate);
    $totalDays = ceil($diffTime / (60 * 60 * 24));
    $totalPrice = $vehicle['price_per_day'] * $totalDays;

    // Ubah status kendaraan menjadi tidak tersedia
    foreach ($vehicles as &$v) {
        if ($v['id'] == $vehicleId) {
            $v['available'] = false;
        }
    }

    writeJSON(VEHICLES_FILE, $vehicles);

    echo "<h2>Pemesanan Berhasil</h2>";
    echo "<p>Kendaraan: " . $vehicle['name'] . "</p>";
    echo "<p>Harga Total: Rp " . number_format($totalPrice, 0, ',', '.') . "</p>";
    echo "<p>Tanggal Sewa: " . $startDate . " hingga " . $endDate . "</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemesanan Kendaraan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="mt-5 text-center">Form Pemesanan Kendaraan</h1>

        <!-- Tampilkan gambar kendaraan yang dipilih -->
        <h3><?php echo $vehicle['name']; ?> (<?php echo $vehicle['type']; ?>)</h3>
        <img src="<?php echo $vehicle['image']; ?>" alt="<?php echo $vehicle['name']; ?>" class="img-fluid" style="max-height: 300px; object-fit: cover;">

        <form method="POST" class="mt-4">
            <div class="mb-3">
                <label for="start_date" class="form-label">Tanggal Mulai Sewa</label>
                <input type="date" name="start_date" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="end_date" class="form-label">Tanggal Akhir Sewa</label>
                <input type="date" name="end_date" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success w-100">Pesan Kendaraan</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
