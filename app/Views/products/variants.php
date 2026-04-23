<?php $page_title = 'Variants — ' . esc($product['name']); ?>

<div class="page-header">
  <div class="page-header-left">
    <div class="page-title">Variants</div>
    <div class="page-sub"><?= esc($product['name']) ?> · <?= esc($product['sku']) ?></div>
  </div>
  <a href="<?= base_url('products/' . $product['id']) ?>" class="btn btn-secondary">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
    Back
  </a>
</div>

<div style="display:grid;grid-template-columns:<?= in_array(session()->get('user_role'), ['superadmin','manager']) ? '1fr 320px' : '1fr' ?>;gap:20px">
  <!-- Variants table -->
  <div class="card">
    <div class="card-header"><span class="card-title">All Variants</span></div>
    <div class="table-wrap">
      <table>
        <thead><tr><th>Size</th><th>Color</th><th>Stock</th><?php if (in_array(session()->get('user_role'), ['superadmin','manager'])): ?><th></th><?php endif; ?></tr></thead>
        <tbody>
          <?php if (empty($variants)): ?>
            <tr><td colspan="4"><div class="empty-state"><p>No variants yet</p></div></td></tr>
          <?php else: ?>
            <?php foreach ($variants as $v): ?>
              <tr>
                <td><span style="font-weight:600"><?= esc($v['size']) ?></span></td>
                <td>
                  <?php if ($v['color_hex']): ?><span class="color-swatch" style="background:<?= esc($v['color_hex']) ?>"></span><?php endif; ?>
                  <?= esc($v['color']) ?>
                </td>
                <td><span class="badge <?= $v['stock'] <= 5 ? 'badge-low' : 'badge-active' ?>"><?= $v['stock'] ?> units</span></td>
                <?php if (in_array(session()->get('user_role'), ['superadmin', 'manager'])): ?>
                <td>
                  <form action="<?= base_url('products/variants/' . $v['id'] . '/delete') ?>" method="POST" onsubmit="return confirm('Delete variant?')">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-danger btn-sm btn-icon" title="Delete">
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>
                    </button>
                  </form>
                </td>
                <?php endif; ?>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Add Variant Form -->
  <?php if (in_array(session()->get('user_role'), ['superadmin', 'manager'])): ?>
  <div class="card" style="align-self:start">
    <div class="card-header"><span class="card-title">Add Variant</span></div>
    <div class="card-body">
      <form action="<?= base_url('products/' . $product['id'] . '/variants') ?>" method="POST">
        <?= csrf_field() ?>
        <div class="form-group">
          <label class="form-label">Size *</label>
          <select name="size" class="form-control" required>
            <option value="">Select size…</option>
            <?php foreach (['XS','S','M','L','XL','XXL','One Size'] as $s): ?>
              <option value="<?= $s ?>"><?= $s ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Color *</label>
          <input type="text" name="color" class="form-control" placeholder="e.g. Midnight Black" required>
        </div>
        <div class="form-group">
          <label class="form-label">Color Hex</label>
          <input type="color" name="color_hex" class="form-control" style="height:42px;padding:4px 8px;cursor:pointer">
        </div>
        <div class="form-group">
          <label class="form-label">Stock *</label>
          <input type="number" name="stock" class="form-control" min="0" value="0" required>
        </div>
        <button type="submit" class="btn btn-primary" style="width:100%">Add Variant</button>
      </form>
    </div>
  </div>
  <?php endif; ?>
</div>
