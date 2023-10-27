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
fetch('lobbywordsearchgrid.json')
    .then(response => response.json())
    .then(data => {
        const wordSearchGrid = data.wordSearchGrid;
        const gridContainer = document.getElementById('word-search-grid');

        // Populate the word search grid
        wordSearchGrid.forEach(row => {
            const rowElement = document.createElement('div');
            rowElement.classList.add('row');

            row.forEach(cell => {
                const cellElement = document.createElement('div');
                cellElement.classList.add('cell');
                cellElement.textContent = cell;
                rowElement.appendChild(cellElement);
            });

            gridContainer.appendChild(rowElement);
        });
    });
    console.log("JavaScript file is linked successfully.");

   
   