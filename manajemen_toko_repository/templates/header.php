<?php
require_once __DIR__ . '/../config/database.php';
require_login();

$pageTitle = $pageTitle ?? 'Manajemen Toko';
$activePage = $activePage ?? '';
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($pageTitle); ?> | Manajemen Toko</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="<?= BASE_URL; ?>assets/css/style.css" rel="stylesheet">
</head>
<body>
    <div class="app-layout">
