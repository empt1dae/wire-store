<?php require_once __DIR__ . '/includes/header.php'; ?>
<?php
$search = trim($_GET['q'] ?? '');
$category = $_GET['category'] ?? '';
$sort = $_GET['sort'] ?? '';
$products = fetch_products($search ?: null, $category ?: null, $sort ?: null);
?>

<section class="section">
  <form class="controls" method="get">
    <input type="text" name="q" placeholder="Search products" value="<?php echo e($search); ?>">
    <select name="sort">
      <option value="">Sort by</option>
      <option value="popular" <?php echo $sort==='popular'?'selected':''; ?>>Popularity</option>
      <option value="price_asc" <?php echo $sort==='price_asc'?'selected':''; ?>>Price: Low to High</option>
      <option value="price_desc" <?php echo $sort==='price_desc'?'selected':''; ?>>Price: High to Low</option>
    </select>
    <button class="btn" type="submit">Apply</button>
  </form>

  <div class="filters">
    <?php $cats = ['all'=>'All','keyboards'=>'Keyboards','mice'=>'Mice','headphones'=>'Headphones','accessories'=>'Accessories'];
    foreach ($cats as $key=>$label): $active = ($key===$category) || ($key==='all' && !$category); $href = $key==='all' ? base_url('catalog.php') : base_url('catalog.php?category='.$key); ?>
      <a class="chip <?php echo $active?'active':''; ?>" href="<?php echo e($href); ?>"><?php echo e($label); ?></a>
    <?php endforeach; ?>
  </div>

  <div class="grid" style="margin-top:12px;">
    <?php if (!$products): ?>
      <p>No products found.</p>
    <?php endif; ?>
    <?php foreach ($products as $p): ?>
      <div class="card">
        <a href="<?php echo e(base_url('product.php?id='.(int)$p['id'])); ?>" class="card-img">
          <img src="<?php echo e($p['image']); ?>" alt="<?php echo e($p['name']); ?>" onerror="this.parentElement.textContent='Image'; this.remove();">
        </a>
        <div class="card-body">
          <div style="font-weight:600;"><?php echo e($p['name']); ?></div>
          <div class="price">$<?php echo number_format((float)$p['price'], 2); ?></div>
          <div style="display:flex; gap:8px;">
            <a class="btn" href="<?php echo e(base_url('product.php?id='.(int)$p['id'])); ?>">Details</a>
            <button class="btn btn-primary" onclick="import('<?php echo e(base_url('assets/js/main.js')); ?>').then(m=>m.addToCart(<?php echo (int)$p['id']; ?>))">Add to Cart</button>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>


