<div class="table-card">
  <table class="table align-middle data-table">
    <thead><tr><th>#</th><th>Order</th><th>Customer</th><th>Subject</th><th>Status</th><th>Action</th></tr></thead>
    <tbody>
      <?php foreach ($list as $d): ?>
        <tr>
          <td>#<?= e($d['id']) ?></td>
          <td>#<?= e($d['order_id']) ?></td>
          <td><?= e($d['customer_name']) ?></td>
          <td><?= e($d['subject']) ?></td>
          <td><span class="badge-soft badge-<?= $d['status']==='resolved'?'approved':'pending' ?>"><?= e($d['status']) ?></span></td>
          <td>
            <?php if ($d['status']==='open'): ?>
              <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#dr<?= $d['id'] ?>"><i class="fa-solid fa-gavel"></i> Resolve</button>
              <div class="modal fade" id="dr<?= $d['id'] ?>"><div class="modal-dialog"><div class="modal-content">
                <form method="post" action="<?= url('disputes/resolve') ?>">
                  <div class="modal-header"><h5 class="modal-title">Resolve Dispute #<?= $d['id'] ?></h5><button class="btn-close" data-bs-dismiss="modal"></button></div>
                  <div class="modal-body">
                    <input type="hidden" name="id" value="<?= $d['id'] ?>">
                    <p class="text-muted small"><?= e($d['message']) ?></p>
                    <textarea class="form-control" name="admin_notes" rows="4" placeholder="Resolution notes..." required></textarea>
                  </div>
                  <div class="modal-footer"><button class="btn btn-success">Mark Resolved</button></div>
                </form>
              </div></div></div>
            <?php else: ?>
              <small class="text-muted"><?= e($d['admin_notes']) ?></small>
            <?php endif; ?>
            <button class="btn btn-sm btn-outline-danger" onclick="confirmGo('<?= url('disputes/delete/'.$d['id']) ?>','Delete this dispute?')"><i class="fa-solid fa-trash"></i></button>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>