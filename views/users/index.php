<div class="card p-3 mb-3">
  <div class="d-flex justify-content-between align-items-center mb-2">
    <span></span>
    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addUserModal"><i class="fa-solid fa-plus"></i> Add User</button>
  </div>
  <form class="row g-2" method="get">
    <input type="hidden" name="url" value="users">
    <div class="col-md-6 input-icon">
      <i class="fa-solid fa-magnifying-glass"></i>
      <input class="form-control" name="q" placeholder="Search by name or email" value="<?= e($q) ?>">
    </div>
    <div class="col-md-3">
      <select class="form-select" name="role">
        <option value="customer" <?= $role==='customer'?'selected':'' ?>>Customers</option>
        <option value="delivery" <?= $role==='delivery'?'selected':'' ?>>Delivery Managers</option>
      </select>
    </div>
    <div class="col-md-3"><button class="btn btn-primary w-100"><i class="fa-solid fa-filter"></i> Filter</button></div>
  </form>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1">
  <div class="modal-dialog"><div class="modal-content">
    <form method="post" action="<?= url('users/save') ?>">
      <div class="modal-header"><h5 class="modal-title"><i class="fa-solid fa-user-plus"></i> Add User</h5><button class="btn-close" data-bs-dismiss="modal"></button></div>
      <div class="modal-body">
        <div class="mb-3"><label class="form-label">Name</label><input class="form-control" name="name" required></div>
        <div class="mb-3"><label class="form-label">Email</label><input type="email" class="form-control" name="email" required></div>
        <div class="mb-3"><label class="form-label">Phone</label><input class="form-control" name="phone"></div>
        <div class="mb-3"><label class="form-label">Role</label>
          <select class="form-select" name="role">
            <option value="customer">Customer</option>
            <option value="delivery">Delivery Manager</option>
          </select>
        </div>
        <div class="mb-3"><label class="form-label">Password</label><input type="password" class="form-control" name="password" minlength="6" required></div>
      </div>
      <div class="modal-footer"><button class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Save</button></div>
    </form>
  </div></div>
</div>

<div class="table-card">
  <table class="table align-middle data-table">
    <thead><tr><th>#</th><th>Name</th><th>Email</th><th>Phone</th><th>Status</th><th>Action</th></tr></thead>
    <tbody>
      <?php foreach ($users as $u): ?>
        <tr>
          <td>#<?= e($u['id']) ?></td>
          <td><?= e($u['name']) ?></td>
          <td><?= e($u['email']) ?></td>
          <td><?= e($u['phone'] ?? '—') ?></td>
          <td><span class="badge-soft badge-<?= e($u['status']) ?>"><?= e($u['status']) ?></span></td>
          <td>
            <?php if ($u['status'] === 'active'): ?>
              <a class="btn btn-sm btn-outline-warning" href="<?= url('users/setStatus/'.$u['id']) ?>&s=inactive"><i class="fa-solid fa-ban"></i> Deactivate</a>
            <?php else: ?>
              <a class="btn btn-sm btn-outline-success" href="<?= url('users/setStatus/'.$u['id']) ?>&s=active"><i class="fa-solid fa-check"></i> Activate</a>
            <?php endif; ?>
            <button class="btn btn-sm btn-outline-danger" onclick="confirmGo('<?= url('users/delete/'.$u['id']) ?>','Delete this user?')"><i class="fa-solid fa-trash"></i></button>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>