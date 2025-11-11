<?php require_once __DIR__ . '/includes/header.php'; ?>
<?php $id = (int)($_GET['id'] ?? 0); $p = $id ? fetch_product($id) : null; if (!$p) { echo '<p>Product not found.</p>'; require_once __DIR__.'/includes/footer.php'; exit; } ?>
<?php
$imgsRaw = trim((string)($p['image'] ?? ''));
$parts = preg_split('/[\n,]+/', $imgsRaw);
$images = [];
foreach ($parts as $part) {
  $s = trim($part);
  if ($s !== '') $images[] = $s;
}
// final check, if only blank/empty images, treat as empty
$images = array_filter($images, function($img){ return !!$img; });
?>
<section class="section" style="display:grid; grid-template-columns: 1fr 1fr; gap: 24px;">
  <div class="card" style="padding:12px;">
    <div class="card-img" style="aspect-ratio:1/1; position:relative; overflow:hidden; border-radius:12px; background:#f3f4f6; display:flex; align-items:center; justify-content:center; ">
      <?php if (!$images): ?>
        <div style="color:#64748b;font-size:1.13rem;text-align:center;width:100%;">No Image Available</div>
      <?php else: ?>
        <img id="mainImg" src="<?php echo e(preg_match('~^https?://~i',$images[0])?$images[0]:base_url($images[0])); ?>" alt="<?php echo e($p['name']); ?>" style="width:100%; height:100%; object-fit:cover;" onerror="this.parentElement.textContent='Image'; this.remove();">
        <?php if (count($images) > 1): ?>
        <button class="btn" type="button" id="prevBtn" style="position:absolute; left:8px; top:50%; transform:translateY(-50%);">‹</button>
        <button class="btn" type="button" id="nextBtn" style="position:absolute; right:8px; top:50%; transform:translateY(-50%);">›</button>
        <?php endif; ?>
      <?php endif; ?>
    </div>
    <?php if (count($images) > 1): ?>
    <div style="display:flex; gap:8px; margin-top:10px; overflow:auto;">
      <?php foreach ($images as $idx => $im): ?>
        <img data-idx="<?php echo (int)$idx; ?>" src="<?php echo e(preg_match('~^https?://~i',$im)?$im:base_url($im)); ?>" alt="thumb" style="width:70px; height:70px; object-fit:cover; border-radius:8px; border:2px solid #e5e7eb; cursor:pointer;" onclick="setImg(<?php echo (int)$idx; ?>)">
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
  </div>
  <div class="card" style="padding: 16px;">
    <h2 class="section-title" style="margin:0 0 8px;"><?php echo e($p['name']); ?></h2>
    <div class="price" style="font-size:22px; margin-bottom: 12px;">$<?php echo number_format((float)$p['price'], 2); ?></div>
    <p style="color:var(--muted); margin-top:0; "><?php echo nl2br(e($p['description'] ?? '')); ?></p>
    <?php if (!empty($p['specs'])): ?>
      <div style="margin:12px 0;">
        <strong>Specifications</strong>
        <div style="color:var(--muted); white-space:pre-line; "><?php echo e($p['specs']); ?></div>
      </div>
    <?php endif; ?>
    <div style="display:flex; gap:8px; align-items:center; margin-top: 12px;">
      <input type="number" id="qty" value="1" min="1" style="width:90px;">
      <button class="btn btn-primary" onclick="import('<?php echo e(base_url('assets/js/main.js')); ?>').then(m=>m.addToCart(<?php echo (int)$p['id']; ?>, Number(document.getElementById('qty').value)||1))"><i class="fa-solid fa-cart-plus"></i> Add to Cart</button>
    </div>
  </div>
</section>
<script>
(function(){
  const images = <?php echo json_encode(array_values(array_map(function($x){ return preg_match('~^https?://~i',$x)?$x:base_url($x); }, $images))); ?>;
  let idx = 0;
  const main = document.getElementById('mainImg');
  const prev = document.getElementById('prevBtn');
  const next = document.getElementById('nextBtn');
  window.setImg = (i)=>{ idx = i; if(main) main.src = images[idx]; };
  if (prev) prev.addEventListener('click', ()=>{ idx = (idx - 1 + images.length) % images.length; main.src = images[idx]; });
  if (next) next.addEventListener('click', ()=>{ idx = (idx + 1) % images.length; main.src = images[idx]; });
})();
</script>
<?php require_once __DIR__ . '/includes/footer.php'; ?>


