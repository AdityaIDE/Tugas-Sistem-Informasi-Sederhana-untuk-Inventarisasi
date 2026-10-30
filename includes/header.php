<!DOCTYPE html>
<html lang="<?= e($_SESSION['lang']) ?>">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($judul_halaman ?? '') ?> - <?= t('app_title') ?></title>
<link rel="stylesheet" href="assets/style.css">
</head>
<body>
<header class="topbar">
  <div class="brand"><?= t('app_title') ?></div>
  <nav>
    <?php $kembali = urlencode(basename($_SERVER['PHP_SELF'])); $idq = isset($id) && $id ? '&amp;id=' . (int)$id : ''; ?>
    <span class="lang"><?= t('bahasa') ?>:
      <a href="ganti_bahasa.php?lang=id&amp;kembali=<?= $kembali . $idq ?>" class="<?= $_SESSION['lang']==='id'?'on':'' ?>">ID</a> |
      <a href="ganti_bahasa.php?lang=en&amp;kembali=<?= $kembali . $idq ?>" class="<?= $_SESSION['lang']==='en'?'on':'' ?>">EN</a>
    </span>
    <?php if (!empty($_SESSION['user_id'])): ?>
      <span class="user"><?= t('welcome') ?>, <strong><?= e($_SESSION['nama']) ?></strong></span>
      <a class="btn btn-sm btn-outline" href="logout.php"><?= t('logout') ?></a>
    <?php endif; ?>
  </nav>
</header>
<main class="container">
