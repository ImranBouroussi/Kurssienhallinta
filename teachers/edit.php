<?php require_once __DIR__ . '/../includes/config.php';
$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) die('Invalid');
$s = $mysqli->prepare("SELECT * FROM teachers WHERE teacher_id=?");
$s->bind_param('i', $id);
$s->execute();
$t = $s->get_result()->fetch_assoc();
if (!$t) die('Not found');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $f = trim($_POST['first_name']);
    $l = trim($_POST['last_name']);
    $suj = trim($_POST['subject']);
    $up = $mysqli->prepare("UPDATE teachers SET first_name=?, last_name=?, subject=? WHERE teacher_id=?");
    $up->bind_param('sssi', $f, $l, $suj, $id);
    if ($up->execute()) {
        header('Location:view.php?id=' . $id);
        exit;
    } else $error = $up->error;
}
require_once __DIR__ . '/../includes/header.php'; ?><h1>Muokkaa opettajaa</h1><?php if (!empty($error)): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?><form method="post" class="card p-3">
    <div class="mb-3"><label class="form-label">Etunimi</label><input name="first_name" class="form-control" required value="<?= htmlspecialchars($t['first_name']) ?>"></div>
    <div class="mb-3"><label class="form-label">Sukunimi</label><input name="last_name" class="form-control" required value="<?= htmlspecialchars($t['last_name']) ?>"></div>
    <div class="mb-3"><label class="form-label">Aine</label><input name="subject" class="form-control" value="<?= htmlspecialchars($t['subject']) ?>"></div><button class="btn btn-primary">Tallenna</button> <a class="btn btn-secondary" href="view.php?id=<?= $id ?>">Peruuta</a>
</form><?php require_once __DIR__ . '/../includes/footer.php'; ?>
