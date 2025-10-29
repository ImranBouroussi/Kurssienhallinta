<?php if (!isset($page_title)) $page_title = 'Kurssihallinta'; ?>
<!doctype html>
<html lang="fi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title><?=htmlspecialchars($page_title)?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="/kurssienhallinta/assets/style.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
  <div class="container-fluid">
    <a class="navbar-brand" href="/kurssienhallinta/index.php">Kurssihallinta</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navmenu">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navmenu">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="/kurssienhallinta/students/index.php">Opiskelijat</a></li>
        <li class="nav-item"><a class="nav-link" href="/kurssienhallinta/teachers/index.php">Opettajat</a></li>
        <li class="nav-item"><a class="nav-link" href="/kurssienhallinta/courses/index.php">Kurssit</a></li>
        <li class="nav-item"><a class="nav-link" href="/kurssienhallinta/rooms/index.php">Tilat</a></li>
        <li class="nav-item"><a class="nav-link" href="/kurssienhallinta/enrollments/add.php">Ilmoittautumiset</a></li>
      </ul>
    </div>
  </div>
</nav>
<main class="container mb-5">
