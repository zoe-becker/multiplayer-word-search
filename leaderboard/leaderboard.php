<?php
                require_once '../database/db_connect.php';

                if (isset($_GET['theme'])) {
                    switch ($_GET['theme']) {
                        case 'all-time':
                            leaderboardTheme('none');
                            break;
                        case 'animals':
                            leaderboardTheme('animals');
                            break;
                        case 'christmas':
                            leaderboardTheme('christmas');
                            break;
                        case 'halloween':
                            leaderboardTheme('halloween');
                            break;
                        case 'nicki':
                            leaderboardTheme('nicki');
                            break;
                        case 'valentine':
                            leaderboardTheme('valentine');
                            break;
                        case 'thanksgiving':
                            leaderboardTheme('thanksgiving');
                            break;
                    }
                }

                function leaderboardTheme($theme){

                    global $pdo;
                    $stmt= "";
                    if ($theme == "none") {
                        $query = "SELECT player AS name, score, time_stamp FROM all_time_lb ORDER BY score DESC LIMIT 5";
                        $stmt = $pdo->query($query);
                    } else {
                        $stmt = $pdo->prepare("SELECT player AS name, score, time_stamp FROM all_time_lb WHERE theme= ? ORDER BY score DESC LIMIT 5");
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

