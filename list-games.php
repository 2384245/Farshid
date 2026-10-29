<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Video Games</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>

<body class="bg-red">

<div class="container mt-5">

    <h1 class="text-success mb-4">LIST OF ALL MY GAMES!!!</h1>

    <?php
    include("db.php");

    $sql = "SELECT * FROM videogames ORDER BY released_date";
    $results = mysqli_query($mysqli, $sql);
    ?>

    <!-- Search form -->
    <form action="search-game.php" method="post" class="mb-4">
        <div class="input-group">
            <input type="text"
                   name="keywords"
                   class="form-control"
                   placeholder="Search games..."
                   required>

            <button type="submit" class="btn btn-danger">Search</button>
        </div>
    </form>

    <!-- Games table -->
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover bg-white">
            <thead class="table-dark">
                <tr>
                    <th>Game Name</th>
                    <th>Rating</th>
                </tr>
            </thead>

            <tbody>
                <?php while ($a_row = mysqli_fetch_assoc($results)): ?>
                <tr>
                    <td>
                        <a href="game-details.php?id=<?= (int)$a_row['game_id'] ?>">
                            <?= htmlspecialchars($a_row['game_name']) ?>
                        </a>
                    </td>

                    <td><?= htmlspecialchars($a_row['rating']) ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</div>

</body>
</html>