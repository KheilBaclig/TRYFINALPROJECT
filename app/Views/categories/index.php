<?php $page_title = 'Categories'; ?>

<div class="page-header">
  <div class="page-header-left">
    <div class="page-title">Categories</div>
    <div class="page-sub">Organize your product catalog</div>
  </div>
  <?php if (in_array(session()->get('user_role'), ['superadmin', 'manager'])): ?>
  <a href="<?= base_url('categories/new') ?>" class="btn btn-primary">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
    Add Category
  </a>
  <?php endif; ?>
</div>

<div class="card">
  <div class="table-wrap">
    <table>
      <thead><tr><th>Name</th><th>Slug</th><th>Description</th><?php if (in_array(session()->get('user_role'), ['superadmin', 'manager'])): ?><th>Actions</th><?php endif; ?></tr></thead>
      <tbody>
        <?php if (empty($categories)): ?>
          <tr><td colspan="4">
            <div class="empty-state">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
              <p>No categories yet</p>
            </div>
          </td></tr>
        <?php else: ?>
          <?php foreach ($categories as $cat): ?>
            <tr>
              <td><span style="font-weight:600"><?= esc($cat['name']) ?></span></td>
              <td><span style="font-family:monospace;font-size:.79rem;color:var(--text-2)"><?= esc($cat['slug']) ?></span></td>
              <td style="color:var(--text-2);font-size:.83rem"><?= character_limiter(esc($cat['description'] ?? ''), 60) ?></td>
              <?php if (in_array(session()->get('user_role'), ['superadmin', 'manager'])): ?>
              <td>
                <div style="display:flex;gap:5px">
                  <a href="<?= base_url('categories/' . $cat['id'] . '/edit') ?>" class="btn btn-secondary btn-sm btn-icon" title="Edit">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                  </a>
                  <form action="<?= base_url('categories/' . $cat['id'] . '/delete') ?>" method="POST" onsubmit="return confirm('Delete category?')">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-danger btn-sm btn-icon" title="Delete">
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>
                    </button>
                  </form>
                </div>
              </td>
              <?php endif; ?>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
  <?php if ($pager): ?>
    <div style="padding:14px 18px;border-top:1px solid var(--border)"><?= $pager->links('default', 'custom_pager') ?></div>
  <?php endif; ?>
</div>
