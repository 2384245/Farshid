<?php
include("db.php");

$id = (int)$_GET['id'];

$sql = "SELECT * FROM videogames WHERE game_id = $id";
$result = mysqli_query($mysqli, $sql);
$game = mysqli_fetch_assoc($result);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Game Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>

<body class="bg-light">
<div class="container mt-5">

    <?php if (!$game): ?>
        <div class="alert alert-danger">Game not found.</div>
    <?php else: ?>
        <h1 class="mb-4"><?= htmlspecialchars($game['game_name']) ?></h1>

        <ul class="list-group">
            <li class="list-group-item"><strong>Rating:</strong> <?= htmlspecialchars($game['rating']) ?></li>
            <li class="list-group-item"><strong>Released:</strong> <?= htmlspecialchars($game['released_date']) ?></li>
        </ul>
    <?php endif; ?>

    <a href="list-games.php" class="btn btn-primary mt-3">Back to all games</a>

</div>
</body>
</html>