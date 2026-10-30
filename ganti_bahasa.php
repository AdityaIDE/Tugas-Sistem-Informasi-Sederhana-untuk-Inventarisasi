<?php
require_once 'includes/auth.php';
$lang = $_GET['lang'] ?? 'id';
if ($lang === 'id' || $lang === 'en') {
    $_SESSION['lang'] = $lang;         
}
$kembali = basename($_GET['kembali'] ?? 'index.php');
$boleh = ['index.php', 'login.php', 'tambah.php', 'ubah.php'];
if (!in_array($kembali, $boleh, true)) $kembali = 'index.php';
$qs = ($kembali === 'ubah.php' && isset($_GET['id'])) ? '?id=' . (int)$_GET['id'] : '';
header('Location: ' . $kembali . $qs);
exit;
