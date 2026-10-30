<?php
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'db_inventaris';

mysqli_report(MYSQLI_REPORT_OFF);
$koneksi = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($koneksi->connect_error) {
    die('Koneksi database gagal / Database connection failed: ' . htmlspecialchars($koneksi->connect_error));
}
$koneksi->set_charset('utf8mb4');
