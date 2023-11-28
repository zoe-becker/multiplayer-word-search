<!DOCTYPE html>
<html>
    <head>
    <link rel="stylesheet" href="style.css">
    <script src="main.js"></script>
    </head>
   
    <body>
        <div class="gif">
       
        <nav> 
            <img src="magnifying-glass.png" class="logo">
            <ul> 
                <li><a href="about">About Us</a></li>
                <li><a href="../leaderboard">Leaderboard</a></li>
            </ul>
        </nav>
       
        <h1> WordSearch! </h1>
       
        <div class="buttons">
            <div class="time-attack-buttons">
                <div class="timeAttack"> 
                <h2> Solo Play </h2> 
                    <button onclick="toggleScreen('time-attack-user-screen','show')" type="button"> <span> </span>Time Attack</button>
                </div>

                <div id="time-attack-user-screen" class="hidden">
                    <div id="time-attack-user-content">
                        <h3>Welcome!</h2>
                        <p> In Time Attack, swiftly uncover as many <br> words as you can within
                            the set time! The <br> faster you find words, the higher score you get! </p> <br>
                        <h2>Please create a username.</h2>
                        <form id="time-attack-user"> 
                        <input type="text" id="username" placeholder="Enter your username" required>
                        <button onClick="submitTimeAttack()" type="button" id="submitButton"><span> </span>Submit</button>
                        </form>
                        <div  class="close-button">
                            <button onClick="toggleScreen('time-attack-user-screen', 'hide')" id="close-button"><span> </span>Close</button>
                        </div>
                        
                    </div> 
                </div>
            <div> 
            
            <div class="create-game"> 
            <h2> Multiplayer </h2>
                <button onclick="createLobby()" type="button"> <span> </span>Create Lobby</button>
            </div>
          
            <form id="gameForm"> 
                <input type="text" id="gameCode" placeholder="Game Code" required>
                <button type="button" id="joinButton"><span> </span>Join</button>
            </form>
            
        </div>
          
        </div>
    </body>
</html>