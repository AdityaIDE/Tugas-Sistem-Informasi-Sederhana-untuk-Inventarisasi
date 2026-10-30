<?php
require_once 'includes/auth.php';
wajib_login();
require_once 'config/koneksi.php';

$q = trim($_GET['q'] ?? '');
if ($q !== '') {
    $like = '%' . $q . '%';
    $st = $koneksi->prepare('SELECT * FROM barang WHERE kode_barang LIKE ? OR nama_barang LIKE ? OR kategori LIKE ? ORDER BY id DESC');
    $st->bind_param('sss', $like, $like, $like);
} else {
    $st = $koneksi->prepare('SELECT * FROM barang ORDER BY id DESC');
}
$st->execute();
$hasil = $st->get_result();
$rows = $hasil->fetch_all(MYSQLI_ASSOC);
$st->close();

$total_unit = 0; $nilai = 0;
foreach ($rows as $r) { $total_unit += $r['jumlah']; $nilai += $r['jumlah'] * $r['harga']; }

$flash = flash_get();
$judul_halaman = 'Dashboard';
require 'includes/header.php';
?>
<?php if ($flash): ?><div class="alert alert-<?= e($flash[0]) ?>"><?= t($flash[1]) ?></div><?php endif; ?>

<div class="stats">
  <div class="stat"><span><?= t('total_item') ?></span><strong><?= count($rows) ?></strong></div>
  <div class="stat"><span><?= t('total_unit') ?></span><strong><?= number_format($total_unit, 0, ',', '.') ?></strong></div>
  <div class="stat"><span><?= t('nilai_aset') ?></span><strong>Rp <?= number_format($nilai, 0, ',', '.') ?></strong></div>
</div>

<div class="card">
  <div class="card-head">
    <h2><?= t('data_barang') ?></h2>
    <a class="btn" href="tambah.php">+ <?= t('tambah') ?></a>
  </div>
  <form method="get" class="search">
    <input type="text" name="q" value="<?= e($q) ?>" placeholder="<?= t('cari_ph') ?>">
    <button class="btn btn-outline" type="submit"><?= t('cari') ?></button>
  </form>

  <div class="table-wrap">
  <table>
    <thead><tr>
      <th><?= t('no') ?></th><th><?= t('kode') ?></th><th><?= t('nama') ?></th><th><?= t('kategori') ?></th>
      <th class="num"><?= t('jumlah') ?></th><th class="num"><?= t('harga') ?></th><th><?= t('kondisi') ?></th>
      </th><th><?= t('aksi') ?></th>
    </tr></thead>
    <tbody>
    <?php if (!$rows): ?>
      <tr><td colspan="8" class="empty"><?= t('kosong') ?></td></tr>
    <?php else: $no = 1; foreach ($rows as $r): ?>
      <tr>
        <td><?= $no++ ?></td>
        <td><code><?= e($r['kode_barang']) ?></code></td>
        <td><?= e($r['nama_barang']) ?></td>
        <td><?= t('kat_' . $r['kategori']) ?></td>
        <td class="num"><?= (int)$r['jumlah'] ?></td>
        <td class="num"><?= number_format($r['harga'], 0, ',', '.') ?></td>
        <td><span class="badge b-<?= str_replace(' ', '-', e($r['kondisi'])) ?>"><?= t($r['kondisi']) ?></span></td>
        <td class="aksi">
          <a class="btn btn-sm btn-outline" href="ubah.php?id=<?= (int)$r['id'] ?>"><?= t('edit') ?></a>
          <form method="post" action="hapus.php" onsubmit="return confirm('<?= addslashes(html_entity_decode(t('konfirmasi_hapus'))) ?>')">
            <input type="hidden" name="id" value="<?= (int)$r['id'] ?>">
            <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
            <button class="btn btn-sm btn-danger" type="submit"><?= t('hapus') ?></button>
          </form>
        </td>
      </tr>
    <?php endforeach; endif; ?>
    </tbody>
  </table>
  </div>
</div>
<?php require 'includes/footer.php'; ?>
