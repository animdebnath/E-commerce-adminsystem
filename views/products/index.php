<div class="card p-3 mb-3">
  <div class="d-flex justify-content-between align-items-center mb-2">
    <span></span>
    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addProductModal">
      <i class="fa-solid fa-plus"></i> Add Product
    </button>
  </div>

  <form class="row g-2" method="get">
    <input type="hidden" name="url" value="products">

    <div class="col-md-4 input-icon">
      <i class="fa-solid fa-magnifying-glass"></i>
      <input class="form-control" name="q" placeholder="Search product" value="<?= e($q) ?>">
    </div>

    <div class="col-md-3">
      <select class="form-select" name="cat">
        <option value="">All categories</option>
        <?php foreach ($cats as $c): ?>
          <option value="<?= $c['id'] ?>" <?= $cat == $c['id'] ? 'selected' : '' ?>>
            <?= e($c['name']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="col-md-3">
      <select class="form-select" name="sel">
        <option value="">All sellers</option>
        <?php foreach ($sellers as $s): ?>
          <option value="<?= $s['id'] ?>" <?= $sel == $s['id'] ? 'selected' : '' ?>>
            <?= e($s['shop_name']) ?>
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

<!-- ADD PRODUCT MODAL -->
<div class="modal fade" id="addProductModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <form method="post" action="<?= url('products/save') ?>">
        <div class="modal-header">
          <h5 class="modal-title">
            <i class="fa-solid fa-plus"></i> Add Product
          </h5>
          <button class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body row g-3">

          <div class="col-md-8">
            <label class="form-label">Product Name</label>
            <input class="form-control" name="name" required>
          </div>

          <div class="col-md-4">
            <label class="form-label">Price ($)</label>
            <input type="number" step="0.01" min="0.01" class="form-control" name="price" required>
          </div>

          <div class="col-md-4">
            <label class="form-label">Stock</label>
            <input type="number" min="0" class="form-control" name="stock" value="0">
          </div>

          <div class="col-md-4">
            <label class="form-label">Category</label>
            <select class="form-select" name="category_id">
              <option value="">— None —</option>
              <?php foreach ($cats as $c): ?>
                <option value="<?= $c['id'] ?>"><?= e($c['name']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="col-md-4">
            <label class="form-label">Seller</label>
            <select class="form-select" name="seller_id" required>
              <option value="">— Select —</option>
              <?php foreach ($sellers as $s): ?>
                <option value="<?= $s['id'] ?>"><?= e($s['shop_name']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="col-12">
            <label class="form-label">Description</label>
            <textarea class="form-control" name="description" rows="2"></textarea>
          </div>

        </div>

        <div class="modal-footer">
          <button class="btn btn-primary">
            <i class="fa-solid fa-floppy-disk"></i> Save
          </button>
        </div>

      </form>

    </div>
  </div>
</div>

<!-- PRODUCT TABLE -->
<div class="table-card">
  <table class="table align-middle data-table">
    <thead>
      <tr>
        <th>#</th>
        <th>Product</th>
        <th>Seller</th>
        <th>Category</th>
        <th>Price</th>
        <th>Stock</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
    </thead>

    <tbody>
      <?php foreach ($list as $p): ?>
        <tr>
          <td>#<?= e($p['id']) ?></td>
          <td><?= e($p['name']) ?></td>
          <td><?= e($p['shop_name']) ?></td>
          <td><?= e($p['category_name'] ?? '—') ?></td>
          <td>$<?= number_format($p['price'], 2) ?></td>
          <td><?= e($p['stock']) ?></td>

          <td>
            <span class="badge-soft badge-<?= $p['status'] === 'active' ? 'approved' : 'rejected' ?>">
              <?= e($p['status']) ?>
            </span>
          </td>

          <td>
            <?php if ($p['status'] === 'active'): ?>
              <button class="btn btn-sm btn-outline-warning"
                onclick="confirmGo('<?= url('products/remove/'.$p['id']) ?>','Remove this product?')">
                <i class="fa-solid fa-eye-slash"></i>
              </button>
            <?php else: ?>
              <a class="btn btn-sm btn-outline-success"
                 href="<?= url('products/restore/'.$p['id']) ?>">
                <i class="fa-solid fa-rotate-left"></i>
              </a>
            <?php endif; ?>

            <button class="btn btn-sm btn-outline-danger"
              onclick="confirmGo('<?= url('products/delete/'.$p['id']) ?>','Permanently delete this product?')">
              <i class="fa-solid fa-trash"></i>
            </button>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>

  </table>
</div>