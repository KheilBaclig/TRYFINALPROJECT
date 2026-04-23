<?php $page_title = $category ? 'Edit Category' : 'New Category'; ?>

<div class="page-header">
  <div class="page-header-left">
    <div class="page-title"><?= $category ? 'Edit Category' : 'New Category' ?></div>
  </div>
  <a href="<?= base_url('categories') ?>" class="btn btn-secondary">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
    Back
  </a>
</div>

<div style="max-width:520px">
  <div class="card">
    <div class="card-body">
      <form action="<?= $category ? base_url('categories/' . $category['id']) : base_url('categories') ?>" method="POST">
        <?= csrf_field() ?>
        <div class="form-group">
          <label class="form-label">Name *</label>
          <input type="text" name="name" class="form-control" value="<?= old('name', $category['name'] ?? '') ?>" placeholder="e.g. Tops & Shirts" required>
        </div>
        <div class="form-group">
          <label class="form-label">Description</label>
          <textarea name="description" class="form-control" placeholder="Brief description of this category…"><?= old('description', $category['description'] ?? '') ?></textarea>
        </div>
        <div style="display:flex;gap:10px">
          <button type="submit" class="btn btn-primary"><?= $category ? 'Update' : 'Create' ?></button>
          <a href="<?= base_url('categories') ?>" class="btn btn-secondary">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</div>
