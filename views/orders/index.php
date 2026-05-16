<div class="card p-3 mb-3">
  <form class="row g-2" method="get">
    <input type="hidden" name="url" value="orders">
    <div class="col-md-2"><select class="form-select" name="status"><option value="">All status</option>
      <?php foreach (['pending','processing','shipped','delivered','cancelled'] as $s): ?>
        <option value="<?= $s ?>" <?= ($f['status']??'')===$s?'selected':'' ?>><?= ucfirst($s) ?></option>
      <?php endforeach; ?>
    </select></div>
    <div class="col-md-3"><select class="form-select" name="seller"><option value="">All sellers</option>
      <?php foreach ($sellers as $s): ?><option value="<?= $s['id'] ?>" <?= ($f['seller']??'')==$s['id']?'selected':'' ?>><?= e($s['shop_name']) ?></option><?php endforeach; ?>
    </select></div>
    <div class="col-md-2"><input class="form-control" name="customer" placeholder="Customer ID" value="<?= e($f['customer']??'') ?>"></div>
    <div class="col-md-2"><input type="date" class="form-control" name="from" value="<?= e($f['from']??'') ?>"></div>
    <div class="col-md-2"><input type="date" class="form-control" name="to" value="<?= e($f['to']??'') ?>"></div>
    <div class="col-md-1"><button class="btn btn-primary w-100"><i class="fa-solid fa-filter"></i></button></div>
  </form>
</div>
<div class="table-card">
  <table class="table align-middle data-table">
    <thead><tr><th>#</th><th>Customer</th><th>Seller</th><th>Total</th><th>Status</th><th>Date</th><th>Action</th></tr></thead>
    <tbody>
      <?php foreach ($orders as $o): ?>
        <tr>
          <td>#<?= e($o['id']) ?></td>
          <td><?= e($o['customer_name']) ?></td>
          <td><?= e($o['shop_name']) ?></td>
          <td>$<?= number_format($o['total_amount'],2) ?></td>
          <td><span class="badge-soft badge-<?= $o['status']==='delivered'?'approved':'pending' ?>"><?= e($o['status']) ?></span></td>
          <td><?= e($o['created_at']) ?></td>
          <td><button class="btn btn-sm btn-outline-danger" onclick="confirmGo('<?= url('orders/delete/'.$o['id']) ?>','Delete this order?')"><i class="fa-solid fa-trash"></i></button></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>