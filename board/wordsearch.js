/*
When the document is loaded:
    fetch puzzle.json:
    when the data is received:
    convert data to a json object
    when conversion is done:
        get html element with id "grid" and store it in a variable "grid"

        For each "row" in data.puzzle:
            create a new tbale row and store it in tRow

            for each cell in row:
                create a new table cell and store is in a variable tableCell
                set the inner text of table Cell to the value of cell
                append tablecell to table row

            append tableRow to wordGrid

*/
document.addEventListener('DOMContentLoaded', function(event) {
    fetch('puzzle.json')
        .then(response => response.json())
        .then(data => {
            const grid = document.getElementById("grid"); // changed "wordGrid" to "grid"
            // add logic here to add data to grid

            data.puzzle.forEach(row=>{
                

                let tRow = document.createElement('tr');

                // store the value of cell in tCell and append it to the row
                row.forEach(cell =>{
                    let tCell = document.createElement('td');
                    tCell.innerText = cell;
                    tRow.appendChild(tCell);
                });

                // append the row (with the cell now added) to the grid
                grid.appendChild(tRow);
            });

        })
});
