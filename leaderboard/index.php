<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard</title>
    <link rel="stylesheet" type="text/css" href="leaderboard-styles.css">
    <script src="leaderboard.js"></script>
</head>
<body>
    <div class="container">
        <div class="leaderboard">
            <h1>All-Time Leaderboard</h1>
        </div>
        <!-- Leaderboard container to display top scores from top_scores.json -->
        <div class="leaderboard">
            <ol>
                <?php
                // Read and parse top_scores.json
                
                $query = "SELECT player AS name, score, date FROM all_time_lb ORDER BY score DESC LIMIT 5";
                $stmt = $pdo->query($query);
                $top_scores = $stmt->fetchAll(PDO::FETCH_OBJ);
                //$json = file_get_contents('top_scores.json');
                //$data = json_decode($json);

                // Check if data is not empty and is an array
                if (!empty($data) && is_array($data->topPlayers)) {
                    // Display the top 5 players
                    foreach (array_slice($data->topPlayers, 0, 5) as $index => $player) {
                        $rank = $index + 1;
                        $playerName = htmlspecialchars($player->name);
                        // Open a flex container for each player
                        echo "<li>";
                        echo "<div class='player-container highlight-hover'>";

                        // Flexbox for Rank and Name
                        echo "<div class='flex-box rank-name'>";
                        echo "<span class='rank'>Rank {$rank}: </span>";
                        echo "<span class='player'>{$playerName}</span>";
                        echo "</div>";

                        // Flexbox for Score
                        echo "<div class='flex-box score'>";
                        echo "<span class='score'>Score: {$player->score}</span>";
                        echo "</div>";

                        // Close the flex container for each player
                        echo "</div>";
                        echo "</li>";
    }
                } else {
                    echo "<li>No data available.</li>";
                }
                ?>
            </ol>
        </div>
    </div>
</body>
</html>