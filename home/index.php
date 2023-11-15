<!DOCTYPE html>
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
                <li><a href="">About</a></li>
                <li><a href="">Credits</a></li>
            </ul>
        </nav>
        
        <h1> WordSearch! </h1>
        
        <div class="buttons">
            <div class="timeAttack"> 
                <button onclick="timeAttack()" type="button"> <span> </span>Time Attack</button>
                <button  type="button" class="info-button"><span> </span> ? </button>
            </div>

            <div id="time-attack-screen" class="hidden">
                <div id="time-attack-content">
                    <p1>Rules?</p1>
                    <form id="time-attack"> </form>
                    <button id="close-button"><span> </span>Close</button>
                </div> 
            </div>

            <div id="time-attack-user-screen" class="hidden">
                <div id="time-attack-user-content">
                    <h2>Welcome!</h2>
                    <h2>Please create a username.</h2>
                    <form id="time-attack-user"> 
                    <input type="text" id="gameCode" placeholder="Enter your username" required>
                    <button type="button" id="submitButton"><span> </span>Submit</button>
                    </form>
                    <button id="close-button">Close</button>
                </div> 
            </div>

            <button onclick="createLobby()" type="button"> <span> </span>Create Multiplayer Lobby</button>
            
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