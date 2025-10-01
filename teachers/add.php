<?php require_once __DIR__ . '/../includes/config.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $f = trim($_POST['first_name']);
    $l = trim($_POST['last_name']);
    $s = trim($_POST['subject']);
    $stmt = $mysqli->prepare("INSERT INTO teachers (first_name,last_name,subject) VALUES (?,?,?)");
    $stmt->bind_param('sss', $f, $l, $s);
    if ($stmt->execute()) {
        header('Location:index.php');
        exit;
    } else $error = $stmt->error;
}
$page_title = 'Lisää opettaja';
require_once __DIR__ . '/../includes/header.php'; ?> <h1>Lisää opettaja</h1><?php if (!empty($error)): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?><form method="post" class="card p-3">
    <div class="mb-3"><label class="form-label">Etunimi</label><input name="first_name" class="form-control" required></div>
    <div class="mb-3"><label class="form-label">Sukunimi</label><input name="last_name" class="form-control" required></div>
    <div class="mb-3"><label class="form-label">Aine</label><input name="subject" class="form-control"></div><button class="btn btn-primary">Tallenna</button> <a class="btn btn-secondary" href="index.php">Peruuta</a>
</form><?php require_once __DIR__ . '/../includes/footer.php'; ?>
