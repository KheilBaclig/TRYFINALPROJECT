<?php $page_title = 'New Transaction'; ?>

<div class="page-header">
  <div class="page-header-left">
    <div class="page-title">New Transaction</div>
    <div class="page-sub">Record a sale or return</div>
  </div>
  <a href="<?= base_url('transactions') ?>" class="btn btn-secondary">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
    Back
  </a>
</div>

<div style="display:grid;grid-template-columns:1fr 300px;gap:20px">
  <div class="card">
    <div class="card-header"><span class="card-title">Transaction Items</span></div>
    <div class="card-body">
      <form action="<?= base_url('transactions') ?>" method="POST" id="txForm">
        <?= csrf_field() ?>

        <div class="form-grid-2" style="margin-bottom:18px">
          <div class="form-group" style="margin-bottom:0">
            <label class="form-label">Type *</label>
            <select name="type" class="form-control" required>
              <option value="sale">Sale</option>
              <option value="return">Return</option>
            </select>
          </div>
          <div class="form-group" style="margin-bottom:0">
            <label class="form-label">Notes</label>
            <input type="text" name="notes" class="form-control" placeholder="Optional notes…">
          </div>
        </div>

        <div class="divider"></div>

        <div id="items-container">
          <div class="item-row" style="display:grid;grid-template-columns:1fr 1fr 80px auto;gap:10px;align-items:end;margin-bottom:12px">
            <div class="form-group" style="margin-bottom:0">
              <label class="form-label">Product</label>
              <select class="form-control product-select" onchange="loadVariants(this)">
                <option value="">Select product…</option>
                <?php foreach ($products as $p): ?>
                  <option value="<?= $p['id'] ?>"><?= esc($p['name']) ?> (<?= esc($p['sku']) ?>)</option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group" style="margin-bottom:0">
              <label class="form-label">Variant</label>
              <select name="variant_id[]" class="form-control variant-select" required>
                <option value="">Select variant…</option>
              </select>
            </div>
            <div class="form-group" style="margin-bottom:0">
              <label class="form-label">Qty</label>
              <input type="number" name="quantity[]" class="form-control" min="1" value="1" required>
            </div>
            <div style="padding-bottom:2px">
              <button type="button" onclick="removeRow(this)" class="btn btn-danger btn-sm btn-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/></svg>
              </button>
            </div>
          </div>
        </div>

        <button type="button" onclick="addRow()" class="btn btn-secondary btn-sm" style="margin-bottom:20px">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
          Add Item
        </button>

        <div class="divider"></div>
        <button type="submit" class="btn btn-primary">Record Transaction</button>
      </form>
    </div>
  </div>

  <!-- Available Variants Panel -->
  <div class="card" style="align-self:start">
    <div class="card-header"><span class="card-title">Available Variants</span></div>
    <div class="card-body" style="max-height:420px;overflow-y:auto;padding-top:10px">
      <?php foreach ($products as $p): ?>
        <div style="margin-bottom:14px">
          <div style="font-size:.8rem;font-weight:600;margin-bottom:6px;color:var(--text)"><?= esc($p['name']) ?></div>
          <?php $pVariants = array_filter($variants, fn($v) => $v['product_id'] == $p['id']); ?>
          <?php foreach ($pVariants as $v): ?>
            <div style="display:flex;justify-content:space-between;font-size:.77rem;padding:5px 0;border-bottom:1px solid var(--border)">
              <span style="color:var(--text-2)"><?= esc($v['size']) ?> / <?= esc($v['color']) ?></span>
              <span class="badge <?= $v['stock'] <= 5 ? 'badge-low' : 'badge-active' ?>"><?= $v['stock'] ?></span>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>

<script>
const allVariants = <?= json_encode(array_values($variants)) ?>;

function loadVariants(productSelect) {
  const productId = productSelect.value;
  const row = productSelect.closest('.item-row');
  const variantSelect = row.querySelector('.variant-select');
  variantSelect.innerHTML = '<option value="">Select variant…</option>';
  allVariants
    .filter(v => v.product_id == productId)
    .forEach(v => {
      const opt = document.createElement('option');
      opt.value = v.id;
      opt.textContent = `${v.size} / ${v.color} (${v.stock} in stock)`;
      variantSelect.appendChild(opt);
    });
}

function addRow() {
  const container = document.getElementById('items-container');
  const first = container.querySelector('.item-row');
  const clone = first.cloneNode(true);
  clone.querySelectorAll('select, input').forEach(el => {
    if (el.tagName === 'SELECT') el.innerHTML = first.querySelector(el.classList.contains('product-select') ? '.product-select' : '.variant-select').innerHTML;
    if (el.tagName === 'INPUT') el.value = 1;
  });
  clone.querySelector('.product-select').onchange = function() { loadVariants(this); };
  container.appendChild(clone);
}

function removeRow(btn) {
  const rows = document.querySelectorAll('.item-row');
  if (rows.length > 1) btn.closest('.item-row').remove();
}
</script>
