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
    <?php foreach (fetch_products(null, null, 'popular') as $i => $p): if ($i >= 4) break; ?>
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

<section class="section">
  <h2 class="section-title">Customer Reviews</h2>
  <div class="reviews-grid">
    <div class="review-card">
      <div class="review-header">
        <div class="review-avatar" style="background: linear-gradient(135deg, #3b82f6, #2563eb);">A</div>
        <div class="review-info">
          <div class="review-name">ByteVortex</div>
          <div class="review-rating">
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
          </div>
        </div>
      </div>
      <p class="review-text">"Клавиатура отличного качества! Сборка превосходная, а набор текста плавный. Быстрая доставка. Настоятельно рекомендую!"</p>
    </div>
    
    <div class="review-card">
      <div class="review-header">
        <div class="review-avatar" style="background: linear-gradient(135deg, #10b981, #059669);">M</div>
        <div class="review-info">
          <div class="review-name">Илья Трофимов</div>
          <div class="review-rating">
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
          </div>
        </div>
      </div>
      <p class="review-text">"Мышь идеально подходит для моей работы. Удобный захват и точное отслеживание. Отличное соотношение цены и качества!"</p>
    </div>
    
    <div class="review-card">
      <div class="review-header">
        <div class="review-avatar" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed);">J</div>
        <div class="review-info">
          <div class="review-name">HexaVolt</div>
          <div class="review-rating">
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
            <i class="fa-regular fa-star"></i>
          </div>
        </div>
      </div>
      <p class="review-text">"Наушники звучат потрясающе! Отличные басы и четкие высокие частоты. Единственная небольшая проблема - длина кабеля, но в целом я очень доволен."</p>
    </div>
  </div>
</section>

<style>
.reviews-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 20px;
  margin-top: 16px;
}
.review-card {
  background: #fff;
  border: 1px solid var(--border);
  border-radius: var(--radius);
  padding: 20px;
  box-shadow: var(--shadow);
  transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), 
              box-shadow 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  animation: fadeInUp 0.6s ease-out;
  animation-fill-mode: both;
}
.review-card:nth-child(1) { animation-delay: 0.1s; }
.review-card:nth-child(2) { animation-delay: 0.2s; }
.review-card:nth-child(3) { animation-delay: 0.3s; }
.review-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 12px 24px rgba(0,0,0,0.1);
}
.review-header {
  display: flex;
  align-items: center;
  gap: 12px;
  margin-bottom: 12px;
}
.review-avatar {
  width: 48px;
  height: 48px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #fff;
  font-weight: 700;
  font-size: 20px;
  flex-shrink: 0;
}
.review-info {
  flex: 1;
}
.review-name {
  font-weight: 600;
  color: var(--text);
  margin-bottom: 4px;
}
.review-rating {
  display: flex;
  gap: 2px;
  color: #fbbf24;
  font-size: 14px;
}
.review-text {
  color: var(--muted);
  line-height: 1.6;
  margin: 0;
  font-size: 15px;
}
@media (max-width: 1024px) {
  .reviews-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}
@media (max-width: 640px) {
  .reviews-grid {
    grid-template-columns: 1fr;
  }
}
</style>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
<?php
$notify = $_SESSION['login_notify'] ?? $_SESSION['register_notify'] ?? null;
if ($notify) {
  if (isset($_SESSION['login_notify'])) unset($_SESSION['login_notify']);
  if (isset($_SESSION['register_notify'])) unset($_SESSION['register_notify']);
  echo '<script type="module">import { showToast } from \'' . e(base_url('assets/js/main.js')) . '\'; showToast(\'' . e($notify['message']) . '\', \'' . e($notify['type']) . '\');</script>';
}
if (isset($_GET['logout'])) {
  echo '<script type="module">import { showToast } from \'' . e(base_url('assets/js/main.js')) . '\'; showToast(\'You have been logged out successfully.\', \'info\');</script>';
}
?>


