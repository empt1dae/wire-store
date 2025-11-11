<?php
require_once __DIR__ . '/functions.php';
$u = get_user();
$count = cart_count();
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Wire</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="<?php echo e(base_url('assets/css/style.css')); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo e(base_url('image/logo/logo.svg')); ?>">
    <link rel="apple-touch-icon" href="<?php echo e(base_url('image/logo/logo.svg')); ?>">
    <script type="module" src="<?php echo e(base_url('assets/js/main.js')); ?>"></script>
  </head>
  <body>
    <header class="site-header">
      <div class="container nav">
        <a href="<?php echo e(base_url('index.php')); ?>" class="brand" aria-label="Wire home">
        
          <div class="footer-logo-box">W</div>
          <div>Wire</div>
          
        </a>
        <nav class="nav-links">
          <a href="<?php echo e(base_url('catalog.php')); ?>">Catalog</a>
          <a href="<?php echo e(base_url('catalog.php?category=keyboards')); ?>">Keyboards</a>
          <a href="<?php echo e(base_url('catalog.php?category=mice')); ?>">Mice</a>
          <a href="<?php echo e(base_url('catalog.php?category=headphones')); ?>">Headphones</a>
          <a href="<?php echo e(base_url('catalog.php?category=accessories')); ?>">Accessories</a>
        </nav>
        <div class="nav-actions">
          <?php if ($u): ?>
            <a class="btn" href="<?php echo e(($u['role'] ?? 'user') === 'admin' ? base_url('admin/index.php') : base_url('account.php')); ?>">
              <i class="fa-regular fa-user"></i>
              <span><?php echo e($u['name'] ?? 'Profile'); ?></span>
            </a>
            <a class="btn" href="<?php echo e(base_url('logout.php')); ?>">Logout</a>
          <?php else: ?>
            <a class="btn" href="<?php echo e(base_url('login.php')); ?>">Login</a>
            <a class="btn" href="<?php echo e(base_url('register.php')); ?>">Register</a>
          <?php endif; ?>
          <a class="btn icon-btn" href="<?php echo e(base_url('cart.php')); ?>" aria-label="Cart">
            <i class="fa-solid fa-cart-shopping"></i>
            <span style="display:none"></span>
          </a>
          <span data-cart-count style="min-width:22px;text-align:center;"><?php echo (int)$count; ?></span>
        </div>
      </div>
    </header>
    <main class="container">


