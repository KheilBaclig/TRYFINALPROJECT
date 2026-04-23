<?php $page_title = 'Users'; ?>

<div class="page-header">
  <div class="page-header-left">
    <div class="page-title">Users</div>
    <div class="page-sub">Manage team access and roles</div>
  </div>
  <a href="<?= base_url('users/new') ?>" class="btn btn-primary">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
    Add User
  </a>
</div>

<div class="card">
  <div class="table-wrap">
    <table>
      <thead><tr><th>User</th><th>Email</th><th>Role</th><th>API Token</th><th>Actions</th></tr></thead>
      <tbody>
        <?php if (empty($users)): ?>
          <tr><td colspan="5">
            <div class="empty-state">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
              <p>No users found</p>
            </div>
          </td></tr>
        <?php else: ?>
          <?php foreach ($users as $u): ?>
            <tr>
              <td>
                <div style="display:flex;align-items:center;gap:10px">
                  <div style="width:34px;height:34px;border-radius:50%;background:var(--accent-dim);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.78rem;color:var(--accent);flex-shrink:0;overflow:hidden">
                    <?php if ($u['avatar']): ?>
                      <img src="<?= base_url('uploads/avatars/' . $u['avatar']) ?>" style="width:100%;height:100%;object-fit:cover">
                    <?php else: ?>
                      <?= strtoupper(substr($u['name'], 0, 1)) ?>
                    <?php endif; ?>
                  </div>
                  <span style="font-weight:500;font-size:.85rem"><?= esc($u['name']) ?></span>
                </div>
              </td>
              <td style="color:var(--text-2);font-size:.83rem"><?= esc($u['email']) ?></td>
              <td><span class="badge badge-<?= $u['role'] ?>"><?= ucfirst($u['role']) ?></span></td>
              <td><span style="font-family:monospace;font-size:.72rem;color:var(--text-2)"><?= $u['api_token'] ? substr($u['api_token'], 0, 16) . '…' : '—' ?></span></td>
              <td>
                <div style="display:flex;gap:5px">
                  <a href="<?= base_url('users/' . $u['id'] . '/edit') ?>" class="btn btn-secondary btn-sm btn-icon" title="Edit">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                  </a>
                  <?php if ($u['id'] != session()->get('user_id')): ?>
                    <form action="<?= base_url('users/' . $u['id'] . '/delete') ?>" method="POST" onsubmit="return confirm('Delete user?')">
                      <?= csrf_field() ?>
                      <button type="submit" class="btn btn-danger btn-sm btn-icon" title="Delete">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>
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
    <div style="padding:14px 18px;border-top:1px solid var(--border)"><?= $pager->links('default', 'custom_pager') ?></div>
  <?php endif; ?>
</div>
