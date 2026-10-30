<?php
$kamus = [
 'id' => [
  'app_title'=>'Sistem Inventaris Barang','login'=>'Masuk','logout'=>'Keluar','username'=>'Nama Pengguna',
  'password'=>'Kata Sandi','login_title'=>'Silakan Masuk','login_failed'=>'Nama pengguna atau kata sandi salah.',
  'login_empty'=>'Nama pengguna dan kata sandi wajib diisi.','welcome'=>'Selamat datang',
  'data_barang'=>'Data Barang','tambah'=>'Tambah Barang','ubah'=>'Ubah Barang','hapus'=>'Hapus','edit'=>'Ubah',
  'no'=>'No','kode'=>'Kode Barang','nama'=>'Nama Barang','kategori'=>'Kategori','jumlah'=>'Jumlah','harga'=>'Harga (Rp)',
  'kondisi'=>'Kondisi','lokasi'=>'Lokasi','aksi'=>'Aksi','simpan'=>'Simpan','batal'=>'Batal','cari'=>'Cari','cari_ph'=>'Cari kode / nama / kategori...',
  'baik'=>'Baik','rusak ringan'=>'Rusak Ringan','rusak berat'=>'Rusak Berat','pilih'=>'-- Pilih --',
  'konfirmasi_hapus'=>'Yakin ingin menghapus data ini?','kosong'=>'Belum ada data barang.',
  'sukses_tambah'=>'Data barang berhasil ditambahkan.','sukses_ubah'=>'Data barang berhasil diperbarui.','sukses_hapus'=>'Data barang berhasil dihapus.',
  'err_kode'=>'Kode barang wajib diisi (huruf/angka/tanda minus, maks. 20 karakter).','err_kode_dup'=>'Kode barang sudah digunakan.',
  'err_nama'=>'Nama barang wajib diisi.','err_kategori'=>'Kategori wajib dipilih.','err_jumlah'=>'Jumlah harus bilangan bulat >= 0.',
  'err_harga'=>'Harga harus berupa angka >= 0.','err_kondisi'=>'Kondisi tidak valid.','err_lokasi'=>'Lokasi wajib diisi.',
  'err_notfound'=>'Data tidak ditemukan.','err_csrf'=>'Token keamanan tidak valid. Muat ulang halaman.','bahasa'=>'Bahasa',
  'total_item'=>'Total jenis barang','total_unit'=>'Total unit','nilai_aset'=>'Nilai aset',
  'kat_elektronik'=>'Elektronik','kat_furnitur'=>'Furnitur','kat_alat_tulis'=>'Alat Tulis','kat_perkakas'=>'Perkakas','kat_lainnya'=>'Lainnya',
 ],
 'en' => [
  'app_title'=>'Inventory Management System','login'=>'Sign In','logout'=>'Sign Out','username'=>'Username',
  'password'=>'Password','login_title'=>'Please Sign In','login_failed'=>'Incorrect username or password.',
  'login_empty'=>'Username and password are required.','welcome'=>'Welcome',
  'data_barang'=>'Item Data','tambah'=>'Add Item','ubah'=>'Edit Item','hapus'=>'Delete','edit'=>'Edit',
  'no'=>'No','kode'=>'Item Code','nama'=>'Item Name','kategori'=>'Category','jumlah'=>'Quantity','harga'=>'Price (IDR)',
  'kondisi'=>'Condition','lokasi'=>'Location','aksi'=>'Actions','simpan'=>'Save','batal'=>'Cancel','cari'=>'Search','cari_ph'=>'Search code / name / category...',
  'baik'=>'Good','rusak ringan'=>'Slightly Damaged','rusak berat'=>'Heavily Damaged','pilih'=>'-- Select --',
  'konfirmasi_hapus'=>'Are you sure you want to delete this record?','kosong'=>'No items yet.',
  'sukses_tambah'=>'Item added successfully.','sukses_ubah'=>'Item updated successfully.','sukses_hapus'=>'Item deleted successfully.',
  'err_kode'=>'Item code is required (letters/digits/hyphen, max 20 chars).','err_kode_dup'=>'Item code is already in use.',
  'err_nama'=>'Item name is required.','err_kategori'=>'Please select a category.','err_jumlah'=>'Quantity must be an integer >= 0.',
  'err_harga'=>'Price must be a number >= 0.','err_kondisi'=>'Invalid condition.','err_lokasi'=>'Location is required.',
  'err_notfound'=>'Record not found.','err_csrf'=>'Invalid security token. Please reload the page.','bahasa'=>'Language',
  'total_item'=>'Total item types','total_unit'=>'Total units','nilai_aset'=>'Asset value',
  'kat_elektronik'=>'Electronics','kat_furnitur'=>'Furniture','kat_alat_tulis'=>'Stationery','kat_perkakas'=>'Tools','kat_lainnya'=>'Others',
 ],
];

if (!isset($_SESSION['lang']) || !isset($kamus[$_SESSION['lang']])) {
    $_SESSION['lang'] = 'id';
}

function t($kunci) {
    global $kamus;
    $b = $_SESSION['lang'];
    return htmlspecialchars($kamus[$b][$kunci] ?? $kunci, ENT_QUOTES, 'UTF-8');
}
