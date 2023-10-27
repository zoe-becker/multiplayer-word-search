
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
                    <div id="lobby-title-info">WordSearch!</div>
                </div>
                <div id="lobby-playerlistandsettings">
                    <div id="host-settings-buttons">
                            <div id="word-search-grid" id="word-search-grid">
                                 <!-- The word search grid will be populated here -->
                                 <!-- START (4,5)->(4,9) to be green, THEMES (1,7)->(1,12) to be red, and HOW TO PLAY! (8,3)->(8,13) to be yellow.--> 
                            </div>
                    </div>
                </div>
                <div id="lobby-sharecode">To Do: gamecode</div>
                <form id="add-player-form">
                    <input type="text" id="player-name" placeholder="Enter player name">
                    <button type="button" onclick="simulateAddPlayer()">Add Player</button>
                </form>
            </div>
            <div id ="player-list-box">
                    <div id ="player-list-title">
                         <div id= "player-list-title-text">Player List</div>
                     </div>
                    <div id="player-list-container"> </div>
            </div>
        </div>
    </body>
</html>