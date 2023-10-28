//lobby js
function addPlayer(name) {
    var playerList = document.getElementById('player-list-container');
    var playerBox = document.createElement('div');
    playerBox.classList.add('player-box');
    var playerBoxParagraph = document.createElement('p');
    playerBoxParagraph.textContent = name;
    playerBox.appendChild(playerBoxParagraph);
    playerList.appendChild(playerBox);
}

function simulateAddPlayer() {
    var playerName = document.getElementById('player-name').value;
    if (playerName !== '') {
        addPlayer(playerName);
    }
}
//   document.addEventListener('DOMContentLoaded', (event) => {
//      //getting the current URL
//      const currentUrl = window.location.href;

//      //accessing the share-link div
//      const shareLinkDiv = document.getElementById('share-link');
 
//      //check if the element with the id 'share-link' exists
//      if (shareLinkDiv) {
//        //setting the text content of the share-link div to the current URL
//        shareLinkDiv.textContent = currentUrl;
//      } else {
//        console.error("Element with id 'share-link' not found.");
//      }
// });
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

    console.log("JavaScript file is linked successfully.");

    document.addEventListener('DOMContentLoaded', (event) => {
    // Get all elements with the data-special-cell attribute
    const specialCells = document.querySelectorAll('[data-special-cell]');
    // Log the size of the specialCells array
    console.log("Size of specialCells array:", specialCells.length);

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
   