<?php require_once __DIR__ . '/../includes/config.php';
$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) die('Invalid');
$teachers = $mysqli->query("SELECT teacher_id, first_name, last_name FROM teachers ORDER BY last_name");
$rooms = $mysqli->query("SELECT room_id, name FROM rooms ORDER BY name");
$s = $mysqli->prepare("SELECT * FROM courses WHERE course_id=?");
$s->bind_param('i', $id);
$s->execute();
$course = $s->get_result()->fetch_assoc();
if (!$course) die('Not found');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $desc = trim($_POST['description']);
    $start = $_POST['start_date'] ?: null;
    $end = $_POST['end_date'] ?: null;
    $teacher = (int)$_POST['teacher_id'];
    $room = (int)$_POST['room_id'];
    $up = $mysqli->prepare("UPDATE courses SET name=?, description=?, start_date=?, end_date=?, teacher_id=?, room_id=? WHERE course_id=?");
    $up->bind_param('sssiiii', $name, $desc, $start, $end, $teacher, $room, $id);
    if ($up->execute()) {
        header('Location:view.php?id=' . $id);
        exit;
    } else $error = $up->error;
}
require_once __DIR__ . '/../includes/header.php'; ?><h1>Muokkaa kurssia</h1><?php if (!empty($error)): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?><form method="post" class="card p-3">
    <div class="mb-3"><label class="form-label">Nimi</label><input name="name" class="form-control" required value="<?= htmlspecialchars($course['name']) ?>"></div>
    <div class="mb-3"><label class="form-label">Kuvaus</label><textarea name="description" class="form-control"><?= htmlspecialchars($course['description']) ?></textarea></div>
    <div class="row">
        <div class="col mb-3"><label class="form-label">Alkupäivä</label><input type="date" name="start_date" class="form-control" value="<?= htmlspecialchars($course['start_date']) ?>"></div>
        <div class="col mb-3"><label class="form-label">Loppupäivä</label><input type="date" name="end_date" class="form-control" value="<?= htmlspecialchars($course['end_date']) ?>"></div>
    </div>
    <div class="mb-3"><label class="form-label">Opettaja</label><select name="teacher_id" class="form-control"><?php while ($t = $teachers->fetch_assoc()): ?><option value="<?= $t['teacher_id'] ?>" <?= $t['teacher_id'] == $course['teacher_id'] ? 'selected' : '' ?>><?= htmlspecialchars($t['first_name'] . ' ' . $t['last_name']) ?></option><?php endwhile; ?></select></div>
    <div class="mb-3"><label class="form-label">Tila</label><select name="room_id" class="form-control"><?php while ($r = $rooms->fetch_assoc()): ?><option value="<?= $r['room_id'] ?>" <?= $r['room_id'] == $course['room_id'] ? 'selected' : '' ?>><?= htmlspecialchars($r['name']) ?></option><?php endwhile; ?></select></div><button class="btn btn-primary">Tallenna</button> <a class="btn btn-secondary" href="view.php?id=<?= $id ?>">Peruuta</a>
</form><?php require_once __DIR__ . '/../includes/footer.php'; ?>
