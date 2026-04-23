<?php $page_title = $user ? 'Edit User' : 'New User'; ?>

<div class="page-header">
  <div class="page-header-left">
    <div class="page-title"><?= $user ? 'Edit User' : 'New User' ?></div>
  </div>
  <a href="<?= base_url('users') ?>" class="btn btn-secondary">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
    Back
  </a>
</div>

<div style="max-width:520px">
  <div class="card">
    <div class="card-body">
      <form action="<?= $user ? base_url('users/' . $user['id']) : base_url('users') ?>" method="POST">
        <?= csrf_field() ?>
        <div class="form-group">
          <label class="form-label">Full Name *</label>
          <input type="text" name="name" class="form-control" value="<?= old('name', $user['name'] ?? '') ?>" placeholder="e.g. Jane Santos" required>
        </div>
        <div class="form-group">
          <label class="form-label">Email *</label>
          <input type="email" name="email" class="form-control" value="<?= old('email', $user['email'] ?? '') ?>" placeholder="user@example.com" required>
        </div>
        <div class="form-group">
          <label class="form-label">Role *</label>
          <select name="role" class="form-control" required>
            <?php foreach (['superadmin' => 'Super Admin', 'manager' => 'Manager', 'staff' => 'Staff'] as $val => $label): ?>
              <option value="<?= $val ?>" <?= old('role', $user['role'] ?? '') === $val ? 'selected' : '' ?>><?= $label ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Password <?= $user ? '<span style="color:var(--text-2);font-weight:400">(leave blank to keep)</span>' : '*' ?></label>
          <input type="password" name="password" class="form-control" placeholder="••••••••" <?= ! $user ? 'required' : '' ?> minlength="6">
        </div>
        <div style="display:flex;gap:10px">
          <button type="submit" class="btn btn-primary"><?= $user ? 'Update User' : 'Create User' ?></button>
          <a href="<?= base_url('users') ?>" class="btn btn-secondary">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</div>
