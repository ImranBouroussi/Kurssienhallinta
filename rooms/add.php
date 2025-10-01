<?php require_once __DIR__ . '/../includes/config.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $n = trim($_POST['name']);
    $cap = (int)$_POST['capacity'];
    $s = $mysqli->prepare("INSERT INTO rooms (name,capacity) VALUES (?,?)");
    $s->bind_param('si', $n, $cap);
    if ($s->execute()) {
        header('Location:index.php');
        exit;
    } else $error = $s->error;
}
require_once __DIR__ . '/../includes/header.php'; ?><h1>Lisää tila</h1><?php if (!empty($error)): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?><form method="post" class="card p-3">
    <div class="mb-3"><label class="form-label">Nimi</label><input name="name" class="form-control" required></div>
    <div class="mb-3"><label class="form-label">Kapasiteetti</label><input type="number" min="0" name="capacity" class="form-control" required></div><button class="btn btn-primary">Tallenna</button> <a class="btn btn-secondary" href="index.php">Peruuta</a>
</form><?php require_once __DIR__ . '/../includes/footer.php'; ?>
