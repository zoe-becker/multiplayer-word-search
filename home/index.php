<!-- <!DOCTYPE html> -->
<html>
    <head>
    <link rel="stylesheet" href="style.css">
    <script src="main.js"></script>
    </head>
    <!-- <link rel="stylesheet" href="homepage.css"> -->
   
    <body>
        <div class="gif">
        <nav> 
            <img src="magnifying-glass.png" class="logo">
            <ul> 
                <li><a href="">Home</a></li>
                <li><a href="">About Us</a></li>
                <li><a href="">Credits</a></li>
            </ul>
        </nav>
        <h1> WordSearch! </h1>
        <div class="buttons">
            <button onclick="createLobby()" type="button"> <span> </span>Create New Game</button>
            <form id="gameForm"> 
                <input type="text" id="gameCode" placeholder="Game Code" required>
                <button type="button" id="joinButton"><span> </span>Join</button>
            </form>
            <button onclick="location.href='/word-search-generator/leaderboard'" type="button"><span> </span> Leaderboard</button>
            <!-- <button onclick="requestBoard()">Play</button> -->
            
        </div>
          
        </div>
    </body>
</html>