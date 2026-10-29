<?php
include("db.php");

// Get search keyword
$keywords = $_POST['keywords'] ?? '';

// Sorting
$sort = $_GET['sort'] ?? 'released_date';
$allowedSort = ['game_name','rating','released_date'];
if (!in_array($sort, $allowedSort)) $sort = 'released_date';

// Rating filter
$ratingFilter = $_GET['rating'] ?? '';
$ratingSQL = $ratingFilter ? "AND rating = '$ratingFilter'" : '';

// Pagination
$resultsPerPage = 5;
$page = $_GET['page'] ?? 1;
$offset = ($page - 1) * $resultsPerPage;

// Count total results
$countSQL = "SELECT COUNT(*) AS total FROM videogames
             WHERE game_name LIKE '%$keywords%' $ratingSQL";
$countResult = mysqli_query($mysqli, $countSQL);
$totalRows = mysqli_fetch_assoc($countResult)['total'];
$totalPages = ceil($totalRows / $resultsPerPage);

// Main query
$sql = "SELECT * FROM videogames
        WHERE game_name LIKE '%$keywords%' $ratingSQL
        ORDER BY $sort
        LIMIT $resultsPerPage OFFSET $offset";

$results = mysqli_query($mysqli, $sql);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Results</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <h1 class="mb-4">Search Results for: <?= htmlspecialchars($keywords) ?></h1>

    <!-- Sorting buttons -->
    <div class="mb-3">
        <a href="?sort=game_name&rating=<?= $ratingFilter ?>&page=1" class="btn btn-secondary">Sort by Name</a>
        <a href="?sort=rating&rating=<?= $ratingFilter ?>&page=1" class="btn btn-secondary">Sort by Rating</a>
        <a href="?sort=released_date&rating=<?= $ratingFilter ?>&page=1" class="btn btn-secondary">Sort by Date</a>
    </div>

    <!-- Rating filter -->
    <form method="get" class="mb-3">
        <label>Filter by Rating:</label>
        <select name="rating" class="form-select" style="width:200px;">
            <option value="">All</option>
            <option value="10">10</option>
            <option value="9">9</option>
            <option value="8">8</option>
        </select>
        <button class="btn btn-primary mt-2">Apply Filter</button>
    </form>

    <!-- Results table -->
    <?php if ($totalRows == 0): ?>
        <div class="alert alert-danger">No results found.</div>
    <?php else: ?>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Game Name</th>
                    <th>Rating</th>
                    <th>Released</th>
                </tr>
            </thead>

            <tbody>
                <?php while ($row = mysqli_fetch_assoc($results)): ?>
                <tr>
                    <td><?= htmlspecialchars($row['game_name']) ?></td>
                    <td><?= htmlspecialchars($row['rating']) ?></td>
                    <td><?= htmlspecialchars($row['released_date']) ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Pagination -->
        <nav>
            <ul class="pagination">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                        <a class="page-link"
                           href="?sort=<?= $sort ?>&rating=<?= $ratingFilter ?>&page=<?= $i ?>">
                           <?= $i ?>
                        </a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    <?php endif; ?>

    <a href="list-games.php" class="btn btn-primary">Back to all games</a>

</div>

</body>
</html>