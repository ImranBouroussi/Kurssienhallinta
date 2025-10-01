<?php require_once __DIR__ . '/../includes/config.php';
$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) die('Invalid');
$sql = "SELECT c.*, t.first_name AS t_fn, t.last_name AS t_ln, r.name AS room_name, r.capacity FROM courses c JOIN teachers t ON c.teacher_id=t.teacher_id JOIN rooms r ON c.room_id=r.room_id WHERE c.course_id=?";
$s = $mysqli->prepare($sql);
$s->bind_param('i', $id);
$s->execute();
$course = $s->get_result()->fetch_assoc();
if (!$course) die('Not found');
$studentsQ = $mysqli->prepare("SELECT s.student_id,s.first_name,s.last_name,s.year_group FROM enrollments e JOIN students s ON e.student_id=s.student_id WHERE e.course_id=? ORDER BY s.last_name");
$studentsQ->bind_param('i', $id);
$studentsQ->execute();
$students = $studentsQ->get_result();
$countQ = $mysqli->prepare("SELECT COUNT(*) AS cnt FROM enrollments WHERE course_id=?");
$countQ->bind_param('i', $id);
$countQ->execute();
$count = $countQ->get_result()->fetch_assoc()['cnt'];
require_once __DIR__ . '/../includes/header.php'; ?><h1><?= htmlspecialchars($course['name']) ?></h1>
<p><?= nl2br(htmlspecialchars($course['description'])) ?></p>
<p><strong>Alku:</strong> <?= htmlspecialchars($course['start_date']) ?> — <strong>Loppu:</strong> <?= htmlspecialchars($course['end_date']) ?></p>
<p><strong>Opettaja:</strong> <?= htmlspecialchars($course['t_fn'] . ' ' . $course['t_ln']) ?></p>
<p><strong>Tila:</strong> <?= htmlspecialchars($course['room_name']) ?> (kapasiteetti <?= (int)$course['capacity'] ?>)</p>
<h3>Ilmoittautuneet opiskelijat (<?= $count ?>)</h3><?php if ($count > $course['capacity']): ?><div class="alert alert-warning">⚠️ Huomio: opiskelijoita enemmän kuin tilan kapasiteetti!</div><?php endif; ?><table class="table table-striped">
    <thead>
        <tr>
            <th>Nimi</th>
            <th>Vuosikurssi</th>
            <th></th>
        </tr>
    </thead>
    <tbody><?php while ($s = $students->fetch_assoc()): ?><tr>
                <td><a href="/kurssihallinta_full/students/view.php?id=<?= $s['student_id'] ?>"><?= htmlspecialchars($s['first_name'] . ' ' . $s['last_name']) ?></a></td>
                <td><?= (int)$s['year_group'] ?></td>
                <td><a class="btn btn-sm btn-danger" href="/kurssihallinta_full/enrollments/delete.php?id=<?= $s['student_id'] ?>&course_id=<?= $id ?>" onclick="return confirm('Poista ilmoittautuminen?')">Poista</a></td>
            </tr><?php endwhile; ?></tbody>
</table><a class="btn btn-secondary" href="index.php">Takaisin</a><?php require_once __DIR__ . '/../includes/footer.php'; ?>
