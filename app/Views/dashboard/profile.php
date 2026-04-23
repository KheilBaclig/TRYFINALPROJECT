<?php $page_title = 'My Profile'; ?>

<div style="max-width: 900px; margin: 0 auto;">
  <div class="page-header">
    <div class="page-header-left">
      <div class="page-title">My Profile</div>
      <div class="page-sub">Manage your account settings</div>
    </div>
  </div>

  <div style="display:grid;grid-template-columns:280px 1fr;gap:24px;">
  <!-- Avatar Card -->
  <div class="card" style="text-align:center;padding:28px 20px;align-self:start">
    <div style="width:72px;height:72px;border-radius:50%;background:var(--accent-dim);margin:0 auto 14px;overflow:hidden;display:flex;align-items:center;justify-content:center;font-size:1.6rem;font-weight:700;color:var(--accent)">
      <?php if (! empty($user['avatar'])): ?>
        <img src="<?= base_url('uploads/avatars/' . $user['avatar']) ?>" style="width:100%;height:100%;object-fit:cover">
      <?php else: ?>
        <?= strtoupper(substr($user['name'], 0, 1)) ?>
      <?php endif; ?>
    </div>
    <div style="font-weight:600;color:var(--text);font-size:.92rem"><?= esc($user['name']) ?></div>
    <div style="font-size:.76rem;color:var(--text-2);margin-top:3px"><?= esc($user['email']) ?></div>
    <span class="badge badge-<?= $user['role'] ?>" style="margin-top:10px"><?= ucfirst($user['role']) ?></span>

    <?php if (! empty($user['api_token'])): ?>
      <div style="margin-top:18px;padding:11px 12px;background:var(--bg);border-radius:var(--radius);border:1px solid var(--border);text-align:left">
        <div style="font-size:.64rem;color:var(--text-2);text-transform:uppercase;letter-spacing:1.2px;margin-bottom:5px;font-weight:600">API Token</div>
        <div style="font-family:monospace;font-size:.68rem;color:var(--accent);word-break:break-all"><?= esc(substr($user['api_token'], 0, 32)) ?>...</div>
      </div>
    <?php endif; ?>
  </div>

  <!-- Edit Form -->
  <div class="card">
    <div class="card-header"><span class="card-title">Edit Profile</span></div>
    <div class="card-body">
      <form action="<?= base_url('profile/update') ?>" method="POST" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <div class="form-group">
          <label class="form-label">Full Name</label>
          <input type="text" name="name" class="form-control" value="<?= esc($user['name']) ?>" required>
        </div>
        <div class="form-group">
          <label class="form-label">Email</label>
          <input type="email" class="form-control" value="<?= esc($user['email']) ?>" disabled style="opacity:.55;cursor:not-allowed">
          <div class="form-hint">Email cannot be changed.</div>
        </div>
        <div class="form-group">
          <label class="form-label">Avatar</label>
          <input type="file" name="avatar" class="form-control" accept="image/*">
          <div class="form-hint">JPG, PNG up to 2MB</div>
        </div>
        <div class="divider"></div>
        <div class="form-group">
          <label class="form-label">New Password <span style="color:var(--text-2);font-weight:400">(leave blank to keep current)</span></label>
          <input type="password" name="password" class="form-control" placeholder="••••••••" minlength="6">
        </div>
        <button type="submit" class="btn btn-primary">Save Changes</button>
      </form>
    </div>
  </div>
</div>
</div> <!-- End centering wrapper -->
