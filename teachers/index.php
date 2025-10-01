<?php require_once __DIR__ . '/../includes/config.php';
$page_title = 'Opettajat';
require_once __DIR__ . '/../includes/header.php';
$res = $mysqli->query("SELECT teacher_id, first_name, last_name, subject FROM teachers ORDER BY last_name"); ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Opettajat</h1><a class="btn btn-success" href="add.php">Lisää opettaja</a>
</div>
<div class="card p-3">
    <table class="table table-striped table-small">
        <thead>
            <tr>
                <th>Nimi</th>
                <th>Aine</th>
                <th></th>
            </tr>
        </thead>
        <tbody><?php while ($r = $res->fetch_assoc()): ?><tr>
                    <td><?= htmlspecialchars($r['first_name'] . ' ' . $r['last_name']) ?></td>
                    <td><?= htmlspecialchars($r['subject']) ?></td>
                    <td><a class="btn btn-sm btn-primary" href="view.php?id=<?= $r['teacher_id'] ?>">Näytä</a> <a class="btn btn-sm btn-secondary" href="edit.php?id=<?= $r['teacher_id'] ?>">Muokkaa</a> <a class="btn btn-sm btn-danger" href="delete.php?id=<?= $r['teacher_id'] ?>" onclick="return confirm('Poista opettaja?')">Poista</a></td>
                </tr><?php endwhile; ?></tbody>
    </table>
</div><?php require_once __DIR__ . '/../includes/footer.php'; ?>
