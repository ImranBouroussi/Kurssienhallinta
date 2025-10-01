<?php
require_once __DIR__ . '/../includes/config.php';
$id = (int)($_GET['id'] ?? 0); if ($id<=0) header('Location:index.php');
$del = $mysqli->prepare("DELETE FROM students WHERE student_id = ?"); $del->bind_param('i',$id); $del->execute(); header('Location: index.php'); exit;
