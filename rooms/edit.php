<?php require_once __DIR__ . '/../includes/config.php';
$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) die('Invalid');
$s = $mysqli->prepare("SELECT * FROM rooms WHERE room_id=?");
$s->bind_param('i', $id);
$s->execute();
$room = $s->get_result()->fetch_assoc();
if (!$room) die('Not found');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $n = trim($_POST['name']);
    $cap = (int)$_POST['capacity'];
    $up = $mysqli->prepare("UPDATE rooms SET name=?, capacity=? WHERE room_id=?");
    $up->bind_param('sii', $n, $cap, $id);
    if ($up->execute()) {
        header('Location:view.php?id=' . $id);
        exit;
    } else $error = $up->error;
}
require_once __DIR__ . '/../includes/header.php'; ?><h1>Muokkaa tilaa</h1><?php if (!empty($error)): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?><form method="post" class="card p-3">
    <div class="mb-3"><label class="form-label">Nimi</label><input name="name" class="form-control" required value="<?= htmlspecialchars($room['name']) ?>"></div>
    <div class="mb-3"><label class="form-label">Kapasiteetti</label><input type="number" min="0" name="capacity" class="form-control" required value="<?= (int)$room['capacity'] ?>"></div><button class="btn btn-primary">Tallenna</button> <a class="btn btn-secondary" href="view.php?id=<?= $id ?>">Peruuta</a>
</form><?php require_once __DIR__ . '/../includes/footer.php'; ?>
