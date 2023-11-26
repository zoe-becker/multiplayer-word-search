//no double requests on setname call
var requestSetNamePending = false;
var requestSetThemePending = false;
var requestStartGamePending = false;

// Read values from localStorage
var localDifficulty = localStorage.getItem('localDifficulty') || 'medium';
var localSize = localStorage.getItem('localSize') || 'small';
var localShape = localStorage.getItem('localShape') || 'square';

// Create GameSettings object for createGame()
let gameSettings = {
    difficulty: localDifficulty,
    size: localSize,
    shape: localShape
  };

//Checks if splash screen needs to be called based on token and lobby id
//if it hasnt been set then token, lobby id, and isHost are set.
document.addEventListener("DOMContentLoaded", function (event) {

    var storedToken = localStorage.getItem('accessToken'); 
    var storedLobbyCode = localStorage.getItem('lobbyCode'); 
    var currentLobbyCode = getLobbyCode();
    //user should be prompted with splash screen if they pass these
    if(storedToken === null || storedLobbyCode === null || storedLobbyCode !== currentLobbyCode){
        //user hasnt been to this lobby before, so reset any playerSet thats been in there.
        localStorage.setItem('playerSet', JSON.stringify(Array.from(new Set())));
        //give user option to create username
        toggleScreen('splash-screen','show');
        var usernameInput = document.getElementById("username");
        var submitButton = document.getElementById("submit-button");

        // Add an event listener for the Enter key on the input field
        usernameInput.addEventListener("keydown", function(event) {
            if (event.key === "Enter") {
                // Prevent the default behavior of the Enter key (e.g., form submission)
                event.preventDefault();
                
                // Simulate a click on the submit button
                submitButton.click();
            }
        });
        submitButton.addEventListener("click", function() {
            var username = usernameInput.value;
            //valid client username and no setname request pending
            if (clientCheckUsername(username)) {
                if (!requestSetNamePending) {
                    requestSetNamePending = true;
                    setName(username);
                } else {
                    alert("One moment please, username request pending.");
                }
            } else {
                alert("Username should be between 1 and 13 characters long.");
            }
        });
    }else{
        setInterval(updateLobby, 3000);
    }
});
//SENDS USERNAME TO SERVER AND UPDATES SERVER PLAYERLIST
function setName(username) {
    let request = new XMLHttpRequest();
    
    request.onreadystatechange = function () {
      if (request.readyState == 4) {
        if (request.status == 200) {
          data = JSON.parse(request.responseText);
           //logic for setting the username goes here
           var lobbyCode = getLobbyCode();
           var accessToken = data.accessToken;
           var isHost = data.isHost;
           localStorage.setItem('playerName', username);
           localStorage.setItem('accessToken', accessToken);
           localStorage.setItem('lobbyCode', lobbyCode);
           localStorage.setItem('isHost',isHost);
           if(isHost === true){
            var themes = data.themes;
            localStorage.setItem('themes', JSON.stringify(themes));
            loadThemeBoxes();
           }
           toggleScreen('splash-screen','hide');
           //polling instantly so there isnt a delay for the names to pop up
           updateLobby();
           //3 second polling for lobby indefinetly
           setInterval(updateLobby, 3000);
        } else {
          if(request.responseText == 'Taken'){
            alert("Username already taken.")
          }else if(request.responseText == 'game already started'){
            alert("Too late! Game has already started.")
          }else console.log("AJAX Error: " + request.responseText);
        }
        requestSetNamePending = false;
      }
    };
    request.open("POST", "../setName.php");
    request.setRequestHeader("name", username);
    request.setRequestHeader("lobby", getLobbyCode());
    request.send();
  }
