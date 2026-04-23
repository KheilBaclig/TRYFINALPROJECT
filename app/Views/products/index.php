<?php $page_title = 'Products'; ?>

<div class="page-header">
  <div class="page-header-left">
    <div class="page-title">Products</div>
    <div class="page-sub"><?= number_format($total) ?> items in inventory</div>
  </div>
  <?php if (in_array(session()->get('user_role'), ['superadmin', 'manager'])): ?>
  <a href="<?= base_url('products/new') ?>" class="btn btn-primary">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
    Add Product
  </a>
  <?php endif; ?>
</div>

<!-- Filter bar -->
<div class="card" style="margin-bottom:18px">
  <div class="card-body" style="padding:14px 18px">
    <form method="GET" style="display:flex;align-items:center;gap:10px;flex-wrap:wrap">
      <div class="search-bar">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <input type="text" name="search" placeholder="Search products…" value="<?= esc($search ?? '') ?>">
      </div>
      <select name="category" class="form-control" style="width:180px">
        <option value="">All Categories</option>
        <?php foreach ($categories as $cat): ?>
          <option value="<?= $cat['id'] ?>" <?= ($category ?? '') == $cat['id'] ? 'selected' : '' ?>><?= esc($cat['name']) ?></option>
        <?php endforeach; ?>
      </select>
      <button type="submit" class="btn btn-secondary">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
        Filter
      </button>
      <?php if ($search || $category): ?>
        <a href="<?= base_url('products') ?>" class="btn btn-secondary">Clear</a>
      <?php endif; ?>
    </form>
  </div>
</div>

<div class="card">
  <div class="table-wrap">
    <table>
      <thead>
        <tr><th>Product</th><th>SKU</th><th>Category</th><th>Price</th><th>Status</th><th>Actions</th></tr>
      </thead>
      <tbody>
        <?php if (empty($products)): ?>
          <tr><td colspan="6">
            <div class="empty-state">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M20.38 3.46L16 2a4 4 0 0 1-8 0L3.62 3.46a2 2 0 0 0-1.34 2.23l.58 3.57a1 1 0 0 0 .99.84H5v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V10h1.15a1 1 0 0 0 .99-.84l.58-3.57a2 2 0 0 0-1.34-2.23z"/></svg>
              <p>No products found</p>
            </div>
          </td></tr>
        <?php else: ?>
          <?php foreach ($products as $p): ?>
            <tr>
              <td>
                <div style="display:flex;align-items:center;gap:12px">
                  <div class="product-thumb">
                    <?php if ($p['image']): ?>
                      <img src="<?= base_url('uploads/products/' . $p['image']) ?>" alt="">
                    <?php else: ?>
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M20.38 3.46L16 2a4 4 0 0 1-8 0L3.62 3.46a2 2 0 0 0-1.34 2.23l.58 3.57a1 1 0 0 0 .99.84H5v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V10h1.15a1 1 0 0 0 .99-.84l.58-3.57a2 2 0 0 0-1.34-2.23z"/></svg>
                    <?php endif; ?>
                  </div>
                  <div>
                    <div style="font-weight:600;font-size:.85rem"><?= esc($p['name']) ?></div>
                    <div style="font-size:.72rem;color:var(--text-2)"><?= character_limiter(esc($p['description'] ?? ''), 40) ?></div>
                  </div>
                </div>
              </td>
              <td><span style="font-family:monospace;font-size:.8rem;color:var(--accent)"><?= esc($p['sku']) ?></span></td>
              <td style="color:var(--text-2);font-size:.83rem"><?= esc($p['category_name']) ?></td>
              <td style="font-weight:600"><?= currency($p['price']) ?></td>
              <td><span class="badge badge-<?= $p['is_active'] ? 'active' : 'inactive' ?>"><?= $p['is_active'] ? 'Active' : 'Inactive' ?></span></td>
              <td>
                <div style="display:flex;gap:5px">
                  <a href="<?= base_url('products/' . $p['id']) ?>" class="btn btn-secondary btn-sm btn-icon" title="View">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                  </a>
                  <a href="<?= base_url('products/' . $p['id'] . '/variants') ?>" class="btn btn-secondary btn-sm btn-icon" title="Variants">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="6" height="6"/><rect x="9" y="3" width="6" height="6"/><rect x="16" y="3" width="6" height="6"/><rect x="2" y="12" width="6" height="6"/><rect x="9" y="12" width="6" height="6"/></svg>
                  </a>
                  <?php if (in_array(session()->get('user_role'), ['superadmin', 'manager'])): ?>
                  <a href="<?= base_url('products/' . $p['id'] . '/edit') ?>" class="btn btn-secondary btn-sm btn-icon" title="Edit">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                  </a>
                  <form action="<?= base_url('products/' . $p['id'] . '/delete') ?>" method="POST" onsubmit="return confirm('Delete this product?')">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-danger btn-sm btn-icon" title="Delete">
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                    </button>
                  </form>
                  <?php endif; ?>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
  <?php if ($pager): ?>
    <div style="padding:14px 18px;border-top:1px solid var(--border)">
      <?= $pager->links('default', 'custom_pager') ?>
    </div>
  <?php endif; ?>
</div>
