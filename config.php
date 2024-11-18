<?php
// Konfigurasi aplikasi
define('USERS_FILE', 'users.json');
define('VEHICLES_FILE', 'vehicles.json');

// Fungsi untuk membaca file JSON
function readJSON($file) {
    return json_decode(file_get_contents($file), true);
}

// Fungsi untuk menulis ke file JSON
function writeJSON($file, $data) {
    file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
}
?>
