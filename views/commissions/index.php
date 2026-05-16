<div class="table-card">
  <table class="table align-middle">
    <thead><tr><th>#</th><th>Shop</th><th>Owner</th><th>Commission %</th><th>Save</th></tr></thead>
    <tbody>
      <?php foreach ($sellers as $s): ?>
        <tr>
          <form method="post" action="<?= url('commissions/save') ?>">
            <td>#<?= e($s['id']) ?></td>
            <td><?= e($s['shop_name']) ?></td>
            <td><?= e($s['user_name']) ?></td>
            <td><input type="hidden" name="id" value="<?= $s['id'] ?>"><input type="number" step="0.01" min="0" max="100" name="rate" class="form-control" value="<?= e($s['commission_rate']) ?>" required></td>
            <td><button class="btn btn-sm btn-primary"><i class="fa-solid fa-floppy-disk"></i></button></td>
          </form>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
