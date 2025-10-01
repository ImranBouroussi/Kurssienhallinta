<?php require_once __DIR__ . '/../includes/config.php';
$students = $mysqli->query("SELECT student_id, first_name, last_name FROM students ORDER BY last_name");
$courses = $mysqli->query("SELECT course_id, name FROM courses ORDER BY name");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student = (int)$_POST['student_id'];
    $course = (int)$_POST['course_id'];
    $stmt = $mysqli->prepare("INSERT INTO enrollments (student_id, course_id) VALUES (?,?)");
    $stmt->bind_param('ii', $student, $course);
    if ($stmt->execute()) {
        header('Location:/kurssihallinta_full/courses/view.php?id=' . $course);
        exit;
    } else $error = $stmt->error;
}
require_once __DIR__ . '/../includes/header.php'; ?><h1>Ilmoita opiskelija kurssille</h1><?php if (!empty($error)): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?><form method="post" class="card p-3">
    <div class="mb-3"><label class="form-label">Opiskelija</label><select name="student_id" class="form-control"><?php while ($s = $students->fetch_assoc()): ?><option value="<?= $s['student_id'] ?>"><?= htmlspecialchars($s['first_name'] . ' ' . $s['last_name']) ?></option><?php endwhile; ?></select></div>
    <div class="mb-3"><label class="form-label">Kurssi</label><select name="course_id" class="form-control"><?php while ($c = $courses->fetch_assoc()): ?><option value="<?= $c['course_id'] ?>"><?= htmlspecialchars($c['name']) ?></option><?php endwhile; ?></select></div><button class="btn btn-primary">Ilmoita</button> <a class="btn btn-secondary" href="/kurssihallinta_full/courses/index.php">Peruuta</a>
</form><?php require_once __DIR__ . '/../includes/footer.php'; ?>
