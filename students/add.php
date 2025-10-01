<?php
require_once __DIR__ . '/../includes/config.php';
$page_title = 'Lisää opiskelija';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first = trim($_POST['first_name']); $last = trim($_POST['last_name']);
    $birth = $_POST['birthdate'] ?: null; $year = (int)$_POST['year_group'];
    $stmt = $mysqli->prepare("INSERT INTO students (first_name,last_name,birthdate,year_group) VALUES (?,?,?,?)");
    $stmt->bind_param('sssi',$first,$last,$birth,$year);
    if ($stmt->execute()) { header('Location: index.php'); exit; } else { $error = $stmt->error; }
}
require_once __DIR__ . '/../includes/header.php';
?>
<h1>Lisää opiskelija</h1>
<?php if (!empty($error)): ?><div class="alert alert-danger"><?=htmlspecialchars($error)?></div><?php endif; ?>
<form method="post" class="card p-3">
  <div class="mb-3"><label class="form-label">Etunimi</label><input name="first_name" class="form-control" required></div>
  <div class="mb-3"><label class="form-label">Sukunimi</label><input name="last_name" class="form-control" required></div>
  <div class="mb-3"><label class="form-label">Syntymäpäivä</label><input type="date" name="birthdate" class="form-control"></div>
  <div class="mb-3"><label class="form-label">Vuosikurssi (1-3)</label><input type="number" min="1" max="3" name="year_group" class="form-control" required></div>
  <button class="btn btn-primary">Tallenna</button>
  <a class="btn btn-secondary" href="index.php">Peruuta</a>
</form>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
