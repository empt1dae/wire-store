<?php require_once __DIR__ . '/includes/header.php'; ?>
<?php
$errors = [];
if (is_post()) {
  $name = trim($_POST['name'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $password = $_POST['password'] ?? '';
  $confirm = $_POST['confirm'] ?? '';

  if ($name === '') $errors[] = 'Name is required';
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required';
  if (strlen($password) < 6) $errors[] = 'Password must be at least 6 characters';
  if ($password !== $confirm) $errors[] = 'Passwords do not match';

  if (!$errors) {
    global $mysqli;
    $stmt = $mysqli->prepare('SELECT id FROM users WHERE email = ?');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    if ($stmt->get_result()->fetch_assoc()) {
      $errors[] = 'Email already registered';
    } else {
      $hash = password_hash($password, PASSWORD_DEFAULT);
      $role = 'user';
      $ins = $mysqli->prepare('INSERT INTO users (name, email, password_hash, role, created_at) VALUES (?,?,?,?, NOW())');
      $ins->bind_param('ssss', $name, $email, $hash, $role);
      $ins->execute();
      $_SESSION['user'] = ['id' => $ins->insert_id, 'name' => $name, 'email' => $email, 'role' => $role];
      $_SESSION['register_notify'] = ['type' => 'success', 'message' => 'Account created successfully! Welcome, ' . e($name) . '!'];
      if (($role ?? 'user') === 'admin') {
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
  <h2 class="section-title">Create Account</h2>
  <?php if ($errors): ?><div class="card" style="padding:12px; color:#b91c1c; border:1px solid #fecaca; background:#fef2f2; border-radius:12px; margin-bottom:12px;">
      <?php foreach ($errors as $e) echo '<div>'.e($e).'</div>'; ?>
  </div><?php endif; ?>
  <form class="card form auth-card" method="post">
    <div class="field"><label>Name</label><input required type="text" name="name" value="<?php echo e($_POST['name'] ?? ''); ?>"></div>
    <div class="field"><label>Email</label><input required type="email" name="email" value="<?php echo e($_POST['email'] ?? ''); ?>"></div>
    <div class="field"><label>Password</label><input required type="password" name="password"></div>
    <div class="field"><label>Confirm Password</label><input required type="password" name="confirm"></div>
    <button class="btn btn-primary" type="submit">Register</button>
  </form>
  <div class="auth-links"><a href="login.php">Do you already have an account? Log in</a></div>
</section>
<style>
.auth-center { display:flex; flex-direction:column; align-items:center; min-height:60vh; justify-content:center; }
.auth-card { margin-top:18px; max-width:420px; box-shadow:0 2px 12px rgba(18,70,140,0.045); padding:25px 20px; border-radius:16px; }
.auth-links { text-align:center; margin-top:16px; }
.auth-links a { color:#2563eb; text-decoration:underline; font-size:15px; }
.auth-links a:hover { color:#1747a5; }
</style>
<?php require_once __DIR__ . '/includes/footer.php'; ?>


