<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard</title>
    <link rel="stylesheet" type="text/css" href="leaderboard-styles.css">
    <script src="https://unpkg.com/htmx.org@1.9.8" integrity="sha384-rgjA7mptc2ETQqXoYC3/zJvkU7K/aP44Y+z7xQuJiVnB/422P/Ak+F/AqFR7E4Wr" crossorigin="anonymous"></script>

</head>
<body>
    <div class="container">
        <div class="leaderboard">
            <h1>Leaderboards</h1>
        </div>
        <!-- HTMX Tabs for Leaderboards -->
        <div id="leaderboard-tabs" hx-target="#leaderboard-content" role="tablist"  >
            <button role="tab" aria-controls="leaderboard-content" aria-selected="true" hx-get="leaderboard.php?theme=all-time"  >All-Time</button>
            <button role="tab" aria-controls="leaderboard-content" aria-selected="false" hx-get="leaderboard.php?theme=animals">Animals</button>
            <button role="tab" aria-controls="leaderboard-content" aria-selected="false" hx-get="leaderboard.php?theme=christmas">Christmas</button>
            <button role="tab" aria-controls="leaderboard-content" aria-selected="false" hx-get="leaderboard.php?theme=halloween">Halloween</button>
            <button role="tab" aria-controls="leaderboard-content" aria-selected="false" hx-get="leaderboard.php?theme=nicki">Nicki</button>
            <button role="tab" aria-controls="leaderboard-content" aria-selected="false" hx-get="leaderboard.php?theme=valentine">Valentine's</button>
            <button role="tab" aria-controls="leaderboard-content" aria-selected="false" hx-get="leaderboard.php?theme=thanksgiving">Thanksgiving</button>
            <!-- Add more tabs as needed -->
        </div>
        
        <div class="scores-container">
            <div id="leaderboard-content" role="tabpanel" hx-get="leaderboard.php?theme=all-time" hx-trigger="load">
        <!-- Leaderboard content will be loaded here -->
        
        </div>
    </div>

        
</body>
</html>