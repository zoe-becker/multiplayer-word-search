
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lobby</title>
    <link rel="stylesheet" href="lobby.css">
    <script src="lobby.js"></script>
    <body>
        <div id = "outer-lobby-container">
            <div id="lobby-container">
                <div id="lobby-title">
                    <div id="lobby-title-info">Pre-Game Lobby</div>
                </div>
                <div id="lobby-playerlistandsettings">
                    <div id="host-settings-buttons">
                            <div id="word-search-grid" id="word-search-grid">
                                 <!-- The word search grid will be populated here -->
                                 <!-- START (4,5)->(4,9) to be green, THEMES (1,7)->(1,12) to be red, and HOW TO PLAY! (8,3)->(8,13) to be yellow.-->
                                <div class="row">
                                    <div class="cell">H</div><br>
                                    <div class="cell">E</div><br>
                                    <div class="cell">R</div><br>
                                    <div class="cell">D</div><br>
                                    <div class="cell">S</div><br>
                                    <div class="cell">N</div><br>
                                    <div class="cell">D</div><br>
                                    <div class="cell">V</div><br>
                                    <div class="cell">X</div><br>
                                    <div class="cell">M</div><br>
                                    <div class="cell">A</div><br>
                                    <div class="cell">E</div><br>
                                    <div class="cell">O</div><br>
                                    <div class="cell">V</div><br>
                                    <div class="cell">X</div><br>
                                </div>
                                <div class="row">
                                    <div class="cell" data-special-cell="settings">S</div>
                                    <div class="cell">E</div>
                                    <div class="cell">K</div>
                                    <div class="cell">E</div>
                                    <div class="cell">A</div>
                                    <div class="cell">R</div>
                                    <div class="cell">S</div>
                                    <div class="cell" data-special-cell="themes">T</div>
                                    <div class="cell" data-special-cell="themes">H</div>
                                    <div class="cell" data-special-cell="themes">E</div>
                                    <div class="cell" data-special-cell="themes">M</div>
                                    <div class="cell" data-special-cell="themes">E</div>
                                    <div class="cell" data-special-cell="themes">S</div>
                                    <div class="cell">D</div>
                                    <div class="cell">P</div>
                                </div>
                                <div class="row">
                                    <div class="cell" data-special-cell="settings">E</div>
                                    <div class="cell">H</div>
                                    <div class="cell">E</div>
                                    <div class="cell">H</div>
                                    <div class="cell">E</div>
                                    <div class="cell">S</div>
                                    <div class="cell">X</div>
                                    <div class="cell">U</div>
                                    <div class="cell">L</div>
                                    <div class="cell">D</div>
                                    <div class="cell">Z</div>
                                    <div class="cell">L</div>
                                    <div class="cell">M</div>
                                    <div class="cell">V</div>
                                    <div class="cell">O</div>
                                </div>
                                <div class="row">
                                    <div class="cell" data-special-cell="settings">T</div>
                                    <div class="cell">O</div>
                                    <div class="cell">T</div>
                                    <div class="cell">D</div>
                                    <div class="cell">K</div>
                                    <div class="cell">Z</div>
                                    <div class="cell">I</div>
                                    <div class="cell">M</div>
                                    <div class="cell">X</div>
                                    <div class="cell">U</div>
                                    <div class="cell">H</div>
                                    <div class="cell">E</div>
                                    <div class="cell">B</div>
                                    <div class="cell">D</div>
                                    <div class="cell">A</div>
                                </div>
                                <div class="row">
                                    <div class="cell" data-special-cell="settings">T</div>
                                    <div class="cell">E</div>
                                    <div class="cell">T</div>
                                    <div class="cell">T</div>
                                    <div class="cell">I</div>
                                    <div class="cell" data-special-cell="start">S</div>
                                    <div class="cell" data-special-cell="start">T</div>
                                    <div class="cell" data-special-cell="start">A</div>
                                    <div class="cell" data-special-cell="start">R</div>
                                    <div class="cell" data-special-cell="start">T</div>
                                    <div class="cell">P</div>
                                    <div class="cell">I</div>
                                    <div class="cell">C</div>
                                    <div class="cell">S</div>
                                    <div class="cell">F</div>
                                </div>
                                <div class="row">
                                    <div class="cell" data-special-cell="settings">I</div>
                                    <div class="cell">X</div>
                                    <div class="cell">V</div>
                                    <div class="cell">B</div>
                                    <div class="cell">N</div>
                                    <div class="cell">M</div>
                                    <div class="cell">Q</div>
                                    <div class="cell">C</div>
                                    <div class="cell">K</div>
                                    <div class="cell">J</div>
                                    <div class="cell">H</div>
                                    <div class="cell">O</div>
                                    <div class="cell">T</div>
                                    <div class="cell">P</div>
                                    <div class="cell">L</div>
                                </div>
                                <div class="row">
                                    <div class="cell" data-special-cell="settings">N</div>
                                    <div class="cell">D</div>
                                    <div class="cell">S</div>
                                    <div class="cell">A</div>
                                    <div class="cell">E</div>
                                    <div class="cell">T</div>
                                    <div class="cell">Y</div>
                                    <div class="cell">U</div>
                                    <div class="cell">I</div>
                                    <div class="cell">O</div>
                                    <div class="cell">S</div>
                                    <div class="cell">H</div>
                                    <div class="cell">R</div>
                                    <div class="cell">M</div>
                                    <div class="cell">C</div>
                                </div>
                                <div class="row">
                                    <div class="cell" data-special-cell="settings">G</div>
                                    <div class="cell">H</div>
                                    <div class="cell">J</div>
                                    <div class="cell">E</div>
                                    <div class="cell">L</div>
                                    <div class="cell">S</div>
                                    <div class="cell">A</div>
                                    <div class="cell">M</div>
                                    <div class="cell">N</div>
                                    <div class="cell">B</div>
                                    <div class="cell">W</div>
                                    <div class="cell">F</div>
                                    <div class="cell">R</div>
                                    <div class="cell">T</div>
                                    <div class="cell">L</div>
                                </div>
                                <div class="row">
                                    <div class="cell" data-special-cell="settings">S</div>
                                    <div class="cell">L</div>
                                    <div class="cell">Q</div>
                                    <div class="cell" data-special-cell="how-to-win!">H</div>
                                    <div class="cell" data-special-cell="how-to-win!">O</div>
                                    <div class="cell" data-special-cell="how-to-win!">W</div>
                                    <div class="cell" data-special-cell="how-to-win!"></div>
                                    <div class="cell" data-special-cell="how-to-win!">T</div>
                                    <div class="cell" data-special-cell="how-to-win!">O</div>
                                    <div class="cell" data-special-cell="how-to-win!"></div>
                                    <div class="cell" data-special-cell="how-to-win!">W</div>
                                    <div class="cell" data-special-cell="how-to-win!">I</div>
                                    <div class="cell" data-special-cell="how-to-win!">N</div>
                                    <div class="cell" data-special-cell="how-to-win!">!</div>
                                    <div class="cell">E</div>
                                </div>
                                <div class="row">
                                    <div class="cell">B</div>
                                    <div class="cell">N</div>
                                    <div class="cell">M</div>
                                    <div class="cell">Q</div>
                                    <div class="cell">R</div>
                                    <div class="cell">Z</div>
                                    <div class="cell">J</div>
                                    <div class="cell">F</div>
                                    <div class="cell">E</div>
                                    <div class="cell">Y</div>
                                    <div class="cell">C</div>
                                    <div class="cell">X</div>
                                    <div class="cell">M</div>
                                    <div class="cell">S</div>
                                    <div class="cell">M</div>
                                </div>
                                <div class="row">
                                    <div class="cell">X</div>
                                    <div class="cell">Y</div>
                                    <div class="cell">Z</div>
                                    <div class="cell">A</div>
                                    <div class="cell">H</div>
                                    <div class="cell">C</div>
                                    <div class="cell">D</div>
                                    <div class="cell">S</div>
                                    <div class="cell">F</div>
                                    <div class="cell">G</div>
                                    <div class="cell">T</div>
                                    <div class="cell">I</div>
                                    <div class="cell">D</div>
                                    <div class="cell">K</div>
                                    <div class="cell">A</div>
                                </div>
                            </div>
                    </div>
                </div>
                <div id="lobby-sharecode">
                    <div id="game-link-box"> 
                        <p id="share-link"></p>
                        <img src="copypasteicon.png" id="copy-button"></div>
                    <div id="game-code-box"> </div>
                    </div>
                <form id="add-player-form">
                    <input type="text" id="player-name" placeholder="Enter player name">
                    <button type="button" onclick="simulateAddPlayer()">Add Player</button>
                </form>
            </div>
            <div id ="player-list-box">
                    <div id ="player-list-title">
                         <div id= "player-list-title-text">Players</div>
                     </div>
                    <div id="player-list-container"> </div>
                    <div id="selected-theme-container">
                        <!-- somehow put selected theme here lol -->
                        <div class="selected-theme-text">Current Theme:</div>
                        <div class="selected-theme-text">Holidays</div>        
                    </div>
            </div>
        </div>
    </body>
</html>