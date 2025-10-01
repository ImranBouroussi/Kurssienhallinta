<?php require_once __DIR__ . '/../includes/config.php';
$teachers = $mysqli->query("SELECT teacher_id, first_name, last_name FROM teachers ORDER BY last_name");
$rooms = $mysqli->query("SELECT room_id, name FROM rooms ORDER BY name");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $desc = trim($_POST['description']);
    $start = $_POST['start_date'] ?: null;
    $end = $_POST['end_date'] ?: null;
    $teacher = (int)$_POST['teacher_id'];
    $room = (int)$_POST['room_id'];
    $ins = $mysqli->prepare("INSERT INTO courses (name,description,start_date,end_date,teacher_id,room_id) VALUES (?,?,?,?,?,?)");
    $ins->bind_param('sssiii', $name, $desc, $start, $end, $teacher, $room);
    if ($ins->execute()) {
        header('Location:index.php');
        exit;
    } else $error = $ins->error;
}
require_once __DIR__ . '/../includes/header.php'; ?><h1>Lisää kurssi</h1><?php if (!empty($error)): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?><form method="post" class="card p-3">
    <div class="mb-3"><label class="form-label">Nimi</label><input name="name" class="form-control" required></div>
    <div class="mb-3"><label class="form-label">Kuvaus</label><textarea name="description" class="form-control"></textarea></div>
    <div class="row">
        <div class="col mb-3"><label class="form-label">Alkupäivä</label><input type="date" name="start_date" class="form-control"></div>
        <div class="col mb-3"><label class="form-label">Loppupäivä</label><input type="date" name="end_date" class="form-control"></div>
    </div>
    <div class="mb-3"><label class="form-label">Opettaja</label><select name="teacher_id" class="form-control"><?php while ($t = $teachers->fetch_assoc()): ?><option value="<?= $t['teacher_id'] ?>"><?= htmlspecialchars($t['first_name'] . ' ' . $t['last_name']) ?></option><?php endwhile; ?></select></div>
    <div class="mb-3"><label class="form-label">Tila</label><select name="room_id" class="form-control"><?php while ($r = $rooms->fetch_assoc()): ?><option value="<?= $r['room_id'] ?>"><?= htmlspecialchars($r['name']) ?></option><?php endwhile; ?></select></div><button class="btn btn-primary">Tallenna</button> <a class="btn btn-secondary" href="index.php">Peruuta</a>
</form><?php require_once __DIR__ . '/../includes/footer.php'; ?>
