<?php
require_once __DIR__ . '/config.php';
requireLogin();
?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $pageTitle ?? 'Admin' ?> — ZHIDI Tech Panel</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="assets/admin.css">
</head>
<body class="bg-gray-50 min-h-screen">
  <div class="flex min-h-screen">
    <?php include __DIR__ . '/sidebar.php'; ?>
    <div class="flex-1 flex flex-col">
      <header class="bg-white border-b border-gray-200 px-6 py-3 flex items-center justify-between">
        <h2 class="text-sm font-semibold text-gray-700"><?= $pageTitle ?? 'Dashboard' ?></h2>
        <div class="flex items-center gap-4">
          <span class="text-xs text-gray-400"><?= htmlspecialchars($_SESSION['username'] ?? 'Admin') ?></span>
          <a href="logout.php" class="text-xs text-red-500 hover:text-red-700 transition">Logout</a>
        </div>
      </header>
      <main class="flex-1 p-6">
        <?php $flash = getFlash(); if ($flash): ?>
          <div class="mb-4 px-4 py-3 rounded-lg text-sm font-medium <?= $flash['type'] === 'success' ? 'bg-green-50 border border-green-200 text-green-700' : 'bg-red-50 border border-red-200 text-red-700' ?>">
            <?= htmlspecialchars($flash['message']) ?>
          </div>
        <?php endif; ?>
