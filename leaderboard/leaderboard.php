<?php
                require_once '../database/db_connect.php';
                

                if (isset($_GET['theme'])) {
                    $theme = $_GET['theme'];
                    $themeFiles = glob('../themes/*.json'); // Adjust the path to your themes directory
                
                    $availableThemes = [];
                    foreach ($themeFiles as $file) {
                        $themeName = basename($file, '.json');
                        // Exclude unwanted themes
                        if (!in_array($themeName, ['timeattack'])) {
                            $availableThemes[] = $themeName;
                        }
                        
                    }
                    
                    if (in_array($theme, $availableThemes)) {
                        leaderboardTheme($theme);
                        
                    } else if ($theme == 'all-time') {
                        leaderboardTheme('none');
                    }
                }

                function leaderboardTheme($theme){

                    global $pdo;
                    $stmt= "";
                    if ($theme == "none") {
                        $query = "SELECT player AS name, score, time_stamp FROM all_time_lb WHERE mode = 'multiplayer' ORDER BY score DESC LIMIT 5";
                        $stmt = $pdo->query($query);
                    } else {
                        $stmt = $pdo->prepare("SELECT player AS name, score, time_stamp FROM all_time_lb WHERE theme= ? AND mode = 'multiplayer' ORDER BY score DESC LIMIT 5");
                        $stmt->execute([$theme]);
                    }
                    
                    $top_scores = $stmt->fetchAll(PDO::FETCH_OBJ);
                            $data = new stdClass();
                            $data->topPlayers = $top_scores;
                            $pdo = null;
                
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
                            $pdo = null;

                }
                
                ?>

