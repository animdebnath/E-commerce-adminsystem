<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Monthly Report</title>

  <style>
    body {
      font-family: Arial;
      padding: 30px;
      color: #222;
    }

    h1 {
      color: #3f6fd6;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin: 14px 0;
    }

    th, td {
      border: 1px solid #ddd;
      padding: 8px;
      text-align: left;
    }

    th {
      background: #f3f6fd;
    }
  </style>
</head>

<body onload="window.print()">

<h1>Monthly Platform Report</h1>

<p>Generated: <?= date('Y-m-d H:i') ?></p>

<p><strong>Current month revenue:</strong> $<?= number_format($monthRev ?? 0, 2) ?></p>

<hr>

<h3>Revenue by Month</h3>

<table>
  <thead>
    <tr>
      <th>Month</th>
      <th>Total</th>
    </tr>
  </thead>

  <tbody>
    <?php foreach (($revenueSeries ?? []) as $r): ?>
      <tr>
        <td><?= $r['ym'] ?></td>
        <td>$<?= number_format($r['total'], 2) ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<hr>

<h3>Top Sellers</h3>

<table>
  <thead>
    <tr>
      <th>Shop</th>
      <th>Revenue</th>
    </tr>
  </thead>

  <tbody>
    <?php foreach (($top ?? []) as $r): ?>
      <tr>
        <td><?= $r['seller_name'] ?? $r['shop_name'] ?></td>
        <td>$<?= number_format($r['total_sales'] ?? 0, 2) ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<hr>

<h3>Top Categories</h3>

<table>
  <thead>
    <tr>
      <th>Category</th>
      <th>Products</th>
    </tr>
  </thead>

  <tbody>
    <?php foreach (($topCats ?? []) as $r): ?>
      <tr>
        <td><?= $r['name'] ?></td>
        <td><?= $r['total'] ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

</body>
</html>