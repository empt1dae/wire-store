<?php require_once __DIR__ . '/../includes/header.php'; require_admin(); ?>
<?php
// Enhanced Statistics
global $mysqli;

// Basic counts
$orders = $mysqli->query('SELECT COUNT(*) c, COALESCE(SUM(total),0) revenue FROM orders')->fetch_assoc();
$products = $mysqli->query('SELECT COUNT(*) c FROM products')->fetch_assoc();
$users = $mysqli->query("SELECT COUNT(*) c FROM users WHERE role='user'")->fetch_assoc();

// Order status breakdown
$newOrders = $mysqli->query("SELECT COUNT(*) c FROM orders WHERE status='new'")->fetch_assoc();
$confirmedOrders = $mysqli->query("SELECT COUNT(*) c FROM orders WHERE status='confirmed'")->fetch_assoc();
$rejectedOrders = $mysqli->query("SELECT COUNT(*) c FROM orders WHERE status='rejected'")->fetch_assoc();
$resolvedOrders = (int)$confirmedOrders['c'] + (int)$rejectedOrders['c'];

// Today's orders
$todayOrders = $mysqli->query("SELECT COUNT(*) c FROM orders WHERE DATE(created_at) = CURDATE()")->fetch_assoc();

// Average processing time (time from order creation to now for resolved orders)
// Since we don't have updated_at, we calculate time from creation to current time
$avgProcessing = $mysqli->query("
  SELECT AVG(TIMESTAMPDIFF(HOUR, created_at, NOW())) as avg_hours
  FROM orders 
  WHERE status IN ('confirmed', 'rejected')
")->fetch_assoc();
$avgHours = $avgProcessing['avg_hours'] ? round((float)$avgProcessing['avg_hours'], 1) : 0;

// Pending orders (new status)
$pendingOrders = (int)$newOrders['c'];
?>

<section class="section">
  <h2 class="section-title">Admin Dashboard</h2>
  
  <div class="advantages" style="margin-bottom:24px;">
    <div class="adv-item stat-card">
      <div class="adv-icon" style="background: linear-gradient(135deg, #3b82f6, #2563eb);"><i class="fa-solid fa-shopping-cart"></i></div>
      <div class="adv-title">Total Orders</div>
      <div class="adv-text stat-number"><?php echo (int)$orders['c']; ?></div>
      <div class="stat-subtext"><?php echo (int)$todayOrders['c']; ?> today</div>
    </div>
    
    <div class="adv-item stat-card">
      <div class="adv-icon" style="background: linear-gradient(135deg, #10b981, #059669);"><i class="fa-solid fa-dollar-sign"></i></div>
      <div class="adv-title">Total Revenue</div>
      <div class="adv-text stat-number">$<?php echo number_format((float)$orders['revenue'], 2); ?></div>
      <div class="stat-subtext">All time</div>
    </div>
    
    <div class="adv-item stat-card">
      <div class="adv-icon" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed);"><i class="fa-solid fa-box"></i></div>
      <div class="adv-title">Products</div>
      <div class="adv-text stat-number"><?php echo (int)$products['c']; ?></div>
      <div class="stat-subtext">In catalog</div>
    </div>
    
    <div class="adv-item stat-card">
      <div class="adv-icon" style="background: linear-gradient(135deg, #f59e0b, #d97706);"><i class="fa-solid fa-users"></i></div>
      <div class="adv-title">Users</div>
      <div class="adv-text stat-number"><?php echo (int)$users['c']; ?></div>
      <div class="stat-subtext">Registered</div>
    </div>
  </div>

  <div class="advantages" style="margin-bottom:24px;">
    <div class="adv-item stat-card">
      <div class="adv-icon" style="background: linear-gradient(135deg, #ef4444, #dc2626);"><i class="fa-solid fa-clock"></i></div>
      <div class="adv-title">Pending Orders</div>
      <div class="adv-text stat-number"><?php echo $pendingOrders; ?></div>
      <div class="stat-subtext">Awaiting review</div>
    </div>
    
    <div class="adv-item stat-card">
      <div class="adv-icon" style="background: linear-gradient(135deg, #10b981, #059669);"><i class="fa-solid fa-check-circle"></i></div>
      <div class="adv-title">Resolved Issues</div>
      <div class="adv-text stat-number"><?php echo $resolvedOrders; ?></div>
      <div class="stat-subtext"><?php echo (int)$confirmedOrders['c']; ?> confirmed, <?php echo (int)$rejectedOrders['c']; ?> rejected</div>
    </div>
    
    <div class="adv-item stat-card">
      <div class="adv-icon" style="background: linear-gradient(135deg, #06b6d4, #0891b2);"><i class="fa-solid fa-hourglass-half"></i></div>
      <div class="adv-title">Avg Processing Time</div>
      <div class="adv-text stat-number"><?php echo $avgHours; ?>h</div>
      <div class="stat-subtext">Average hours</div>
    </div>
    
    <div class="adv-item stat-card">
      <div class="adv-icon" style="background: linear-gradient(135deg, #6366f1, #4f46e5);"><i class="fa-solid fa-chart-line"></i></div>
      <div class="adv-title">Resolution Rate</div>
      <div class="adv-text stat-number"><?php echo $orders['c'] > 0 ? round(($resolvedOrders / (int)$orders['c']) * 100, 1) : 0; ?>%</div>
      <div class="stat-subtext">Orders processed</div>
    </div>
  </div>
  
  <div style="display:flex; gap:8px; flex-wrap:wrap;">
    <a class="btn" href="products.php">Manage Products</a>
    <a class="btn" href="orders.php">Manage Orders</a>
  </div>
</section>

<style>
.stat-card {
  position: relative;
  padding: 20px;
  min-height: 140px;
}
.stat-number {
  font-size: 28px;
  font-weight: 700;
  color: var(--text);
  margin: 8px 0 4px;
  line-height: 1.2;
}
.stat-subtext {
  font-size: 12px;
  color: var(--muted);
  margin-top: 4px;
}
.adv-icon {
  width: 48px;
  height: 48px;
  font-size: 20px;
  color: #fff;
  margin-bottom: 8px;
}
</style>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>


