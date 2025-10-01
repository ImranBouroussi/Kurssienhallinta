<?php require_once __DIR__ . '/../includes/config.php';
$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) die('Invalid');
$s = $mysqli->prepare("SELECT * FROM teachers WHERE teacher_id=?");
$s->bind_param('i', $id);
$s->execute();
$t = $s->get_result()->fetch_assoc();
if (!$t) die('Not found');
$c = $mysqli->prepare("SELECT c.course_id,c.name,c.start_date,c.end_date,r.name AS room_name FROM courses c JOIN rooms r ON c.room_id=r.room_id WHERE c.teacher_id=? ORDER BY c.start_date");
$c->bind_param('i', $id);
$c->execute();
$courses = $c->get_result();
$page_title = 'Opettaja';
require_once __DIR__ . '/../includes/header.php'; ?><h1><?= htmlspecialchars($t['first_name'] . ' ' . $t['last_name']) ?></h1>
<p>Aine: <?= htmlspecialchars($t['subject']) ?></p>
<h3>Vastuulliset kurssit</h3>
<ul><?php while ($co = $courses->fetch_assoc()): ?><li><a href="/kurssihallinta_full/courses/view.php?id=<?= $co['course_id'] ?>"><?= htmlspecialchars($co['name']) ?></a> — <?= htmlspecialchars($co['start_date']) ?> — <?= htmlspecialchars($co['end_date']) ?> (<?= htmlspecialchars($co['room_name']) ?>)</li><?php endwhile; ?></ul><a class="btn btn-secondary" href="index.php">Takaisin</a><?php require_once __DIR__ . '/../includes/footer.php'; ?>
