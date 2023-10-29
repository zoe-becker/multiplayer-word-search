//lobby js

document.addEventListener('DOMContentLoaded', (event) => {
    var playerName = "";
    while (playerName.length > 13 || playerName.length === 0) {
        // Show a modal dialog to prompt the user for a name
        playerName = prompt("Please enter your name (max 13 characters):");
        // Check if the user cancelled the prompt
        if (playerName === null) {
            // Alert the user that a name is required
            alert("A name is required to add a player.");
            return;
        }

        // Check if the name is too long
        if (playerName.length > 13) {
            alert("The name should be 13 characters or fewer.");
        }
    }

    // Call the addPlayer function with the validated name
    addPlayer(playerName);
});
function addPlayer(name) {
    var playerList = document.getElementById('player-list-container');
    var playerBox = document.createElement('div');
    playerBox.classList.add('player-box');
    var playerBoxParagraph = document.createElement('p');
    playerBoxParagraph.textContent = name;
    playerBox.appendChild(playerBoxParagraph);
    playerList.appendChild(playerBox);
}
/*
Functions to implement:
Polling:
getLobbyUpdates() -> make http request to getLobbyUpdates.php
    recieves json from server
updateLobby(data) -> update the lobby based on response
    recieving a json - holds players and gamelist(false if not started- if started then its the link of the game)
    make sure to remove all player-boxes before parsing json and re-adding them
    removeChild()?
setName:
setName() -> make http request to setName.php
    recieves accesstoken- create cookie for client 
    cookie holds data over pages- between lobby page and game page
    const token = setName(name, gameid)
    let request = new XMLHttpRequest
    if(token.status == 200){

    }
    document.cookie = "accessToken=" + token;

clearSplashscreen() -> if setName if successful this gets called
    make splash in php
    make all splash screen
*/
/*
open splash screen
get user input
press send
client side check (char limit)
setName
pass =
set cookie

partial pseudo not law

*/








document.addEventListener('DOMContentLoaded', (event) => {
    // Getting the current URL
    //const currentUrl = window.location.href;
    const currentUrl = "https://verygoodbadthing.com/word-search-generator/lobby/ws-653d3a3d17fd3/";


    // Accessing the share-link div
    const shareLinkDiv = document.getElementById('share-link');

    // Accessing the game-code paragraph
    const gameCodeParagraph = document.getElementById('game-code');

    // Check if the elements with the specified IDs exist
    if (shareLinkDiv && gameCodeParagraph) {
        // Setting the text content of the share-link div to the current URL
        shareLinkDiv.textContent = currentUrl;

        let code = currentUrl;
    if (code.endsWith('/')) {
        code = code.slice(0, -1); // Remove the trailing '/'
    }
    code = code.substring(code.lastIndexOf('/') + 1);
        // Setting the extracted code to the game-code paragraph
        gameCodeParagraph.textContent = code;
    } else {
        console.error("Element with id 'share-link' or 'game-code' not found.");
    }
    });
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
   