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
                <li><a href="about">About Us</a></li>
            </ul>
        </nav>
       
        <h1> WordSearch! </h1>

       
       
        <div class="buttons">
            <div class="time-attack-buttons">
                <div class="timeAttack"> 
                    <button onclick="toggleScreen('time-attack-user-screen','show')" type="button"> <span> </span>Time Attack</button>
                    <button  onClick="toggleScreen('time-attack-screen','show')" class="info-button" type="button"> <span> </span> i </button>
                </div>

                <div id="time-attack-screen" class="hidden">
                    <div id="time-attack-content">
                        <p1>WHAT IS TIME ATTACK?</p1>
                        <br></br>
                        <p>In Time Attack, players are challenged to find as many</p>
                        <p>words as possible within a fixed time limit. The score</p>
                        <p>multiplier deceases as time passes instead of increasing.<p>
                        <div class="close-button">
                            <button onClick="toggleScreen('time-attack-screen','hide')" id="close-button"><span> </span>Close</button>
                        </div>
                        
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
                        <div  class="close-button">
                            <button onClick="toggleScreen('time-attack-user-screen', 'hide')" id="close-button"><span> </span>Close</button>
                        </div>
                        
                    </div> 
                </div>
            <div> 
            
            <div class="create-game"> 
                <button onclick="createLobby()" type="button"> <span> </span>Create New Game</button>
            </div>
          
            <form id="gameForm"> 
                <input type="text" id="gameCode" placeholder="Game Code" required>
                <button type="button" id="joinButton"><span> </span>Join</button>
            </form>

            <div class="leaderboard">
                <button onclick="location.href='../leaderboard'" type="button"><span> </span> Leaderboard</button>
            </div>
            <!-- <button onclick="requestBoard()">Play</button> -->
            
        </div>
          
        </div>
    </body>
</html>