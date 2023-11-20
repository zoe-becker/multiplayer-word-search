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

                function leaderboardTheme($theme) {
                    global $pdo;
                    $data = new stdClass();
                
                    // Fetch for multiplayer mode
                    $multiplayerQuery = $theme == "none" ? 
                        "SELECT player AS name, score, time_stamp FROM all_time_lb WHERE mode = 'multiplayer' ORDER BY score DESC LIMIT 5" :
                        "SELECT player AS name, score, time_stamp FROM all_time_lb WHERE theme= ? AND mode = 'multiplayer' ORDER BY score DESC LIMIT 5";
                
                    $stmt = $theme == "none" ? $pdo->query($multiplayerQuery) : $pdo->prepare($multiplayerQuery);
                    if ($theme != "none") {
                        $stmt->execute([$theme]);
                    }
                    $data->multiplayerScores = $stmt->fetchAll(PDO::FETCH_OBJ);
                
                    // Fetch for time attack mode
                    $timeAttackQuery = $theme == "none" ? 
                    "SELECT player AS name, score, time_stamp FROM all_time_lb WHERE mode = 'timeattack' AND time_stamp >= DATE_SUB(NOW(), INTERVAL 1 WEEK) ORDER BY score DESC LIMIT 5" :
                    "SELECT player AS name, score, time_stamp FROM all_time_lb WHERE theme= ? AND mode = 'timeattack' AND time_stamp >= DATE_SUB(NOW(), INTERVAL 1 WEEK) ORDER BY score DESC LIMIT 5";
                
                    $stmt = $theme == "none" ? $pdo->query($timeAttackQuery) : $pdo->prepare($timeAttackQuery);
                    if ($theme != "none") {
                        $stmt->execute([$theme]);
                    }
                    $data->timeAttackScores = $stmt->fetchAll(PDO::FETCH_OBJ);
                
                    // Display results
                    displayScores($data->multiplayerScores, "Multiplayer");
                    displayScores($data->timeAttackScores, "Time-Attack");
                }
                
                function displayScores($scores, $modeTitle) {
                    echo "<div class='{$modeTitle}-container'>";
                    echo "<h3>{$modeTitle} Scores</h3>";
                    if (!empty($scores) && is_array($scores)) {
                        echo "<ul>";
                        foreach ($scores as $index => $player) {
                            $rank = $index + 1;
                            $playerName = htmlspecialchars($player->name);
                            echo "<li>";
                            echo "<div class='player-container highlight-hover'>";
                            echo "<div class='flex-box rank-name'>";
                            echo "<span class='rank'>Rank {$rank}: </span>";
                            echo "<span class='player'>{$playerName}</span>";
                            echo "</div>";
                            echo "<div class='flex-box score'>";
                            echo "<span class='score'>Score: {$player->score}</span>";
                            echo "</div>";
                            echo "</div>";
                            echo "</li>";
                        }
                        echo "</ul>";
                    } else {
                        echo "<p>No data available.</p>";
                    }
                    echo "</div>";
                }
                
                
                ?>

