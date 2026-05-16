<div class="row g-3">
  <?php
  $cards = [
    ['Total Customers', $totalUsers, 'fa-users', 'bg-blue'],
    ['Total Sellers', $totalSellers, 'fa-shop', 'bg-green'],
    ["Today's Orders", $todayOrders, 'fa-receipt', 'bg-orange'],
    ['Monthly Revenue', '$' . number_format($monthRev, 2), 'fa-dollar-sign', 'bg-purple'],
    ['Total Products', $totalProds, 'fa-box', 'bg-pink'],
    ['Pending Sellers', $pending, 'fa-hourglass-half', 'bg-red'],
  ];

  foreach ($cards as $c): ?>
    <div class="col-md-6 col-lg-4">
      <div class="card stat-card">
        <div class="stat-icon <?= $c[3] ?>">
          <i class="fa-solid <?= $c[2] ?>"></i>
        </div>
        <div>
          <p class="stat-label"><?= e($c[0]) ?></p>
          <p class="stat-value"><?= e($c[1]) ?></p>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<div class="row g-3 mt-1">
  <div class="col-lg-7">
    <div class="card p-3">
      <h6 class="mb-3"><i class="fa-solid fa-chart-line"></i> Revenue by Month</h6>
      <canvas id="revChart" height="120"></canvas>
    </div>
  </div>

  <div class="col-lg-5">
    <div class="card p-3">
      <h6 class="mb-3"><i class="fa-solid fa-clock-rotate-left"></i> Recent Activity</h6>
      <ul class="list-group list-group-flush">
        <?php foreach ($activity as $a): ?>
          <li class="list-group-item d-flex justify-content-between">
            <span>
              <i class="fa-regular fa-circle-dot text-primary me-2"></i>
              <?= e($a['action']) ?>
            </span>
            <small class="text-muted"><?= e($a['created_at']) ?></small>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
</div>

<div class="card p-3 mt-3">
  <h6 class="mb-3"><i class="fa-solid fa-bag-shopping"></i> Recent Orders</h6>

  <div class="table-responsive">
    <table class="table align-middle">
      <thead>
        <tr>
          <th>#</th>
          <th>Customer</th>
          <th>Seller</th>
          <th>Total</th>
          <th>Status</th>
          <th>Date</th>
        </tr>
      </thead>

      <tbody>
        <?php foreach ($recent as $r): ?>
          <tr>
            <td>#<?= e($r['id']) ?></td>
            <td><?= e($r['customer_name']) ?></td>
            <td><?= e($r['shop_name']) ?></td>
            <td>$<?= number_format($r['total_amount'], 2) ?></td>
            <td>
              <span class="badge-soft badge-<?= $r['status'] === 'delivered' ? 'approved' : 'pending' ?>">
                <?= e($r['status']) ?>
              </span>
            </td>
            <td><?= e($r['created_at']) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {

  const revenueSeries = <?= json_encode($revenueSeries ?? []) ?>;

  console.log("Revenue Series:", revenueSeries); // DEBUG

  const labels = revenueSeries.map(x => String(x.ym));
  const data = revenueSeries.map(x => Number(x.total));

  const canvas = document.getElementById('revChart');
  if (!canvas) return;

  const ctx = canvas.getContext('2d');

  new Chart(ctx, {
    type: 'line',
    data: {
      labels: labels.length ? labels : ['No Data'],
      datasets: [{
        label: 'Revenue ($)',
        data: data.length ? data : [0],
        borderColor: '#5b8def',
        backgroundColor: 'rgba(91,141,239,.15)',
        fill: true,
        tension: 0.35,
        pointRadius: 4
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { display: false }
      },
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });

});
</script>