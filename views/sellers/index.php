<div class="card p-3 mb-3">

  <div class="d-flex justify-content-between align-items-center mb-2">
    <span></span>

    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addSellerModal">
      <i class="fa-solid fa-plus"></i> Add Seller
    </button>
  </div>

  <!-- FILTER -->
  <form class="row g-2" method="get">
    <input type="hidden" name="url" value="sellers">

    <div class="col-md-5 input-icon">
      <i class="fa-solid fa-magnifying-glass"></i>
      <input class="form-control" name="q" placeholder="Search by shop, name, email"
        value="<?= e($q ?? '') ?>">
    </div>

    <div class="col-md-3">
      <select class="form-select" name="status">
        <option value="">All status</option>
        <?php foreach (['pending','approved','rejected'] as $st): ?>
          <option value="<?= $st ?>" <?= ($status ?? '') === $st ? 'selected' : '' ?>>
            <?= ucfirst($st) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="col-md-2">
      <button class="btn btn-primary w-100">
        <i class="fa-solid fa-filter"></i> Filter
      </button>
    </div>

  </form>
</div>

<!-- ================= ADD SELLER ================= -->
<div class="modal fade" id="addSellerModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <form method="post" action="index.php?url=sellers/save">

        <div class="modal-header">
          <h5 class="modal-title">Add Seller</h5>
          <button class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">

          <div class="mb-3">
            <label>Full Name</label>
            <input class="form-control" name="name" required>
          </div>

          <div class="mb-3">
            <label>Email</label>
            <input class="form-control" name="email" required>
          </div>

          <div class="mb-3">
            <label>Phone</label>
            <input class="form-control" name="phone">
          </div>

          <div class="mb-3">
            <label>Shop Name</label>
            <input class="form-control" name="shop_name" required>
          </div>

          <div class="mb-3">
            <label>Password</label>
            <input type="password" class="form-control" name="password" required>
          </div>

        </div>

        <div class="modal-footer">
          <button class="btn btn-primary">Save</button>
        </div>

      </form>

    </div>
  </div>
</div>

<!-- ================= EDIT SELLER ================= -->
<div class="modal fade" id="editSellerModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <form method="post" action="index.php?url=sellers/update">

        <div class="modal-header">
          <h5 class="modal-title">Edit Seller</h5>
          <button class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">

          <input type="hidden" name="id" id="edit_seller_id">
          <input type="hidden" name="user_id" id="edit_user_id">

          <div class="mb-3">
            <label>Full Name</label>
            <input class="form-control" name="name" id="edit_name" required>
          </div>

          <div class="mb-3">
            <label>Email</label>
            <input class="form-control" name="email" id="edit_email" required>
          </div>

          <div class="mb-3">
            <label>Phone</label>
            <input class="form-control" name="phone" id="edit_phone">
          </div>

          <div class="mb-3">
            <label>Shop Name</label>
            <input class="form-control" name="shop_name" id="edit_shop" required>
          </div>

        </div>

        <div class="modal-footer">
          <button class="btn btn-primary">Update</button>
        </div>

      </form>

    </div>
  </div>
</div>

<!-- ================= TABLE ================= -->
<div class="table-card">
  <table class="table align-middle data-table">

    <thead>
      <tr>
        <th>#</th>
        <th>Shop</th>
        <th>Owner</th>
        <th>Email</th>
        <th>Commission</th>
        <th>Status</th>
        <th>Suspension</th>
        <th>Actions</th>
      </tr>
    </thead>

    <tbody>
      <?php foreach ($sellers as $s): ?>
        <tr>

          <td>#<?= e($s['id']) ?></td>
          <td><?= e($s['shop_name']) ?></td>
          <td><?= e($s['user_name']) ?></td>
          <td><?= e($s['email']) ?></td>
          <td><?= number_format($s['commission_rate'],2) ?>%</td>

          <td>
            <span class="badge-soft badge-<?= e($s['approval_status']) ?>">
              <?= e($s['approval_status']) ?>
            </span>
          </td>

          <td>
            <?php if ($s['is_suspended']): ?>
              <span class="badge-soft badge-rejected">Suspended</span>
            <?php else: ?>
              <span class="badge-soft badge-approved">Active</span>
            <?php endif; ?>
          </td>

          <td>

            <!-- EDIT -->
            <button class="btn btn-sm btn-primary"
              onclick='openEditSeller(<?= json_encode($s, JSON_HEX_APOS | JSON_HEX_QUOT) ?>)'>
              <i class="fa-solid fa-pen"></i>
            </button>

            <!-- APPROVE -->
            <button class="btn btn-sm btn-success"
              onclick="sellerAction(<?= $s['id'] ?>,'approve')">✔</button>

            <!-- REJECT -->
            <button class="btn btn-sm btn-warning"
              onclick="sellerAction(<?= $s['id'] ?>,'reject')">✖</button>

            <!-- TOGGLE SUSPEND / ACTIVATE -->
            <?php if ($s['is_suspended']): ?>
              <button class="btn btn-sm btn-success"
                onclick="sellerAction(<?= $s['id'] ?>,'activate')">
                ✔
              </button>
            <?php else: ?>
              <button class="btn btn-sm btn-danger"
                onclick="sellerAction(<?= $s['id'] ?>,'suspend')">
                ⛔
              </button>
            <?php endif; ?>

            <!-- DELETE -->
            <button class="btn btn-sm btn-outline-danger"
              onclick="confirmGo('index.php?url=sellers/delete/<?= $s['id'] ?>','Delete seller?')">
              🚮
            </button>

          </td>

        </tr>
      <?php endforeach; ?>
    </tbody>

  </table>
</div>

<!-- ================= JS ================= -->
<script>
function openEditSeller(s) {
  document.getElementById('edit_seller_id').value = s.id;
  document.getElementById('edit_user_id').value = s.user_id;

  document.getElementById('edit_name').value = s.user_name || '';
  document.getElementById('edit_email').value = s.email || '';
  document.getElementById('edit_phone').value = s.phone || '';
  document.getElementById('edit_shop').value = s.shop_name || '';

  new bootstrap.Modal(document.getElementById('editSellerModal')).show();
}
</script>