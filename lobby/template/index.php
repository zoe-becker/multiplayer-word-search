
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lobby</title>
    <link rel="stylesheet" href="lobby.css">
    <script src="lobby.js"></script>
    <body>
        <div class = "outer-lobby-container">
            <div class="lobby-container">
                <div class="lobby-title">
                    <div class="lobby-title-info">WordSearch!</div>
                </div>
                <div class="lobby-playerlistandsettings">
                    <div class="host-settings-buttons">
                            <div class="word-search-grid" id="word-search-grid">
                                 <!-- The word search grid will be populated here -->
                                 <!-- START (4,5)->(4,9) to be green, THEMES (1,7)->(1,12) to be red, and HOW TO PLAY (8,3)->(8,13) to be yellow.--> 
                            </div>
                    </div>
                </div>
                <div class="lobby-sharecode">To Do: gamecode</div>
                <form id="add-player-form">
                    <input type="text" id="player-name" placeholder="Enter player name">
                    <button type="button" onclick="simulateAddPlayer()">Add Player</button>
                </form>
            </div>
            <div class ="player-list-box">
                    <div class ="player-list-title">
                         <div class= "player-list-title-text">Player List</div>
                     </div>
                    <div class ="player-list"> </div>
            </div>
        </div>
    </body>
</html>