<?php require_once __DIR__ . '/../includes/config.php';
$page_title = 'Tilat';
require_once __DIR__ . '/../includes/header.php';
$res = $mysqli->query("SELECT * FROM rooms ORDER BY name"); ?><div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Tilat</h1><a class="btn btn-success" href="add.php">Lisää tila</a>
</div>
<div class="card p-3">
    <table class="table table-striped table-small">
        <thead>
            <tr>
                <th>Nimi</th>
                <th>Kapasiteetti</th>
                <th></th>
            </tr>
        </thead>
        <tbody><?php while ($r = $res->fetch_assoc()): ?><tr>
                    <td><?= htmlspecialchars($r['name']) ?></td>
                    <td><?= (int)$r['capacity'] ?></td>
                    <td><a class="btn btn-sm btn-primary" href="view.php?id=<?= $r['room_id'] ?>">Näytä</a> <a class="btn btn-sm btn-secondary" href="edit.php?id=<?= $r['room_id'] ?>">Muokkaa</a> <a class="btn btn-sm btn-danger" href="delete.php?id=<?= $r['room_id'] ?>" onclick="return confirm('Poista tila?')">Poista</a></td>
                </tr><?php endwhile; ?></tbody>
    </table>
</div><?php require_once __DIR__ . '/../includes/footer.php'; ?>
