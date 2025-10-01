<?php require_once __DIR__ . '/../includes/config.php';
$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) header('Location:index.php');
$d = $mysqli->prepare("DELETE FROM courses WHERE course_id=?");
$d->bind_param('i', $id);
$d->execute();
header('Location:index.php');
exit;
