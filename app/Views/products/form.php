<?php $page_title = $product ? 'Edit Product' : 'New Product'; ?>

<div class="page-header">
  <div class="page-header-left">
    <div class="page-title"><?= $product ? 'Edit Product' : 'New Product' ?></div>
    <div class="page-sub"><?= $product ? 'Update product details' : 'Add a new item to inventory' ?></div>
  </div>
  <a href="<?= base_url('products') ?>" class="btn btn-secondary">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
    Back
  </a>
</div>

<div style="max-width:720px">
  <div class="card">
    <div class="card-body">
      <form action="<?= $product ? base_url('products/' . $product['id']) : base_url('products') ?>" method="POST" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="form-grid-2">
          <div class="form-group">
            <label class="form-label">Product Name *</label>
            <input type="text" name="name" class="form-control" value="<?= old('name', $product['name'] ?? '') ?>" placeholder="e.g. Classic Polo Shirt" required>
          </div>
          <div class="form-group">
            <label class="form-label">SKU *</label>
            <input type="text" name="sku" class="form-control" value="<?= old('sku', $product['sku'] ?? '') ?>" placeholder="e.g. TOP-001" required>
          </div>
        </div>

        <div class="form-grid-2">
          <div class="form-group">
            <label class="form-label">Category *</label>
            <select name="category_id" class="form-control" required>
              <option value="">Select category…</option>
              <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['id'] ?>" <?= old('category_id', $product['category_id'] ?? '') == $cat['id'] ? 'selected' : '' ?>>
                  <?= esc($cat['name']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label class="form-label">Price *</label>
            <input type="number" name="price" class="form-control" step="0.01" min="0" value="<?= old('price', $product['price'] ?? '') ?>" placeholder="0.00" required>
          </div>
        </div>

        <div class="form-group">
          <label class="form-label">Description</label>
          <textarea name="description" class="form-control" placeholder="Brief product description…"><?= old('description', $product['description'] ?? '') ?></textarea>
        </div>

        <div class="form-group">
          <label class="form-label">Product Image</label>
          <?php if (! empty($product['image'])): ?>
            <div style="margin-bottom:12px">
              <img src="<?= base_url('uploads/products/' . $product['image']) ?>" style="width:80px;height:80px;object-fit:cover;border-radius:10px;border:1px solid var(--border)">
            </div>
          <?php endif; ?>
          <input type="file" name="image" class="form-control" accept="image/*">
          <div class="form-hint">JPG, PNG, WebP — will be resized to 800×800px</div>
        </div>

        <div style="display:flex;gap:10px;margin-top:6px">
          <button type="submit" class="btn btn-primary"><?= $product ? 'Update Product' : 'Create Product' ?></button>
          <a href="<?= base_url('products') ?>" class="btn btn-secondary">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</div>
