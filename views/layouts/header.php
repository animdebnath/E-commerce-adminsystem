<?php $u = current_user(); ?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e(APP_NAME) ?> — Admin</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
</head>
<body>
<div class="app-shell">
  <aside class="sidebar">
    <div class="brand"><i class="fa-solid fa-store"></i> <span><?= e(APP_NAME) ?></span></div>
    <nav class="menu">
      <a href="<?= url('dashboard') ?>"><i class="fa-solid fa-gauge"></i> Dashboard</a>
      <a href="<?= url('sellers') ?>"><i class="fa-solid fa-shop"></i> Sellers</a>
      <a href="<?= url('categories') ?>"><i class="fa-solid fa-tags"></i> Categories</a>
      <a href="<?= url('users') ?>"><i class="fa-solid fa-users"></i> Users</a>
      <a href="<?= url('products') ?>"><i class="fa-solid fa-box"></i> Products</a>
      <a href="<?= url('orders') ?>"><i class="fa-solid fa-receipt"></i> Orders</a>
      <a href="<?= url('disputes') ?>"><i class="fa-solid fa-gavel"></i> Disputes</a>
      <a href="<?= url('commissions') ?>"><i class="fa-solid fa-percent"></i> Commissions</a>
      <a href="<?= url('coupons') ?>"><i class="fa-solid fa-ticket"></i> Coupons</a>
      <a href="<?= url('reports') ?>"><i class="fa-solid fa-chart-line"></i> Reports</a>
      <a href="<?= url('featured') ?>"><i class="fa-solid fa-star"></i> Featured</a>
      <a href="<?= url('announcements') ?>"><i class="fa-solid fa-bullhorn"></i> Announcements</a>
    </nav>
  </aside>
  <div class="main">
    <header class="topbar">
      <button class="btn btn-light d-md-none" id="sidebarToggle"><i class="fa-solid fa-bars"></i></button>
      <div class="topbar-title"><?= e($pageTitle ?? 'Dashboard') ?></div>
      <div class="topbar-right">
        <span class="text-muted me-3"><i class="fa-solid fa-user-shield"></i> <?= e($u['name']) ?></span>
        <a class="btn btn-outline-danger btn-sm" href="<?= url('auth/logout') ?>"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
      </div>
    </header>
    <main class="content">
      <?php if ($m = flash_get('success')): ?>
        <div class="alert alert-success"><i class="fa-solid fa-circle-check"></i> <?= e($m) ?></div>
      <?php endif; ?>
      <?php if ($m = flash_get('error')): ?>
        <div class="alert alert-danger"><i class="fa-solid fa-triangle-exclamation"></i> <?= e($m) ?></div>
      <?php endif; ?>