//START GAME
function startGame(){
    let request = new XMLHttpRequest();
    //make JSON with game settings
    let gameSettingsJSON = JSON.stringify(gameSettings);
    
    request.onreadystatechange = function () {
      if (request.readyState == 4) {
        if (request.status == 200) {

        } else console.log("AJAX Error: " + request.responseText);
        requestSetNamePending = false;
      }
    };
    request.open("POST", "../createGame.php");
    request.setRequestHeader("token", localStorage.getItem('accessToken'));
    request.setRequestHeader("lobby", getLobbyCode());
    request.setRequestHeader("settings", gameSettingsJSON);
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
  //HIDING OR SHOWING SCREENS
  function toggleScreen(screenId, action) {
    var screen = document.getElementById(screenId);
    if (screen) {
        if (action === 'show') {
            screen.classList.remove('hidden');
        } else if (action === 'hide') {
            screen.classList.add('hidden');
        }
    }
}

  //ADD PLAYERBOX TO PLAYERLIST
function addOrRemovePlayer(name, serverPlayerSet) {
    logSetContents(serverPlayerSet, 'serverinaddorrem');
    let key = "playerSet";
    let storedPlayerSet = JSON.parse(localStorage.getItem(key)) || [];
    let playerSet = new Set(storedPlayerSet);
    if(!playerSet.has(name) && serverPlayerSet.has(name)){
        console.log("1");
        playerSet.add(name);
        var playerList = document.getElementById('player-list-container');
        var playerBox = document.createElement('div');
        playerBox.classList.add('player-box');
        var playerBoxParagraph = document.createElement('p');
        playerBoxParagraph.textContent = name;
        playerBox.appendChild(playerBoxParagraph);
        playerList.appendChild(playerBox);
        // Set up event listeners for the player box
        if(localStorage.getItem('playerName') != name){
        setupPlayerBox(playerBoxParagraph);
        }
    } 
    if(playerSet.has(name) && !serverPlayerSet.has(name)){
        console.log("2");
        //local list has name, but server doesnt, so he was kicked
        playerSet.delete(name);
        console.log("a player was deleted from the local set!!!");
        localStorage.setItem(key, JSON.stringify(Array.from(playerSet)));
        if(name == localStorage.getItem('playerName')){
            window.location.href = "http://localhost/home/";
        }
    }
    console.log("3");
    localStorage.setItem(key, JSON.stringify(Array.from(playerSet)));
}
function logSetContents(set, type) {
    console.log(type +" " + Array.from(set).join(' '));
  }
//LOBBY POLLING
function updateLobby(){
    let request = new XMLHttpRequest();
    
    request.onreadystatechange = function () {
      if (request.readyState == 4) {
        if (request.status == 200) {
          data = JSON.parse(request.responseText);
          localStorage.setItem('currentTheme',data.theme);
          num_players = data.players.length;
          let serverPlayerSet = new Set(data.players.map(player => player.name));
          //theres more players in list than client has in set
          let storedPlayerSet = JSON.parse(localStorage.getItem("playerSet")) || [];
          let localPlayerSet = new Set(storedPlayerSet);
          logSetContents(serverPlayerSet, 'server');
          logSetContents(localPlayerSet, 'local');
          //more player in server than local
          if(num_players > localPlayerSet.size){
            //adds each new player to set
            console.log("sizes uneven -make comparison!!");
            for(let i = 0; i < num_players; i++) addOrRemovePlayer(data.players[i].name, serverPlayerSet);
            renderPlayersFromSet();          
          }
          //more players local than server
          if(num_players < localPlayerSet.size){
            const localPlayerArray = Array.from(localPlayerSet);
            for (let i = 0; i < localPlayerArray.length; i++) {
                addOrRemovePlayer(localPlayerArray[i], serverPlayerSet);
            }  
            renderPlayersFromSet();          
          }
          //game has started, redirect user to gamelink
          if(data.gameLink != false){
            localStorage.setItem("startTime", data.startTime);
            window.location.href = data.gameLink;
          }
          updateLobbyTheme();
          console.log(getCurrentTheme);
        } else {
          console.log("AJAX Error: " + request.responseText);
        }
      }
    };
    var lobbyCode = getLobbyCode();
    var url = "../getLobbyUpdates.php?lobby=" + lobbyCode;
    request.open("GET", url);
    request.send();
}
function kickPlayer(name){
    let request = new XMLHttpRequest();

    request.onreadystatechange = function () {
      if (request.readyState == 4) {
        if (request.status == 200) {

        } else console.log("AJAX Error: " + request.responseText);
        requestSetNamePending = false;
      }
    };
    request.open("POST", "../kickPlayer.php");
    request.setRequestHeader("lobby", getLobbyCode());
    request.setRequestHeader("token", localStorage.getItem('accessToken'));
    request.setRequestHeader("name", name);
    request.send(); 
}

//LOAD THEME BOXES FROM LOCAL STORAGE
function loadThemeBoxes(){
    let key = "themes";
    let storedThemes = JSON.parse(localStorage.getItem(key));
    let themesContainer = document.getElementById('Themes-container');
    themesContainer.innerHTML = ""; //clear the container before rendering
    
    storedThemes.forEach(theme => {
        var themeBox = document.createElement('div');
        themeBox.classList.add('theme-box');
        var themeBoxButton = document.createElement('button');
        // Use the addBrightenFunctionality function
        addBrightenFunctionality(themeBoxButton, function() {
            requestSetThemePending = true;
            console.log(theme + 'changed');
            setTheme(theme);
            updateLobby();
            toggleScreen('Themes-screen', 'hide');
        });
        themeBoxButton.textContent = theme; //assuming each theme is a string
        themeBox.appendChild(themeBoxButton);
        themesContainer.appendChild(themeBox);
    });
    var closeButton = document.createElement('button');
    addBrightenFunctionality(closeButton, function() {
        toggleScreen('Themes-screen', 'hide');
    });
    closeButton.textContent = "Close";
    themesContainer.appendChild(closeButton);
}
//RERENDER PLAYERLIST ON PAGE REFRESH
function renderPlayersFromSet() {
    let key = "playerSet";
    let storedPlayerSet = JSON.parse(localStorage.getItem(key)) || [];
    let playerSet = new Set(storedPlayerSet);
    let playerList = document.getElementById('player-list-container');
    playerList.innerHTML = ""; // Clear the container before rendering
    Array.from(playerSet).forEach(name => {
        var playerBox = document.createElement('div');
        playerBox.classList.add('player-box');
        var playerBoxParagraph = document.createElement('p');
        playerBoxParagraph.textContent = name;
        playerBox.appendChild(playerBoxParagraph);
        playerList.appendChild(playerBox);
        if(localStorage.getItem('playerName') != name){
            setupPlayerBox(playerBoxParagraph);
            }
    });
}

// Call renderPlayersFromSet on page load or refresh
window.addEventListener('load', renderPlayersFromSet);
// Call loadThemeBoxes on page load or refresh for host
window.addEventListener('load', loadThemeBoxes);

// Function to store the last kicked player in localStorage
function storeLastKickedPlayer(playerName) {
    localStorage.setItem('lastKickedPlayer', playerName);
}
// Function to update the kick screen text based on the last kicked player
function updateKickScreenText() {
    const lastKickedPlayer = localStorage.getItem('lastKickedPlayer');
    const kickScreenText = document.getElementById('kick-content').querySelector('p1');

    if (lastKickedPlayer) {
        kickScreenText.textContent = `Would you like to kick ${lastKickedPlayer} from the lobby?`;
    }
}
// Function to set up event listeners for a player box
function setupPlayerBox(playerBoxParagraph) {
    // Event listener for click on player paragraph
    playerBoxParagraph.addEventListener('click', function (event) {
        if (isHost()) {
            //last clicked playerbox would be the one to kicked
            const playerName = event.target.textContent;
            storeLastKickedPlayer(playerName);
            updateKickScreenText();
            toggleScreen('kick-screen', 'show');
        }
    });

    // Event listeners for mouseover/mouseout on player paragraph
    playerBoxParagraph.addEventListener('mouseover', function (event) {
        if (isHost()) {
            playerBoxParagraph.style.fontWeight = 'bold';
            event.target.style.cursor = 'pointer';
        }
    });

    playerBoxParagraph.addEventListener('mouseout', function (event) {
        if (isHost()) {
            playerBoxParagraph.style.fontWeight = 'normal';
            event.target.style.cursor = 'auto';
        }
    });
}
function getLobbyURL() {
    const currentUrl = window.location.href;
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
function getCurrentTheme(){
    return localStorage.getItem('currentTheme');
}

//SET THEME
function setTheme(theme){
    let request = new XMLHttpRequest();
    
    request.onreadystatechange = function () {
      if (request.readyState == 4) {
        if (request.status == 200) {
            updateLobby();
        } else {
          console.log("AJAX Error: " + request.responseText);
        }
        requestSetThemePending = false;
      }
    };
    request.open("POST", "../setTheme.php");
    request.setRequestHeader("token", localStorage.getItem('accessToken'));
    request.setRequestHeader("theme", theme);
    request.setRequestHeader("lobby", getLobbyCode());
    request.send();

}
//LOAD SELECTED THEME INTO THEMEBOX AT BOTTOM
    function updateLobbyTheme() {
    const currentTheme = document.getElementById('current-theme');
    currentTheme.textContent = getCurrentTheme();
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

// Add event listeners for click for special cells
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
            if (cellType === 'settings') {
                handleSettingsClick();
            } else if (cellType === 'how-to-win!') {
                handleHTWClick();
            } else if (cellType === 'start') {
                handleStartClick();
            } else if (cellType === 'themes') {
                handleThemesClick();
            } else {
            }
        });
    });
}); 
//GET ISHOST VALUE
function isHost(){
    var isHostStringVersion = localStorage.getItem('isHost');
    var isHost;
    if(isHostStringVersion === 'true'){
        isHost = true;
    }else isHost = false;
    return isHost;
}
//BRIGHTENS BUTTONS AND ALLOWS FUNCTION ON CLICK <-- specified at each location
function addBrightenFunctionality(element, clickCallback) {
    element.addEventListener('mouseover', function () {
        element.classList.add('brighten');
    });

    element.addEventListener('mouseout', function () {
        element.classList.remove('brighten');
    });

    element.addEventListener('click', clickCallback);
}
//START SCREEN BUTTONS
function handleStartClick(){
    var host= isHost();
    if(host){
        toggleScreen('Start-screen','show');
        var startButton = document.getElementById("start-button");
        var cancelButton = document.getElementById("cancel-button");

        addBrightenFunctionality(startButton, function () {
            toggleScreen('Start-screen', 'hide');
            requestStartGamePending = true;
            startGame();
        });
        
        addBrightenFunctionality(cancelButton, function () {
            toggleScreen('Start-screen', 'hide');
        });
    }else{
        alert("Only the host can start the game.")
    }
}

