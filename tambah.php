<?php
require_once 'includes/auth.php';
wajib_login();
require_once 'config/koneksi.php';

$data = ['kode_barang'=>'','nama_barang'=>'','kategori'=>'','jumlah'=>'','harga'=>'','kondisi'=>'baik'];
$err = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_valid($_POST['csrf'] ?? '')) {
        $err['_'] = 'err_csrf';
    } else {
        [$data, $err] = validasi_barang($_POST, $koneksi);
        if (!$err) {   
            $st = $koneksi->prepare('INSERT INTO barang (kode_barang,nama_barang,kategori,jumlah,harga,kondisi) VALUES (?,?,?,?,?,?)');
            $st->bind_param('sssids', $data['kode_barang'], $data['nama_barang'], $data['kategori'],
                $data['jumlah'], $data['harga'], $data['kondisi']);
            if ($st->execute()) {
                flash_set('success', 'sukses_tambah');
                header('Location: index.php'); exit;
            }
        }
    }
}
$judul_halaman = 'Tambah';
$aksi_url = 'tambah.php';
require 'includes/header.php';
?>
<div class="card">
  <h2><?= t('tambah') ?></h2>
  <?php if (isset($err['_'])): ?><div class="alert alert-error"><?= t($err['_']) ?></div><?php endif; ?>
  <?php require 'includes/form_barang.php'; ?>
</div>
<?php require 'includes/footer.php'; ?>
