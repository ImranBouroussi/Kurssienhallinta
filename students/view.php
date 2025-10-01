<?php
require_once __DIR__ . '/../includes/config.php';
$id = (int)($_GET['id'] ?? 0); if ($id<=0) die('Invalid id');
$stmt = $mysqli->prepare("SELECT * FROM students WHERE student_id = ?"); $stmt->bind_param('i',$id); $stmt->execute(); $student = $stmt->get_result()->fetch_assoc(); if (!$student) die('Not found');
$courses = $mysqli->prepare("SELECT c.course_id, c.name, c.start_date FROM courses c JOIN enrollments e ON e.course_id=c.course_id WHERE e.student_id = ? ORDER BY c.start_date"); $courses->bind_param('i',$id); $courses->execute(); $courses = $courses->get_result();
require_once __DIR__ . '/../includes/header.php';
?>
<h1><?=htmlspecialchars($student['first_name'].' '.$student['last_name'])?></h1>
<p>Syntymä: <?=htmlspecialchars($student['birthdate'])?> | Vuosikurssi: <?= (int)$student['year_group'] ?></p>
<h3>Ilmoittautuneet kurssit</h3>
<ul>
<?php while($c=$courses->fetch_assoc()): ?>
  <li><a href="/kurssihallinta_full/courses/view.php?id=<?=$c['course_id']?>"><?=htmlspecialchars($c['name'])?></a> — <?=htmlspecialchars($c['start_date'])?></li>
<?php endwhile; ?>
</ul>
<a class="btn btn-secondary" href="index.php">Takaisin</a>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
