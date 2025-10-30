<?php require_once __DIR__ . '/includes/header.php'; ?>
<?php $id = (int)($_GET['id'] ?? 0); $p = $id ? fetch_product($id) : null; if (!$p) { echo '<p>Product not found.</p>'; require_once __DIR__.'/includes/footer.php'; exit; } ?>

<section class="section" style="display:grid; grid-template-columns: 1fr 1fr; gap: 24px;">
  <div class="card">
    <div class="card-img" style="aspect-ratio:1/1;">
      <img src="<?php echo e($p['image']); ?>" alt="<?php echo e($p['name']); ?>" onerror="this.parentElement.textContent='Image'; this.remove();">
    </div>
  </div>
  <div class="card" style="padding: 16px;">
    <h2 class="section-title" style="margin:0 0 8px;"><?php echo e($p['name']); ?></h2>
    <div class="price" style="font-size:22px; margin-bottom: 12px;">$<?php echo number_format((float)$p['price'], 2); ?></div>
    <p style="color:var(--muted); margin-top:0;"><?php echo nl2br(e($p['description'] ?? '')); ?></p>
    <?php if (!empty($p['specs'])): ?>
      <div style="margin:12px 0;">
        <strong>Specifications</strong>
        <div style="color:var(--muted); white-space:pre-line;"><?php echo e($p['specs']); ?></div>
      </div>
    <?php endif; ?>
    <div style="display:flex; gap:8px; align-items:center; margin-top: 12px;">
      <input type="number" id="qty" value="1" min="1" style="width:90px;">
      <button class="btn btn-primary" onclick="import('<?php echo e(base_url('assets/js/main.js')); ?>').then(m=>m.addToCart(<?php echo (int)$p['id']; ?>, Number(document.getElementById('qty').value)||1))"><i class="fa-solid fa-cart-plus"></i> Add to Cart</button>
    </div>
  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>


