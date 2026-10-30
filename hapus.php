<?php
require_once 'includes/auth.php';
wajib_login();
require_once 'config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrf_valid($_POST['csrf'] ?? '')) {
    flash_set('error', 'err_csrf');
    header('Location: index.php'); exit;
}
$id = (int)($_POST['id'] ?? 0);
$st = $koneksi->prepare('DELETE FROM barang WHERE id = ?');
$st->bind_param('i', $id);
$st->execute();
if ($st->affected_rows > 0) flash_set('success', 'sukses_hapus');
else flash_set('error', 'err_notfound');
header('Location: index.php');
exit;
