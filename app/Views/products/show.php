<?php $page_title = esc($product['name']); ?>

<div class="page-header">
  <div class="page-header-left">
    <div class="page-title"><?= esc($product['name']) ?></div>
    <div class="page-sub"><?= esc($product['sku']) ?> · <?= esc($product['category_name']) ?></div>
  </div>
  <div style="display:flex;gap:8px">
    <a href="<?= base_url('products/' . $product['id'] . '/variants') ?>" class="btn btn-secondary">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="6" height="6"/><rect x="9" y="3" width="6" height="6"/><rect x="16" y="3" width="6" height="6"/><rect x="2" y="12" width="6" height="6"/><rect x="9" y="12" width="6" height="6"/></svg>
      Variants
    </a>
    <?php if (in_array(session()->get('user_role'), ['superadmin', 'manager'])): ?>
    <a href="<?= base_url('products/' . $product['id'] . '/edit') ?>" class="btn btn-primary">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
      Edit
    </a>
    <?php endif; ?>
  </div>
</div>

<div style="display:grid;grid-template-columns:280px 1fr;gap:20px">
  <!-- Product Image Card -->
  <div class="card" style="align-self:start">
    <div style="aspect-ratio:1;background:var(--bg);border-radius:14px 14px 0 0;overflow:hidden;display:flex;align-items:center;justify-content:center">
      <?php if ($product['image']): ?>
        <img src="<?= base_url('uploads/products/' . $product['image']) ?>" style="width:100%;height:100%;object-fit:cover">
      <?php else: ?>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" style="width:60px;height:60px;color:var(--text-3);stroke-width:1.5"><path d="M20.38 3.46L16 2a4 4 0 0 1-8 0L3.62 3.46a2 2 0 0 0-1.34 2.23l.58 3.57a1 1 0 0 0 .99.84H5v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V10h1.15a1 1 0 0 0 .99-.84l.58-3.57a2 2 0 0 0-1.34-2.23z"/></svg>
      <?php endif; ?>
    </div>
    <div class="card-body">
      <div style="font-size:1.5rem;font-weight:700;color:var(--text);letter-spacing:-.5px"><?= currency($product['price']) ?></div>
      <div style="margin-top:8px"><span class="badge badge-<?= $product['is_active'] ? 'active' : 'inactive' ?>"><?= $product['is_active'] ? 'Active' : 'Inactive' ?></span></div>
      <?php if ($product['description']): ?>
        <p style="font-size:.83rem;color:var(--text-2);margin-top:12px;line-height:1.65"><?= esc($product['description']) ?></p>
      <?php endif; ?>
    </div>
  </div>

  <!-- Variants table -->
  <div class="card">
    <div class="card-header"><span class="card-title">Stock by Variant</span></div>
    <div class="table-wrap">
      <table>
        <thead><tr><th>Size</th><th>Color</th><th>Stock</th></tr></thead>
        <tbody>
          <?php if (empty($variants)): ?>
            <tr><td colspan="3">
              <div class="empty-state">
                <p>No variants yet. <a href="<?= base_url('products/' . $product['id'] . '/variants') ?>" style="color:var(--accent)">Add variants →</a></p>
              </div>
            </td></tr>
          <?php else: ?>
            <?php foreach ($variants as $v): ?>
              <tr>
                <td><span style="font-weight:600"><?= esc($v['size']) ?></span></td>
                <td>
                  <?php if ($v['color_hex']): ?><span class="color-swatch" style="background:<?= esc($v['color_hex']) ?>"></span><?php endif; ?>
                  <?= esc($v['color']) ?>
                </td>
                <td><span class="badge <?= $v['stock'] <= 5 ? 'badge-low' : 'badge-active' ?>"><?= $v['stock'] ?></span></td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
