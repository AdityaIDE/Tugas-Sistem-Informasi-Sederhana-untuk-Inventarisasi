<?php
/* Variabel: $data, $err, $aksi_url, $id (opsional, untuk mode ubah) */
$kat = ['elektronik','furnitur','alat_tulis','perkakas','lainnya'];
$kon = ['baik','rusak ringan','rusak berat'];
function field_err($err, $k) { return isset($err[$k]) ? '<small class="err">' . t($err[$k]) . '</small>' : ''; }
?>
<form method="post" action="<?= e($aksi_url) ?>" novalidate>
  <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
  <?php if (!empty($id)): ?><input type="hidden" name="id" value="<?= (int)$id ?>"><?php endif; ?>
  <div class="grid">
    <div><label for="kode_barang"><?= t('kode') ?></label>
      <input type="text" id="kode_barang" name="kode_barang" maxlength="20" value="<?= e($data['kode_barang']) ?>"><?= field_err($err,'kode_barang') ?></div>
    <div><label for="nama_barang"><?= t('nama') ?></label>
      <input type="text" id="nama_barang" name="nama_barang" maxlength="100" value="<?= e($data['nama_barang']) ?>"><?= field_err($err,'nama_barang') ?></div>
    <div><label for="kategori"><?= t('kategori') ?></label>
      <select id="kategori" name="kategori"><option value=""><?= t('pilih') ?></option>
      <?php foreach ($kat as $k): ?><option value="<?= $k ?>" <?= $data['kategori']===$k?'selected':'' ?>><?= t('kat_'.$k) ?></option><?php endforeach; ?>
      </select><?= field_err($err,'kategori') ?></div>
    <div><label for="jumlah"><?= t('jumlah') ?></label>
      <input type="text" id="jumlah" name="jumlah" inputmode="numeric" value="<?= e($data['jumlah']) ?>"><?= field_err($err,'jumlah') ?></div>
    <div><label for="harga"><?= t('harga') ?></label>
      <input type="text" id="harga" name="harga" inputmode="decimal" value="<?= e($data['harga']) ?>"><?= field_err($err,'harga') ?></div>
    <div><label for="kondisi"><?= t('kondisi') ?></label>
      <select id="kondisi" name="kondisi">
      <?php foreach ($kon as $k): ?><option value="<?= $k ?>" <?= $data['kondisi']===$k?'selected':'' ?>><?= t($k) ?></option><?php endforeach; ?>
      </select><?= field_err($err,'kondisi') ?></div>
    <div class="full"><label for="lokasi"><?= t('lokasi') ?></label>
      <input type="text" id="lokasi" name="lokasi" maxlength="100" value="<?= e($data['lokasi']) ?>"><?= field_err($err,'lokasi') ?></div>
  </div>
  <div class="actions">
    <button type="submit" class="btn"><?= t('simpan') ?></button>
    <a href="index.php" class="btn btn-outline"><?= t('batal') ?></a>
  </div>
</form>
