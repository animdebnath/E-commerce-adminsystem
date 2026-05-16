<div class="row g-3">
  <div class="col-lg-4">
    <div class="form-section">
      <h6 class="mb-3"><i class="fa-solid fa-ticket"></i> New Coupon</h6>
      <form method="post" action="<?= url('coupons/save') ?>" id="couponForm" novalidate>
        <div class="mb-3 input-icon"><i class="fa-solid fa-tag"></i><input class="form-control" name="code" placeholder="CODE10" required></div>
        <div class="mb-3 input-icon"><i class="fa-solid fa-percent"></i><input class="form-control" type="number" step="0.01" name="discount" placeholder="Discount %" required></div>
        <div class="mb-3 input-icon"><i class="fa-solid fa-calendar"></i><input class="form-control" type="date" name="valid_until"></div>
        <button class="btn btn-primary w-100"><i class="fa-solid fa-plus"></i> Create</button>
      </form>
    </div>
  </div>
  <div class="col-lg-8">
    <div class="table-card">
      <table class="table align-middle data-table">
        <thead><tr><th>#</th><th>Code</th><th>Discount</th><th>Valid Until</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
          <?php foreach ($list as $c): ?>
            <tr>
              <td>#<?= e($c['id']) ?></td>
              <td><strong><?= e($c['code']) ?></strong></td>
              <td><?= number_format($c['discount_percent'],2) ?>%</td>
              <td><?= e($c['valid_until'] ?? '—') ?></td>
              <td><span class="badge-soft badge-<?= $c['is_active']?'approved':'rejected' ?>"><?= $c['is_active']?'Active':'Inactive' ?></span></td>
              <td>
                <a class="btn btn-sm btn-outline-secondary" href="<?= url('coupons/toggle/'.$c['id']) ?>"><i class="fa-solid fa-toggle-on"></i></a>
                <button class="btn btn-sm btn-outline-danger" onclick="confirmGo('<?= url('coupons/delete/'.$c['id']) ?>','Delete this coupon?')"><i class="fa-solid fa-trash"></i></button>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<script>
document.getElementById('couponForm').addEventListener('submit',function(e){
  if(!this.code.value.trim()){e.preventDefault();alert('Code required');return;}
  if(!(parseFloat(this.discount.value)>0)){e.preventDefault();alert('Discount must be > 0');}
});
</script>
