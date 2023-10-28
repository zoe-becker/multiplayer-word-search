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
}   document.addEventListener('DOMContentLoaded', (event) => {
     //getting the current URL
     const currentUrl = window.location.href;

     //accessing the share-link div
     const shareLinkDiv = document.getElementById('share-link');
 
     //check if the element with the id 'share-link' exists
     if (shareLinkDiv) {
       //setting the text content of the share-link div to the current URL
       shareLinkDiv.textContent = currentUrl;
     } else {
       console.error("Element with id 'share-link' not found.");
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
   