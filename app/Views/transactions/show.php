<?php $page_title = 'Transaction ' . esc($transaction['ref_code']); ?>

<div class="page-header">
  <div class="page-header-left">
    <div class="page-title"><?= esc($transaction['ref_code']) ?></div>
    <div class="page-sub">Transaction details</div>
  </div>
  <a href="<?= base_url('transactions') ?>" class="btn btn-secondary">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
    Back
  </a>
</div>

<div style="max-width:720px">
  <div class="card" style="margin-bottom:16px">
    <div class="card-body">
      <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:20px">
        <div>
          <div style="font-size:.68rem;color:var(--text-2);text-transform:uppercase;letter-spacing:1px;margin-bottom:5px;font-weight:600">Type</div>
          <span class="badge badge-<?= $transaction['type'] ?>"><?= ucfirst($transaction['type']) ?></span>
        </div>
        <div>
          <div style="font-size:.68rem;color:var(--text-2);text-transform:uppercase;letter-spacing:1px;margin-bottom:5px;font-weight:600">Total</div>
          <div style="font-size:1.25rem;font-weight:700;color:var(--text);letter-spacing:-.5px"><?= currency($transaction['total']) ?></div>
        </div>
        <div>
          <div style="font-size:.68rem;color:var(--text-2);text-transform:uppercase;letter-spacing:1px;margin-bottom:5px;font-weight:600">By</div>
          <div style="font-weight:500;font-size:.85rem"><?= esc($transaction['user_name']) ?></div>
        </div>
        <div>
          <div style="font-size:.68rem;color:var(--text-2);text-transform:uppercase;letter-spacing:1px;margin-bottom:5px;font-weight:600">Date</div>
          <div style="font-size:.83rem;color:var(--text-2)"><?= date('M d, Y · H:i', strtotime($transaction['created_at'])) ?></div>
        </div>
      </div>
      <?php if ($transaction['notes']): ?>
        <div style="margin-top:16px;padding:12px 14px;background:var(--bg);border-radius:var(--radius);font-size:.83rem;color:var(--text-2);border:1px solid var(--border);display:flex;gap:8px;align-items:flex-start">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" style="width:14px;height:14px;flex-shrink:0;margin-top:2px;stroke-width:2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
          <?= esc($transaction['notes']) ?>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <div class="card">
    <div class="card-header"><span class="card-title">Items</span></div>
    <div class="table-wrap">
      <table>
        <thead><tr><th>Product</th><th>Variant</th><th>Qty</th><th>Unit Price</th><th>Subtotal</th></tr></thead>
        <tbody>
          <?php foreach ($items as $item): ?>
            <tr>
              <td>
                <div style="font-weight:500;font-size:.85rem"><?= esc($item['product_name']) ?></div>
                <div style="font-size:.72rem;color:var(--text-2)"><?= esc($item['sku']) ?></div>
              </td>
              <td>
                <?php if ($item['color_hex']): ?><span class="color-swatch" style="background:<?= esc($item['color_hex']) ?>"></span><?php endif; ?>
                <?= esc($item['size']) ?> / <?= esc($item['color']) ?>
              </td>
              <td style="font-weight:600"><?= $item['quantity'] ?></td>
              <td style="color:var(--text-2)"><?= currency($item['unit_price']) ?></td>
              <td style="font-weight:700"><?= currency($item['unit_price'] * $item['quantity']) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
        <tfoot>
          <tr style="background:var(--bg)">
            <td colspan="4" style="text-align:right;font-weight:600;padding:14px 16px;color:var(--text-2)">Total</td>
            <td style="font-weight:700;font-size:1rem;color:var(--text);padding:14px 16px"><?= currency($transaction['total']) ?></td>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
</div>
