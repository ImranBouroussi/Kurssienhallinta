<?php
require_once __DIR__ . '/../includes/config.php';
$page_title = 'Opiskelijat';
require_once __DIR__ . '/../includes/header.php';
$res = $mysqli->query("SELECT student_id, first_name, last_name, year_group FROM students ORDER BY last_name, first_name");
?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h1>Opiskelijat</h1>
  <a class="btn btn-success" href="add.php">Lisää opiskelija</a>
</div>
<div class="card p-3">
<table class="table table-striped table-small mb-0">
  <thead><tr><th>Nimi</th><th>Vuosikurssi</th><th></th></tr></thead>
  <tbody>
  <?php while($r = $res->fetch_assoc()): ?>
  <tr>
    <td><?=htmlspecialchars($r['first_name'].' '.$r['last_name'])?></td>
    <td><?= (int)$r['year_group'] ?></td>
    <td>
      <a class="btn btn-sm btn-primary" href="view.php?id=<?=$r['student_id']?>">Näytä</a>
      <a class="btn btn-sm btn-secondary" href="edit.php?id=<?=$r['student_id']?>">Muokkaa</a>
      <a class="btn btn-sm btn-danger" href="delete.php?id=<?=$r['student_id']?>" onclick="return confirm('Poista opiskelija?')">Poista</a>
    </td>
  </tr>
  <?php endwhile; ?>
  </tbody>
</table>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
