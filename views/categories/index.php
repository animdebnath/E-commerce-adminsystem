<div class="row g-3">
  <div class="col-lg-4">
    <div class="form-section">
      <h6 class="mb-3"><i class="fa-solid fa-plus"></i> Add Category</h6>
      <form method="post" action="<?= url('categories/save') ?>">
        <div class="mb-3 input-icon">
          <i class="fa-solid fa-tag"></i>
          <input class="form-control" name="name" placeholder="Category name" required>
        </div>
        <div class="mb-3">
          <select class="form-select" name="parent_id">
            <option value="0">— No parent (top level) —</option>
            <?php foreach ($all as $c): ?>
              <option value="<?= $c['id'] ?>"><?= e($c['name']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <button class="btn btn-primary w-100"><i class="fa-solid fa-floppy-disk"></i> Save</button>
      </form>
    </div>
  </div>
  <div class="col-lg-8">
    <div class="table-card">
      <table class="table align-middle data-table">
        <thead><tr><th>#</th><th>Name</th><th>Parent</th><th>Action</th></tr></thead>
        <tbody>
        <?php foreach ($cats as $c): ?>
          <tr>
            <td>#<?= e($c['id']) ?></td>
            <td><?= e($c['name']) ?></td>
            <td><?= e($c['parent_name'] ?? '—') ?></td>
            <td>
              <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#edit<?= $c['id'] ?>"><i class="fa-solid fa-pen"></i></button>
              <button class="btn btn-sm btn-outline-danger" onclick="confirmGo('<?= url('categories/delete/'.$c['id']) ?>','Delete this category?')"><i class="fa-solid fa-trash"></i></button>
              <div class="modal fade" id="edit<?= $c['id'] ?>"><div class="modal-dialog"><div class="modal-content">
                <form method="post" action="<?= url('categories/save') ?>">
                  <div class="modal-header"><h5 class="modal-title">Edit Category</h5><button class="btn-close" data-bs-dismiss="modal"></button></div>
                  <div class="modal-body">
                    <input type="hidden" name="id" value="<?= $c['id'] ?>">
                    <input class="form-control mb-2" name="name" value="<?= e($c['name']) ?>" required>
                    <select class="form-select" name="parent_id">
                      <option value="0">— No parent —</option>
                      <?php foreach ($all as $p): if($p['id']==$c['id'])continue; ?>
                        <option value="<?= $p['id'] ?>" <?= $p['id']==$c['parent_id']?'selected':'' ?>><?= e($p['name']) ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="modal-footer"><button class="btn btn-primary">Save</button></div>
                </form>
              </div></div></div>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
