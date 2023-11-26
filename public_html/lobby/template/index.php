<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lobby</title>
    <link rel="stylesheet" href="lobby.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="lobby.js"></script>
   
    <body>
        <div id="splash-screen" class="hidden">
            <div id="splash-content">
                <h2>Welcome!</h2>
                <h2>Please create a username.</h2>
                <input type="text" id="username" placeholder="Enter your username">
                <button id="submit-button">Submit</button>
            </div>
        </div>
       
        <div id="Start-screen" class = "hidden">
            <div id= "Start-content">
            <p1>Are you sure you want to start the game? </p1>
            <button id="start-button"> Yes, start game!</button>
            <button id="cancel-button">NO! Don't start! </button>
            </div>
        </div>
       
        <div id="HTW-screen" class="hidden">
            <div id="HTW-content">
                <p1>How to win!!!</p1>
                <p>4 letter words are worth 300pts! Where every additional letter is +50 points! </p>
                <p>Diagonal words give a 1.2x multiplier!</p>
                <p>The color of the timer matters so pay attention!</p>
                <p>If the timer color is: </p>
                <p><span style="color: green">Green</span>: 1x score multiplier</p>
                <p><span style="color: #91913d">Yellow</span>: 1.2x score multiplier</p>
                <p><span style="color: red">Red</span>: 2x score multiplier!</p>
                <button id="close-button">Close</button>
            </div> 
        </div>
       
        <div id="Themes-screen" class="hidden">
            <div id="Themes-content">
                <p1>Select Theme</p1>
                <div id="Themes-container"></div>
            </div>
        </div>
        
        <div id="settings-screen" class="hidden">
            <div id="settings-content">
                <h2>Host Settings</h2>
                <!-- value will be used for local storage updates -->

                <!-- Grid Difficulty -->
                <div class= "radio-box">
                    <label for="grid-difficulty">Grid Difficulty:</label>
                    <input type="radio" id="easy" name="grid-difficulty" value="easy">
                    <label for="easy">Easy</label>

                    <input type="radio" id="medium" name="grid-difficulty" value="medium"checked>
                    <label for="medium">Medium</label>

                    <input type="radio" id="hard" name="grid-difficulty" value="hard">
                    <label for="hard">Hard</label>
                </div>

                <!-- Grid Size -->
                <div class= "radio-box">
                    <label for="grid-size">Grid Size:</label>
                    <input type="radio" id="small" name="grid-size" value="small"checked>
                    <label for="small">Small</label>

                    <input type="radio" id="medium-size" name="grid-size" value="medium">
                    <label for="medium-size">Medium</label>

                    <input type="radio" id="large" name="grid-size" value="large">
                    <label for="large">Large</label>
                </div>

                <!-- Grid Shape -->
                <div class= "radio-box">
                    <label for="grid-shape">Grid Shape:</label>
                    <input type="radio" id="square" name="grid-shape" value="square"checked>
                    <label for="square">Square</label>

                    <input type="radio" id="heart" name="grid-shape" value="heart">
                    <label for="heart">Heart</label>

                    <input type="radio" id="star" name="grid-shape" value="star">
                    <label for="star">Star</label>
                </div>
                <button id="settings-close-button">Close</button>
            </div>
        </div>
        
        <div id="kick-screen" class="hidden">
            <div id="kick-content">
                <p1>Would you like to kick this player from the lobby? </p1>
                <button id="kick-button">Yes, kick them!</button>
                <button id="cancel-kick-button">NO! Don't kick them!</button>
            </div> 
        </div>

        <div id="nav-container">
            <nav> 
                <ul> 
                    <li>
                        <a href="../../home"><i class="fa fa-home"></i>Home</a>
                    </li>
                </ul>
            </nav>
       
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
                        <img src="../images/fixed-CopyPasteIcon.png" id="share-link-copy-button">
                    </div>
                    <div id="game-code-box">
                        <p id="game-code"></p>
                        <img src="../images/fixed-CopyPasteIcon.png" id="game-code-copy-button">
                    </div>
                </div>
               
                <div id="lobby-invite-prompt">
                    <div id="lobby-invite-text">Invite your friends with the link or lobby code! </div>
                </div>
               
            </div>
           
            <div id ="player-list-box">
                    <div id ="player-list-title">
                         <div id= "player-list-title-text">Players</div>
                     </div>
                    <div id="player-list-container"> </div>
                    <div id="selected-theme-container">
                        <!-- somehow put selected theme here lol -->
                        <div class="selected-theme-text">Current Theme:</div>
                        <div class="selected-theme-text" id="current-theme"></div>        
                    </div>
            </div>
        </div>
        </div>

    </body>
</html>