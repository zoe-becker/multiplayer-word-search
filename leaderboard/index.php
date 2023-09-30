<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard</title>
    <link rel="stylesheet" type="text/css" href="leaderboard-styles.css">
</head>
<body>
    <div class="container">
        <div class="leaderboard">
            <h1>All-Time Leaderboard</h1>
            
        </div>
        <!-- Additional containers for player data -->
        <?php
        for ($i = 1; $i <= 5; $i++) {
            echo "<div class='player-box'>
                    <p>Rank {$i}.</p>
                    <p> Player {$i}</p>
                    <p>Score: 100{$i}</p>
                </div>";
        }
        ?>
    </div>
</body>
</html>