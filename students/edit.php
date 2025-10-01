<?php
require_once __DIR__ . '/../includes/config.php';
$id = (int)($_GET['id'] ?? 0); if ($id<=0) die('Invalid id');
$stmt = $mysqli->prepare("SELECT * FROM students WHERE student_id = ?"); $stmt->bind_param('i',$id); $stmt->execute(); $student = $stmt->get_result()->fetch_assoc(); if (!$student) die('Not found');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first = trim($_POST['first_name']); $last = trim($_POST['last_name']); $birth = $_POST['birthdate'] ?: null; $year = (int)$_POST['year_group'];
    $up = $mysqli->prepare("UPDATE students SET first_name=?, last_name=?, birthdate=?, year_group=? WHERE student_id=?"); $up->bind_param('sssii',$first,$last,$birth,$year,$id);
    if ($up->execute()) { header('Location: view.php?id='.$id); exit; } else { $error = $up->error; }
}
require_once __DIR__ . '/../includes/header.php';
?>
<h1>Muokkaa opiskelijaa</h1>
<?php if (!empty($error)): ?><div class="alert alert-danger"><?=htmlspecialchars($error)?></div><?php endif; ?>
<form method="post" class="card p-3">
  <div class="mb-3"><label class="form-label">Etunimi</label><input name="first_name" class="form-control" required value="<?=htmlspecialchars($student['first_name'])?>"></div>
  <div class="mb-3"><label class="form-label">Sukunimi</label><input name="last_name" class="form-control" required value="<?=htmlspecialchars($student['last_name'])?>"></div>
  <div class="mb-3"><label class="form-label">Syntymäpäivä</label><input type="date" name="birthdate" class="form-control" value="<?=htmlspecialchars($student['birthdate'])?>"></div>
  <div class="mb-3"><label class="form-label">Vuosikurssi</label><input type="number" min="1" max="3" name="year_group" class="form-control" required value="<?= (int)$student['year_group'] ?>"></div>
  <button class="btn btn-primary">Tallenna</button>
  <a class="btn btn-secondary" href="view.php?id=<?=$id?>">Peruuta</a>
</form>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
