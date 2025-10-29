<?php require_once __DIR__ . '/../includes/config.php';
$student_id = (int)($_GET['id'] ?? 0);
$course_id = (int)($_GET['course_id'] ?? 0);
if ($student_id <= 0 || $course_id <= 0) header('Location:/kurssienhallinta/courses/index.php');
$d = $mysqli->prepare("DELETE FROM enrollments WHERE student_id=? AND course_id=?");
$d->bind_param('ii', $student_id, $course_id);
$d->execute();
header('Location:/kurssienhallinta/courses/view.php?id=' . $course_id);
exit;
