<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/bahasa.php';

function wajib_login() {
    if (empty($_SESSION['user_id'])) {
        header('Location: login.php');
        exit;
    }
}

function e($teks) { 
    return htmlspecialchars((string)$teks, ENT_QUOTES, 'UTF-8');
}

function panjang_teks($s) {
    return function_exists('mb_strlen') ? mb_strlen($s, 'UTF-8') : preg_match_all('/./us', $s);
}

function csrf_token() {
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}
function csrf_valid($token) {
    return isset($_SESSION['csrf']) && is_string($token) && hash_equals($_SESSION['csrf'], $token);
}
function flash_set($tipe, $pesan) { $_SESSION['flash'] = [$tipe, $pesan]; }
function flash_get() { $f = $_SESSION['flash'] ?? null; unset($_SESSION['flash']); return $f; }

function validasi_barang(array $in, mysqli $db, int $id = 0) {
    $err = [];
    $data = [
        'kode_barang' => strtoupper(trim($in['kode_barang'] ?? '')),
        'nama_barang' => trim($in['nama_barang'] ?? ''),
        'kategori'    => trim($in['kategori'] ?? ''),
        'jumlah'      => trim($in['jumlah'] ?? ''),
        'harga'       => trim($in['harga'] ?? ''),
        'kondisi'     => trim($in['kondisi'] ?? ''),
        'lokasi'      => trim($in['lokasi'] ?? ''),
    ];
    $data['nama_barang'] = strip_tags($data['nama_barang']);
    $data['lokasi']      = strip_tags($data['lokasi']);

    if ($data['kode_barang'] === '' || !preg_match('/^[A-Z0-9\-]{1,20}$/', $data['kode_barang'])) {
        $err['kode_barang'] = 'err_kode';
    } else {
        $st = $db->prepare('SELECT id FROM barang WHERE kode_barang = ? AND id <> ?');
        $st->bind_param('si', $data['kode_barang'], $id);
        $st->execute(); $st->store_result();
        if ($st->num_rows > 0) $err['kode_barang'] = 'err_kode_dup';
        $st->close();
    }
    if ($data['nama_barang'] === '' || panjang_teks($data['nama_barang']) > 100) $err['nama_barang'] = 'err_nama';
    switch ($data['kategori']) {
        case 'elektronik': case 'furnitur': case 'alat_tulis': case 'perkakas': case 'lainnya':
            break;
        default:
            $err['kategori'] = 'err_kategori';
    }
    if (filter_var($data['jumlah'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]]) === false) {
        $err['jumlah'] = 'err_jumlah';
    } else { $data['jumlah'] = (int)$data['jumlah']; }

    if (filter_var($data['harga'], FILTER_VALIDATE_FLOAT) === false || (float)$data['harga'] < 0) {
        $err['harga'] = 'err_harga';
    } else { $data['harga'] = (float)$data['harga']; }

    if (!in_array($data['kondisi'], ['baik', 'rusak ringan', 'rusak berat'], true)) $err['kondisi'] = 'err_kondisi';
    if ($data['lokasi'] === '' || panjang_teks($data['lokasi']) > 100) $err['lokasi'] = 'err_lokasi';

    return [$data, $err];
}
