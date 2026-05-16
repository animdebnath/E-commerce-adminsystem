<div class="row g-3">

  <!-- LEFT: Featured Products -->
  <div class="col-lg-7">
    <div class="table-card">
      <h6 class="mb-3"><i class="fa-solid fa-star"></i> Featured Products</h6>

      <table class="table align-middle data-table">
        <thead>
          <tr>
            <th>#</th>
            <th>Product</th>
            <th>Seller</th>
            <th>Featured</th>
            <th>Toggle</th>
          </tr>
        </thead>

        <tbody>
          <?php foreach ($products as $p): ?>
            <tr>
              <td>#<?= e($p['id']) ?></td>
              <td><?= e($p['name']) ?></td>
              <td><?= e($p['shop_name']) ?></td>

              <td>
                <?= $p['is_featured']
                  ? '<span class="badge-soft badge-approved">Yes</span>'
                  : '<span class="badge-soft badge-rejected">No</span>' ?>
              </td>

              <td>
                <a class="btn btn-sm <?= $p['is_featured'] ? 'btn-success' : 'btn-outline-secondary' ?>"
                   href="<?= url('featured/toggleProduct/'.$p['id']) ?>">
                  <i class="fa-solid fa-star"></i>
                </a>
              </td>

            </tr>
          <?php endforeach; ?>
        </tbody>

      </table>
    </div>
  </div>

  <!-- RIGHT: Seller Banner Upload -->
  <div class="col-lg-5">
    <div class="form-section">

      <h6 class="mb-3"><i class="fa-solid fa-image"></i> Upload Seller Banner</h6>

      <form method="post" action="<?= url('featured/uploadBanner') ?>" enctype="multipart/form-data">

        <div class="mb-3">
          <select name="seller_id" class="form-select" required>
            <?php foreach ($sellers as $s): ?>
              <option value="<?= $s['id'] ?>">
                <?= e($s['shop_name']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="mb-3">
          <input type="file" name="banner" accept="image/*" class="form-control" required>
        </div>

        <button class="btn btn-primary w-100">
          <i class="fa-solid fa-upload"></i> Upload
        </button>

      </form>

      <!-- BANNER LIST -->
      <div class="mt-3">
        <?php foreach ($sellers as $s): ?>
          <?php if (!empty($s['banner'])): ?>
            <div class="mb-3">

              <strong><?= e($s['shop_name']) ?></strong><br>

              <img src="<?= BASE_URL ?>/uploads/<?= e($s['banner']) ?>"
                   style="max-width:100%;border-radius:8px;margin-bottom:8px;">

              <!-- MODERN DELETE BUTTON -->
              <br>
              <button class="btn btn-sm btn-danger"
                onclick="confirmGo('<?= url('featured/deleteBanner/'.$s['id']) ?>','Delete this banner?')">
                <i class="fa-solid fa-trash"></i> Delete
              </button>

            </div>
          <?php endif; ?>
        <?php endforeach; ?>
      </div>

    </div>
  </div>

</div>