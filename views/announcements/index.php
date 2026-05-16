<div class="row g-3">
  <div class="col-lg-5">
    <div class="form-section">
      <h6 class="mb-3"><i class="fa-solid fa-bullhorn"></i> Post Announcement</h6>
      <form method="post" action="<?= url('announcements/save') ?>">
        <div class="mb-3 input-icon"><i class="fa-solid fa-heading"></i><input class="form-control" name="title" placeholder="Title" required></div>
        <div class="mb-3"><textarea class="form-control" name="body" rows="4" placeholder="Body" required></textarea></div>
        <button class="btn btn-primary w-100"><i class="fa-solid fa-paper-plane"></i> Publish</button>
      </form>
    </div>
  </div>
  <div class="col-lg-7">
    <?php foreach ($list as $a): ?>
      <div class="card p-3 mb-3">
        <div class="d-flex justify-content-between"><h6 class="mb-1"><?= e($a['title']) ?></h6>
          <a class="btn btn-sm btn-outline-danger" href="<?= url('announcements/delete/'.$a['id']) ?>" onclick="return confirm('Delete?')"><i class="fa-solid fa-trash"></i></a></div>
        <p class="text-muted small mb-1"><?= e($a['created_at']) ?></p>
        <p class="mb-0"><?= nl2br(e($a['body'])) ?></p>
      </div>
    <?php endforeach; ?>
  </div>
</div>
