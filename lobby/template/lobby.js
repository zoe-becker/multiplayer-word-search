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
    console.log("JavaScript file is linked successfully.");
// Get all elements with the data-special-cell attribute
const specialCells = document.querySelectorAll('[data-special-cell]');
// Log the size of the specialCells array
console.log("Size of specialCells array:", specialCells.length);

// Add event listeners for click
specialCells.forEach(cell => {
    cell.addEventListener('click', function() {
        // Handle click event based on the type of data-special-cell
        const cellType = cell.getAttribute('data-special-cell');
        switch(cellType) {
            case 'themes':
                // Handle themes click
                console.log('Themes clicked:', cell.textContent);
                break;
            case 'start':
                // Handle types click
                console.log('start clicked:', cell.textContent);
                break;
            case 'how-to-win!':
                // Handle types click
                console.log('htw clicked:', cell.textContent);
                break;
            default:
                // Handle default case
                console.log('Default clicked:', cell.textContent);
                // Add your default logic here
        }
    });
});
   
   