<?php require_once __DIR__ . '/../includes/config.php';
$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) die('Invalid');
$s = $mysqli->prepare("SELECT * FROM rooms WHERE room_id=?");
$s->bind_param('i', $id);
$s->execute();
$room = $s->get_result()->fetch_assoc();
if (!$room) die('Not found');
$csql = "SELECT c.course_id,c.name,c.start_date,c.end_date,t.first_name,t.last_name,(SELECT COUNT(*) FROM enrollments e WHERE e.course_id=c.course_id) AS participants FROM courses c JOIN teachers t ON c.teacher_id=t.teacher_id WHERE c.room_id=? ORDER BY c.start_date";
$cs = $mysqli->prepare($csql);
$cs->bind_param('i', $id);
$cs->execute();
$courses = $cs->get_result();
require_once __DIR__ . '/../includes/header.php'; ?><h1><?= htmlspecialchars($room['name']) ?></h1>
<p>Kapasiteetti: <?= (int)$room['capacity'] ?></p>
<h3>Kurssit tilassa</h3>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Nimi</th>
            <th>Opettaja</th>
            <th>Aloitus</th>
            <th>Loppu</th>
            <th>Osallistujat</th>
        </tr>
    </thead>
    <tbody><?php while ($c = $courses->fetch_assoc()): ?><tr>
                <td><a href="/kurssienhallinta/courses/view.php?id=<?= $c['course_id'] ?>"><?= htmlspecialchars($c['name']) ?></a></td>
                <td><?= htmlspecialchars($c['first_name'] . ' ' . $c['last_name']) ?></td>
                <td><?= htmlspecialchars($c['start_date']) ?></td>
                <td><?= htmlspecialchars($c['end_date']) ?></td>
                <td><?= (int)$c['participants'] ?> <?php if ($c['participants'] > $room['capacity']): ?><span class="warning-icon" title="ylittää kapasiteetin"> ⚠️</span><?php endif; ?></td>
            </tr><?php endwhile; ?></tbody>
</table><a class="btn btn-secondary" href="index.php">Takaisin</a><?php require_once __DIR__ . '/../includes/footer.php'; ?>
