<?php $page_title = 'Manager Dashboard'; ?>

<div class="page-header">
  <div class="page-header-left">
    <div class="page-title">Store Operations</div>
    <div class="page-sub"><?= date('l, F j, Y') ?> · Manager Dashboard</div>
  </div>
  <div style="display:flex;gap:8px;flex-wrap:wrap">
    <a href="<?= base_url('products/new') ?>" class="btn btn-secondary">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      Add Product
    </a>
    <a href="<?= base_url('transactions/new') ?>" class="btn btn-primary">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/></svg>
      New Transaction
    </a>
  </div>
</div>

<!-- KPI Cards -->
<div class="stats-grid">
  <div class="stat-card">
    <div class="stat-icon blue">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M20.38 3.46L16 2a4 4 0 0 1-8 0L3.62 3.46a2 2 0 0 0-1.34 2.23l.58 3.57a1 1 0 0 0 .99.84H5v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V10h1.15a1 1 0 0 0 .99-.84l.58-3.57a2 2 0 0 0-1.34-2.23z"/></svg>
    </div>
    <div class="stat-info">
      <div class="label">Products</div>
      <div class="value"><?= number_format($totalProducts) ?></div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon green">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
    </div>
    <div class="stat-info">
      <div class="label">Total Stock</div>
      <div class="value"><?= number_format($totalStock) ?></div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon teal">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
    </div>
    <div class="stat-info">
      <div class="label">Sales</div>
      <div class="value"><?= number_format($totalSales) ?></div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon red">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.5"/></svg>
    </div>
    <div class="stat-info">
      <div class="label">Returns</div>
      <div class="value"><?= number_format($totalReturns) ?></div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon orange">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
    </div>
    <div class="stat-info">
      <div class="label">Revenue</div>
      <div class="value"><?= currency($totalRevenue, 0) ?></div>
    </div>
  </div>
</div>

<!-- Chart + Low Stock -->
<div style="display:grid;grid-template-columns:1fr minmax(0,310px);gap:16px;margin-bottom:16px">
  <div class="card" style="min-width:0">
    <div class="card-header"><span class="card-title">Sales vs Returns — Last 7 Days</span></div>
    <div class="card-body"><canvas id="salesChart" height="85"></canvas></div>
  </div>
  <div class="card" style="min-width:0">
    <div class="card-header">
      <span class="card-title" style="display:flex;align-items:center;gap:6px">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" width="14" height="14" style="color:#FF9500;stroke-width:2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
        Low Stock Alert
      </span>
      <a href="<?= base_url('products') ?>" class="btn btn-secondary btn-sm">View All</a>
    </div>
    <div class="card-body" style="padding-top:10px;max-height:260px;overflow-y:auto">
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
              <div style="font-size:.7rem;color:var(--text-2)"><?= esc($ls['sku']) ?> · <?= esc($ls['size']) ?> / <?= esc($ls['color']) ?></div>
            </div>
            <span class="badge badge-low" style="flex-shrink:0"><?= $ls['stock'] ?> left</span>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
</div>

<!-- Recent Transactions -->
<div class="card">
  <div class="card-header">
    <span class="card-title">Recent Transactions</span>
    <a href="<?= base_url('transactions') ?>" class="btn btn-secondary btn-sm">View All</a>
  </div>
  <div class="table-wrap">
    <table>
      <thead><tr><th>Ref Code</th><th>Type</th><th>By</th><th>Total</th><th>Date</th><th></th></tr></thead>
      <tbody>
        <?php if (empty($recentTx)): ?>
          <tr><td colspan="6"><div class="empty-state"><p>No transactions yet</p></div></td></tr>
        <?php else: ?>
          <?php foreach ($recentTx as $tx): ?>
            <tr>
              <td><span style="font-family:monospace;font-size:.78rem;color:var(--accent)"><?= esc($tx['ref_code']) ?></span></td>
              <td><span class="badge badge-<?= $tx['type'] ?>"><?= ucfirst($tx['type']) ?></span></td>
              <td style="font-size:.83rem"><?= esc($tx['user_name']) ?></td>
              <td style="font-weight:600"><?= currency($tx['total']) ?></td>
              <td style="color:var(--text-2);font-size:.76rem"><?= date('M d, Y · H:i', strtotime($tx['created_at'])) ?></td>
              <td><a href="<?= base_url('transactions/' . $tx['id']) ?>" class="btn btn-secondary btn-sm btn-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
              </a></td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<script>
new Chart(document.getElementById('salesChart').getContext('2d'), {
  type: 'line',
  data: {
    labels: <?= json_encode(array_column($salesData, 'date')) ?>,
    datasets: [
      {
        label: 'Sales',
        data: <?= json_encode(array_column($salesData, 'sales')) ?>,
        borderColor: '#FAFAFA',
        backgroundColor: (ctx) => {
          const gradient = ctx.chart.ctx.createLinearGradient(0, 0, 0, 200);
          gradient.addColorStop(0, 'rgba(255, 255, 255, 0.15)');
          gradient.addColorStop(1, 'rgba(255, 255, 255, 0)');
          return gradient;
        },
        borderWidth: 2, pointRadius: 4, pointBackgroundColor: '#000000', pointBorderColor: '#FAFAFA', pointBorderWidth: 2, tension: .4, fill: true,
      },
      {
        label: 'Returns',
        data: <?= json_encode(array_column($salesData, 'returns')) ?>,
        borderColor: '#F87171',
        backgroundColor: (ctx) => {
          const gradient = ctx.chart.ctx.createLinearGradient(0, 0, 0, 200);
          gradient.addColorStop(0, 'rgba(248, 113, 113, 0.15)');
          gradient.addColorStop(1, 'rgba(248, 113, 113, 0)');
          return gradient;
        },
        borderWidth: 2, pointRadius: 4, pointBackgroundColor: '#000000', pointBorderColor: '#F87171', pointBorderWidth: 2, tension: .4, fill: true,
      }
    ]
  },
  options: {
    responsive: true, maintainAspectRatio: true,
    plugins: { legend: { display: true, position: 'top', labels: { font: { size: 11, family: 'Inter' }, color: '#A1A1AA', padding: 16, boxWidth: 10 } } },
    scales: {
      x: { grid: { display: false }, ticks: { font: { size: 11, family: 'Inter' }, color: '#A1A1AA' } },
      y: { grid: { color: 'rgba(255,255,255,.06)' }, ticks: { font: { size: 11, family: 'Inter' }, color: '#A1A1AA', callback: v => '₱' + v.toLocaleString() } }
    }
  }
});
</script>