function handleThemesClick(){
    var host= isHost();
    if(host){
        toggleScreen('Themes-screen','show');
        //once they click on a theme button it hides the themes screen
    }else{
        console.log("denied!");
        alert("Only the host can select the current theme.")
    }
}
function handleHTWClick(){
    toggleScreen('HTW-screen', 'show');
    console.log("new fun worked");
    var closeButton = document.getElementById("close-button");

    // Use the addBrightenFunctionality function
    addBrightenFunctionality(closeButton, function() {
        toggleScreen('HTW-screen', 'hide');
    });

}
function handleSettingsClick(){
    var host= isHost();
    if(host){
        toggleScreen('settings-screen', 'show');
        var closeButton = document.getElementById("settings-close-button");
        addBrightenFunctionality(closeButton, function() {
            toggleScreen('settings-screen', 'hide');
        });
    }else{
        alert("Only the host can edit the game settings.")
    }
}
document.addEventListener('DOMContentLoaded', (event) => {
    var host= isHost();
    if(host){
        var startButton = document.getElementById("kick-button");
        var cancelButton = document.getElementById("cancel-kick-button");

        addBrightenFunctionality(startButton, function () {
            toggleScreen('kick-screen', 'hide');
            console.log(localStorage.getItem('lastKickedPlayer')+ " was attempted to kick");
            kickPlayer(localStorage.getItem('lastKickedPlayer'));
            //addBrightenFunctionality(localStorage.getItem('lastKickedPlayer'));
        });
        
        addBrightenFunctionality(cancelButton, function () {
            toggleScreen('kick-screen', 'hide');
        });
    }
});
//event listeners for settings radios
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('settings-content').addEventListener('change', function (event) {
        const target = event.target;

        // Check if the changed element is a radio button
        if (target.type === 'radio') {
        const groupName = target.getAttribute('name');
        const selectedValue = target.value;
    
        // Update the localStorage variable based on the radio button group
        switch (groupName) {
            case 'grid-difficulty':
            localStorage.setItem('localDifficulty', selectedValue);
            break;
            case 'grid-size':
            localStorage.setItem('localSize', selectedValue);
            break;
            case 'grid-shape':
            localStorage.setItem('localShape', selectedValue);
            break;
        }
        }
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

//implement function that on button click in host settings changes local storage
//have it so that when you create a game you pass the new updated headers
//make a check to see if the person is host before clicking settings
