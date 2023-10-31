//no double requests on setname call
var requestSetNamePending = false;
let playerSet = new Set();



//Checks if splash screen needs to be called based on token and lobby id
//if it hasnt been set then token, lobby id, and isHost are set.
document.addEventListener("DOMContentLoaded", function (event) {
    var storedToken = localStorage.getItem('accessToken'); 
    var storedLobbyCode = localStorage.getItem('lobbyCode'); 
    var currentLobbyCode = getLobbyCode();

    if(storedToken === null || storedLobbyCode === null || storedLobbyCode !== currentLobbyCode){
        showSplashScreen();
        var submitButton = document.getElementById("submit-button");
        submitButton.addEventListener("click", function() {
            var username = document.getElementById("username").value;
            //valid client username and no setname request pending
            if (clientCheckUsername(username) && !requestSetNamePending) {
                requestSetNamePending = true;
                setName(username);
                requestSetNamePending = false;
            } else {
                alert("Username should be between 1 and 13 characters long.");
            }
        });
    }
});

function setName(username) {
    // Your logic for setting the username goes here
    // addPlayer(username);
    // console.log("Username set to: " + username);
    // request board from server
    let request = new XMLHttpRequest();
    
    request.onreadystatechange = function () {
      if (request.readyState == 4) {
        if (request.status == 200) {
          data = JSON.parse(request.responseText);
           //logic for setting the username goes here
           var lobbyCode = getLobbyCode();
           var accessToken = data.accessToken; // Replace 'exampleToken' with your desired token
           var isHost = data.isHost;
           localStorage.setItem('accessToken', accessToken);
           localStorage.setItem('lobbyCode', lobbyCode);
           localStorage.setItem('isHost',isHost);
           if(isHost === true){
            var themes = data.themes;
            localStorage.setItem('themes', themes);
           }
           clearSplashScreen();
           updateLobby();
           setInterval(updateLobby(), 3000);
        } else {
          if(request.responseText == 'Taken'){
            alert("Username already taken.")
          }else console.log("AJAX Error: " + request.responseText);
        }
      }
    };
  
    request.open("POST", "../setName.php");
    request.setRequestHeader("name", username);
    request.setRequestHeader("lobby", getLobbyCode());
    request.send();
  }
//BOOLEAN CLIENT SIDE CHECK TO SEE IF USERNAME IS VALID (char limits)
function clientCheckUsername(passedUsername) {
    //var username = document.getElementById("username").value;
 
        if (passedUsername.length > 0 && passedUsername.length <= 13) return true;
        else return false; 
    }  
  //HIDE USER NAME PROMPT SPLASH SCREEN
  function showSplashScreen() {
    var splashScreen = document.getElementById("splash-screen");
    splashScreen.classList.remove("hidden"); // Remove the 'hidden' class to display the splash screen
}
  //HIDE USER NAME PROMPT SPLASH SCREEN
  function clearSplashScreen() {
    var splashScreen = document.getElementById("splash-screen");
    splashScreen.classList.add("hidden");
  }
  //ADD PLAYERBOX TO PLAYERLIST
function addPlayer(name) {
    if(!playerSet.has(name)){
        playerSet.add(name);
        var playerList = document.getElementById('player-list-container');
        var playerBox = document.createElement('div');
        playerBox.classList.add('player-box');
        var playerBoxParagraph = document.createElement('p');
        playerBoxParagraph.textContent = name;
        playerBox.appendChild(playerBoxParagraph);
        playerList.appendChild(playerBox);
    }
}
function updateLobby(){
    let request = new XMLHttpRequest();
    
    request.onreadystatechange = function () {
      if (request.readyState == 4) {
        if (request.status == 200) {
          data = JSON.parse(request.responseText);
          num_players = data.players.length;
          //theres more players in list than client has in set
          if(num_players != playerSet.size){
            //adds each new player to set
            for(let i = 0; i < num_players; i++) addPlayer(data.players[i]);
          }
          if(data.gameLink != false){
            window.location.href = data.gameLink;
          }
          
        } else {
          console.log("AJAX Error: " + request.responseText);
        }
      }
    };
  
    request.open("GET", "../getLobbyUpdates.php");
    request.setRequestHeader("lobby", getLobbyCode());
    request.send();
}


function getLobbyURL() {
    const currentUrl = window.location.href;
   // const currentUrl = "https://verygoodbadthing.com/word-search-generator/lobby/ws-700d3a3d17fd3/";
    return currentUrl;
}

function getLobbyCode() {
    const currentUrl = getLobbyURL();

    let code = currentUrl;
    if (code.endsWith('/')) {
        code = code.slice(0, -1); // Remove the trailing '/'
    }
    code = code.substring(code.lastIndexOf('/') + 1);
    return code;
}






//LOAD LOBBY LINK AND CODE INTO BOTTOM BOXES
document.addEventListener('DOMContentLoaded', (event) => {
    // Accessing the share-link div
    const shareLinkDiv = document.getElementById('share-link');

    // Accessing the game-code paragraph
    const gameCodeParagraph = document.getElementById('game-code');

    // Check if the elements with the specified IDs exist
    if (shareLinkDiv && gameCodeParagraph) {
        // Setting the text content of the share-link div to the current URL
        shareLinkDiv.textContent = getLobbyURL();

        // Setting the extracted code to the game-code paragraph
        gameCodeParagraph.textContent = getLobbyCode();
    } else {
        console.error("Element with id 'share-link' or 'game-code' not found.");
    }
});

    //BUTTONS ON WORDGRID
    document.addEventListener('DOMContentLoaded', (event) => {
    // Get all elements with the data-special-cell attribute
    const specialCells = document.querySelectorAll('[data-special-cell]');

    // Add event listeners for click
    specialCells.forEach(cell => {
        cell.addEventListener('mouseover', function() {
            const cellType = cell.getAttribute('data-special-cell');
            specialCells.forEach(specialCell => {
                if (specialCell.getAttribute('data-special-cell') === cellType) {
                    specialCell.classList.add('brighten');
                }
            });
        });

        cell.addEventListener('mouseout', function() {
            specialCells.forEach(specialCell => {
                specialCell.classList.remove('brighten');
            });
        });
        cell.addEventListener('click', function() {
            // Handle click event based on the type of data-special-cell
                const cellType = cell.getAttribute('data-special-cell');
                console.log(`Clicked on cell with attribute ${cellType}:`, cell.textContent);
            });
        });
    }); 

    //clipboard button icons
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(function() {
            console.log('Async: Copying to clipboard was successful!');
        }, function(err) {
            console.error('Async: Could not copy text: ', err);
        });
    }
    // BUTTON CLICK CALLS COPYTOCLIPBOARD
    document.addEventListener('DOMContentLoaded', (event) => {
        // Accessing the share-link div
        const shareLinkDiv = document.getElementById('share-link');
        const gameCodeParagraph = document.getElementById('game-code');

        const shareLinkCopyIcon = document.getElementById('share-link-copy-button');
        const gameCodeCopyIcon = document.getElementById('game-code-copy-button');

        // Check if the elements with the specified IDs exist
        if (shareLinkDiv && gameCodeParagraph && shareLinkCopyIcon && gameCodeCopyIcon) {
            // Setting up click events for the copy icons
            shareLinkCopyIcon.addEventListener('click', () => {
                copyToClipboard(getLobbyURL());
                console.log('link copied');
            });

            gameCodeCopyIcon.addEventListener('click', () => {
                copyToClipboard(getLobbyCode());
                console.log('code copied');
            });
        } else {
            console.error("Element with provided IDs not found.");
        }
    });