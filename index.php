<?php require_once __DIR__ . '/includes/header.php'; ?>

<section class="banner">
  <div class="banner-inner">
    <div>
      <h1 class="headline">Digital Universe of Wire</h1>
      <p class="subhead">Minimal gear. Maximum focus. Explore keyboards, mice, headphones, and accessories designed for clarity and performance.</p>
      <a class="btn btn-primary" href="<?php echo e(base_url('catalog.php')); ?>"><i class="fa-solid fa-compass"></i> Explore Catalog</a>
    </div>
    <div class="banner-art">WIRE</div>
  </div>
</section>

<section class="section">
  <h2 class="section-title">Featured</h2>
  <div class="grid">
    <?php foreach (fetch_products(null, null, 'popular') as $i => $p): if ($i >= 8) break; ?>
      <div class="card">
        <a href="<?php echo e(base_url('product.php?id='.(int)$p['id'])); ?>" class="card-img">
          <img src="<?php echo e($p['image']); ?>" alt="<?php echo e($p['name']); ?>" onerror="this.parentElement.textContent='Image'; this.remove();">
        </a>
        <div class="card-body">
          <div style="font-weight:600;"><?php echo e($p['name']); ?></div>
          <div class="price">$<?php echo number_format((float)$p['price'], 2); ?></div>
          <div style="display:flex; gap:8px;">
            <a class="btn" href="<?php echo e(base_url('product.php?id='.(int)$p['id'])); ?>">Details</a>
            <button class="btn btn-primary" onclick="import('assets/js/main.js').then(m=>m.addToCart(<?php echo (int)$p['id']; ?>))">Add to Cart</button>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<section class="section">
  <div class="advantages">
    <div class="adv-item">
      <div class="adv-icon"><i class="fa-solid fa-bolt"></i></div>
      <div class="adv-title">Fast Shipping</div>
      <div class="adv-text">Reliable worldwide delivery.</div>
    </div>
    <div class="adv-item">
      <div class="adv-icon"><i class="fa-solid fa-shield-halved"></i></div>
      <div class="adv-title">Secure Payments</div>
      <div class="adv-text">Encrypted and protected.</div>
    </div>
    <div class="adv-item">
      <div class="adv-icon"><i class="fa-solid fa-rotate"></i></div>
      <div class="adv-title">Easy Returns</div>
      <div class="adv-text">30-day hassle-free.</div>
    </div>
    <div class="adv-item">
      <div class="adv-icon"><i class="fa-solid fa-headset"></i></div>
      <div class="adv-title">24/7 Support</div>
      <div class="adv-text">We’re here to help.</div>
    </div>
  </div>
  
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>


