<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Game Search</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>

<body>
<div class="container mt-4">

    <h1>Game Search</h1>

    <form class="row g-3">
        <div class="col-md-6">
            <input
                type="text"
                class="form-control"
                id="searchBox"
                placeholder="Search for a game..."
            >
        </div>
    </form>

    <div id="results" class="mt-3"></div>

</div>

<script>
// Listen for typing in the search box
document.getElementById("searchBox").addEventListener("keyup", doSearch);

function doSearch() {

    const keywords = document.getElementById("searchBox").value.trim();

    fetch('https://mi-linux.wlv.ac.uk/~2384245/ajax/ajax.php?search=' + encodeURIComponent(keywords))

        .then(response => response.json())

        .then(data => {

            const results = document.getElementById("results");

            // Clear old results
            results.innerHTML = "";

            // No matching games
            if (data.length === 0) {
                results.innerHTML =
                    '<div class="alert alert-warning">No games found.</div>';
                return;
            }

            // Create Bootstrap list
            const list = document.createElement("ul");
            list.className = "list-group";

            data.forEach(game => {

                const item = document.createElement("li");
                item.className = "list-group-item";

                item.textContent = game.game_name;

                list.appendChild(item);
            });

            results.appendChild(list);
        })

        .catch(error => {
            document.getElementById("results").innerHTML =
                '<div class="alert alert-danger">Error loading results.</div>';

            console.error(error);
        });
}
</script>

</body>
</html>