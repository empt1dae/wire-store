<?php require_once __DIR__ . '/includes/header.php'; ?>
<?php
$errors = [];
if (is_post()) {
  $email = trim($_POST['email'] ?? '');
  $password = $_POST['password'] ?? '';
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required';
  if ($password === '') $errors[] = 'Password is required';
  if (!$errors) {
    global $mysqli;
    $stmt = $mysqli->prepare('SELECT id, name, email, password_hash, role FROM users WHERE email = ?');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $u = $stmt->get_result()->fetch_assoc();
    if (!$u || !password_verify($password, $u['password_hash'])) {
      $errors[] = 'Incorrect email or password';
    } else {
      $_SESSION['user'] = ['id'=>$u['id'],'name'=>$u['name'],'email'=>$u['email'],'role'=>$u['role']];
      if (($u['role'] ?? 'user') === 'admin') {
        header('Location: admin/index.php');
      } else {
        header('Location: index.php');
      }
      exit();
    }
  }
}
?>

<section class="section auth-center">
  <h2 class="section-title">Login</h2>
  <?php if ($errors): ?><div class="card" style="padding:12px; color:#b91c1c; border:1px solid #fecaca; background:#fef2f2; border-radius:12px; margin-bottom:12px;">
      <?php foreach ($errors as $e) echo '<div>'.e($e).'</div>'; ?>
  </div><?php endif; ?>
  <form class="card form auth-card" method="post">
    <div class="field"><label>Email</label><input required type="email" name="email" value="<?php echo e($_POST['email'] ?? ''); ?>"></div>
    <div class="field"><label>Password</label><input required type="password" name="password"></div>
    <button class="btn btn-primary" type="submit">Sign In</button>
  </form>
  <div class="auth-links"><a href="register.php">Don't you have an account yet? Register?</a></div>
</section>
<style>
.auth-center { display:flex; flex-direction:column; align-items:center; min-height:60vh; justify-content:center; }
.auth-card { margin-top:18px; max-width:370px; box-shadow:0 2px 12px rgba(18,70,140,0.045); padding:25px 20px; border-radius:16px; }
.auth-links { text-align:center; margin-top:16px; }
.auth-links a { color:#2563eb; text-decoration:underline; font-size:15px; }
.auth-links a:hover { color:#1747a5; }
</style>
<?php require_once __DIR__ . '/includes/footer.php'; ?>


