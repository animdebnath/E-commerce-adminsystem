<div class="d-flex justify-content-between mb-3">
  <h5 class="mb-0">Analytics & Reports</h5>

  <a class="btn btn-outline-primary" target="_blank" href="<?= url('reports/printable') ?>">
    <i class="fa-solid fa-print"></i> Printable Report
  </a>
</div>

<div class="row g-3">

  <!-- Revenue Chart -->
  <div class="col-lg-7">
    <div class="card p-3">
      <h6>Revenue by Month</h6>
      <canvas id="rev"></canvas>
    </div>
  </div>

  <!-- Top Sellers -->
  <div class="col-lg-5">
    <div class="card p-3">
      <h6>Top Sellers</h6>
      <ul class="list-group list-group-flush">

        <?php foreach ($top as $t): ?>
          <li class="list-group-item d-flex justify-content-between">

            <span>
              <?= e($t['seller_name'] ?? $t['shop_name']) ?>
            </span>

            <strong>
              $<?= number_format($t['total_sales'] ?? 0, 2) ?>
            </strong>

          </li>
        <?php endforeach; ?>

      </ul>
    </div>
  </div>

  <!-- Top Categories -->
  <div class="col-lg-5">
    <div class="card p-3">
      <h6>Top Categories</h6>
      <ul class="list-group list-group-flush">

        <?php foreach ($topCats as $t): ?>
          <li class="list-group-item d-flex justify-content-between">
            <span><?= e($t['name']) ?></span>
            <strong><?= e($t['total']) ?> products</strong>
          </li>
        <?php endforeach; ?>

      </ul>
    </div>
  </div>

</div>

<!-- Chart JS -->
<script>
document.addEventListener("DOMContentLoaded", function () {

  const revenueSeries = <?= json_encode($revenueSeries ?? []) ?>;

  const labels = revenueSeries.map(x => x.ym);
  const data = revenueSeries.map(x => Number(x.total));

  const canvas = document.getElementById('rev');

  if (!canvas) return;

  new Chart(canvas.getContext('2d'), {
    type: 'bar',
    data: {
      labels: labels.length ? labels : ['No Data'],
      datasets: [{
        label: 'Revenue',
        data: data.length ? data : [0],
        backgroundColor: '#5b8def'
      }]
    },
    options: {
      plugins: {
        legend: { display: false }
      },
      scales: {
        y: { beginAtZero: true }
      }
    }
  });

});
</script>