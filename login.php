<?php
require_once 'includes/auth.php';
require_once 'config/koneksi.php';

if (!empty($_SESSION['user_id'])) { header('Location: index.php'); exit; }

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = t('login_empty');
    } else {
        $st = $koneksi->prepare('SELECT id, password, nama_lengkap FROM users WHERE username = ?');
        $st->bind_param('s', $username);
        $st->execute();
        $res = $st->get_result()->fetch_assoc();
        $st->close();

        if ($res && password_verify($password, $res['password'])) {
            session_regenerate_id(true);              
            $_SESSION['user_id'] = (int)$res['id'];
            $_SESSION['nama']    = $res['nama_lengkap'];
            header('Location: index.php');
            exit;
        } else {
            $error = t('login_failed');
        }
    }
}
$judul_halaman = 'Login';
require 'includes/header.php';
?>
<div class="card login-card">
  <h2><?= t('login_title') ?></h2>
  <?php if ($error): ?><div class="alert alert-error"><?= $error ?></div><?php endif; ?>
  <form method="post" action="login.php" autocomplete="off">
    <label for="username"><?= t('username') ?></label>
    <input type="text" id="username" name="username" value="<?= e($_POST['username'] ?? '') ?>" autofocus>
    <label for="password"><?= t('password') ?></label>
    <input type="password" id="password" name="password">
    <button type="submit" class="btn btn-block"><?= t('login') ?></button>
  </form>
  <p class="hint">Demo: admin / admin123</p>
</div>
<?php require 'includes/footer.php'; ?>
