<?php
require_once 'includes/auth.php';
wajib_login();
require_once 'config/koneksi.php';

$id = (int)($_GET['id'] ?? 0);
$err = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['id'] ?? 0);
    if (!csrf_valid($_POST['csrf'] ?? '')) {
        $err['_'] = 'err_csrf';
        $data = $_POST + ['kode_barang'=>'','nama_barang'=>'','kategori'=>'','jumlah'=>'','harga'=>'','kondisi'=>'baik','lokasi'=>''];
    } else {
        [$data, $err] = validasi_barang($_POST, $koneksi, $id);
        if (!$err) {   )
            $st = $koneksi->prepare('UPDATE barang SET kode_barang=?, nama_barang=?, kategori=?, jumlah=?, harga=?, kondisi=?, lokasi=? WHERE id=?');
            $st->bind_param('sssidssi', $data['kode_barang'], $data['nama_barang'], $data['kategori'],
                            $data['jumlah'], $data['harga'], $data['kondisi'], $data['lokasi'], $id);
            if ($st->execute()) {
                flash_set('success', 'sukses_ubah');
                header('Location: index.php'); exit;
            }
        }
    }
} else {
    $st = $koneksi->prepare('SELECT * FROM barang WHERE id = ?');
    $st->bind_param('i', $id);
    $st->execute();
    $data = $st->get_result()->fetch_assoc();
    $st->close();
    if (!$data) { flash_set('error', 'err_notfound'); header('Location: index.php'); exit; }
}
$judul_halaman = 'Ubah';
$aksi_url = 'ubah.php?id=' . $id;
require 'includes/header.php';
?>
<div class="card">
  <h2><?= t('ubah') ?></h2>
  <?php if (isset($err['_'])): ?><div class="alert alert-error"><?= t($err['_']) ?></div><?php endif; ?>
  <?php require 'includes/form_barang.php'; ?>
</div>
<?php require 'includes/footer.php'; ?>
