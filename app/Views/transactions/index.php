<?php $page_title = 'Transactions'; ?>

<div class="page-header">
  <div class="page-header-left">
    <div class="page-title">Transactions</div>
    <div class="page-sub">Sales and returns history</div>
  </div>
  <a href="<?= base_url('transactions/new') ?>" class="btn btn-primary">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
    New Transaction
  </a>
</div>

<!-- Filter tabs -->
<div style="display:flex;gap:6px;margin-bottom:18px">
  <a href="<?= base_url('transactions') ?>" class="btn <?= ! $type ? 'btn-primary' : 'btn-secondary' ?>">All</a>
  <a href="<?= base_url('transactions?type=sale') ?>" class="btn <?= $type === 'sale' ? 'btn-primary' : 'btn-secondary' ?>">Sales</a>
  <a href="<?= base_url('transactions?type=return') ?>" class="btn <?= $type === 'return' ? 'btn-primary' : 'btn-secondary' ?>">Returns</a>
</div>

<div class="card">
  <div class="table-wrap">
    <table>
      <thead><tr><th>Ref Code</th><th>Type</th><th>By</th><th>Total</th><th>Date</th><th></th></tr></thead>
      <tbody>
        <?php if (empty($transactions)): ?>
          <tr><td colspan="6">
            <div class="empty-state">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
              <p>No transactions found</p>
            </div>
          </td></tr>
        <?php else: ?>
          <?php foreach ($transactions as $tx): ?>
            <tr>
              <td><span style="font-family:monospace;font-size:.79rem;color:var(--accent)"><?= esc($tx['ref_code']) ?></span></td>
              <td><span class="badge badge-<?= $tx['type'] ?>"><?= ucfirst($tx['type']) ?></span></td>
              <td style="font-size:.83rem"><?= esc($tx['user_name']) ?></td>
              <td style="font-weight:600"><?= currency($tx['total']) ?></td>
              <td style="color:var(--text-2);font-size:.78rem"><?= date('M d, Y · H:i', strtotime($tx['created_at'])) ?></td>
              <td><a href="<?= base_url('transactions/' . $tx['id']) ?>" class="btn btn-secondary btn-sm btn-icon" title="View">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
              </a></td>
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
