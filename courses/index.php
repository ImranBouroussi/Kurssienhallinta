<?php require_once __DIR__ . '/../includes/config.php';
$page_title = 'Kurssit';
require_once __DIR__ . '/../includes/header.php';
$res = $mysqli->query("SELECT c.course_id,c.name,c.start_date,c.end_date,t.first_name AS tfn,t.last_name AS tln,r.name AS room_name FROM courses c JOIN teachers t ON c.teacher_id=t.teacher_id JOIN rooms r ON c.room_id=r.room_id ORDER BY c.start_date"); ?><div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Kurssit</h1><a class="btn btn-success" href="add.php">Lisää kurssi</a>
</div>
<div class="card p-3">
    <table class="table table-striped table-small">
        <thead>
            <tr>
                <th>Nimi</th>
                <th>Opettaja</th>
                <th>Tila</th>
                <th>Aloitus</th>
                <th></th>
            </tr>
        </thead>
        <tbody><?php while ($r = $res->fetch_assoc()): ?><tr>
                    <td><?= htmlspecialchars($r['name']) ?></td>
                    <td><?= htmlspecialchars($r['tfn'] . ' ' . $r['tln']) ?></td>
                    <td><?= htmlspecialchars($r['room_name']) ?></td>
                    <td><?= htmlspecialchars($r['start_date']) ?></td>
                    <td><a class="btn btn-sm btn-primary" href="view.php?id=<?= $r['course_id'] ?>">Näytä</a> <a class="btn btn-sm btn-secondary" href="edit.php?id=<?= $r['course_id'] ?>">Muokkaa</a> <a class="btn btn-sm btn-danger" href="delete.php?id=<?= $r['course_id'] ?>" onclick="return confirm('Poista kurssi?')">Poista</a></td>
                </tr><?php endwhile; ?></tbody>
    </table>
</div><?php require_once __DIR__ . '/../includes/footer.php'; ?>
