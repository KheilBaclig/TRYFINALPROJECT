<?php $page_title = 'Staff Dashboard'; ?>

<div class="page-header">
  <div class="page-header-left">
    <div class="page-title">Inventory Overview</div>
    <div class="page-sub"><?= date('l, F j, Y') ?> · Staff View</div>
  </div>
</div>

<!-- Read-only info banner -->
<div class="info-banner">
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
  You have <strong>read-only</strong> access. Contact your manager to make changes or record transactions.
</div>

<!-- KPI Cards -->
<div class="stats-grid" style="margin-bottom:24px">
  <div class="stat-card">
    <div class="stat-icon blue">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M20.38 3.46L16 2a4 4 0 0 1-8 0L3.62 3.46a2 2 0 0 0-1.34 2.23l.58 3.57a1 1 0 0 0 .99.84H5v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V10h1.15a1 1 0 0 0 .99-.84l.58-3.57a2 2 0 0 0-1.34-2.23z"/></svg>
    </div>
    <div class="stat-info">
      <div class="label">Total Products</div>
      <div class="value"><?= number_format($totalProducts) ?></div>
      <div class="sub">Active listings</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon green">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
    </div>
    <div class="stat-info">
      <div class="label">Units in Stock</div>
      <div class="value"><?= number_format($totalStock) ?></div>
      <div class="sub">Across all variants</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon teal">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
    </div>
    <div class="stat-info">
      <div class="label">Categories</div>
      <div class="value"><?= number_format($totalCategories) ?></div>
      <div class="sub">Product categories</div>
    </div>
  </div>
</div>

<!-- Doughnut Chart + Low Stock -->
<div style="display:grid;grid-template-columns:1fr minmax(0,310px);gap:16px;margin-bottom:16px">
  <div class="card" style="min-width:0">
    <div class="card-header"><span class="card-title">Stock by Category</span></div>
    <div class="card-body"><canvas id="categoryChart" height="110"></canvas></div>
  </div>
  <div class="card" style="min-width:0">
    <div class="card-header">
      <span class="card-title" style="display:flex;align-items:center;gap:6px">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" width="14" height="14" style="color:#FF9500;stroke-width:2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
        Low Stock Items
      </span>
    </div>
    <div class="card-body" style="padding-top:10px">
      <?php if (empty($lowStock)): ?>
        <div class="empty-state" style="padding:20px 0">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" style="width:32px;height:32px;color:#34C759;stroke-width:1.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
          <p style="margin-top:8px;color:var(--text-2)">All stock levels healthy</p>
        </div>
      <?php else: ?>
        <?php foreach ($lowStock as $ls): ?>
          <div style="display:flex;justify-content:space-between;align-items:center;padding:9px 0;border-bottom:1px solid var(--border)">
            <div style="min-width:0;margin-right:8px">
              <div style="font-size:.82rem;font-weight:500;white-space:nowrap;overflow:hidden;text-overflow:ellipsis"><?= esc($ls['product_name']) ?></div>
              <div style="font-size:.7rem;color:var(--text-2)"><?= esc($ls['size']) ?> / <?= esc($ls['color']) ?></div>
            </div>
            <span class="badge badge-low" style="flex-shrink:0"><?= $ls['stock'] ?> left</span>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
</div>

<!-- Product Catalog -->
<div class="card">
  <div class="card-header">
    <span class="card-title">Product Catalog</span>
    <a href="<?= base_url('products') ?>" class="btn btn-secondary btn-sm">Browse All</a>
  </div>
  <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(230px,1fr));gap:1px;background:var(--border);border-radius:0 0 14px 14px;overflow:hidden">
    <?php foreach ($recentProducts as $p): ?>
      <div style="background:var(--surface);padding:16px 20px;transition:background .15s" onmouseenter="this.style.background='var(--bg)'" onmouseleave="this.style.background='var(--surface)'">
        <div style="display:flex;align-items:center;gap:12px;margin-bottom:12px">
          <div class="product-thumb" style="flex-shrink:0">
            <?php if ($p['image']): ?>
              <img src="<?= base_url('uploads/products/' . $p['image']) ?>" alt="">
            <?php else: ?>
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M20.38 3.46L16 2a4 4 0 0 1-8 0L3.62 3.46a2 2 0 0 0-1.34 2.23l.58 3.57a1 1 0 0 0 .99.84H5v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V10h1.15a1 1 0 0 0 .99-.84l.58-3.57a2 2 0 0 0-1.34-2.23z"/></svg>
            <?php endif; ?>
          </div>
          <div style="min-width:0">
            <div style="font-weight:600;font-size:.85rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis"><?= esc($p['name']) ?></div>
            <div style="font-size:.72rem;color:var(--text-2)"><?= esc($p['category_name']) ?></div>
          </div>
        </div>
        <div style="display:flex;justify-content:space-between;align-items:center">
          <span style="font-weight:700;font-size:.9rem;color:var(--text)"><?= currency($p['price']) ?></span>
          <a href="<?= base_url('products/' . $p['id']) ?>" class="btn btn-secondary btn-sm">View</a>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<script>
new Chart(document.getElementById('categoryChart').getContext('2d'), {
  type: 'doughnut',
  data: {
    labels: <?= json_encode(array_column($stockByCategory, 'name')) ?>,
    datasets: [{
      data: <?= json_encode(array_map(fn($c) => (int)$c['total_stock'], $stockByCategory)) ?>,
      backgroundColor: ['#FAFAFA','#A1A1AA','#3F3F46','#27272A','#D4D4D8','#E4E4E7'],
      borderWidth: 2,
      borderColor: '#0C0C0D',
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: true,
    plugins: {
      legend: { position: 'right', labels: { font: { size: 11, family: 'Inter' }, color: '#A1A1AA', padding: 12, boxWidth: 10 } }
    },
    cutout: '67%',
  }
});
</script>
