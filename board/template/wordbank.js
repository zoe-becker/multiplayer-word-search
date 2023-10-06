
// checks when page is loaded
document.addEventListener("DOMContentLoaded", function (event) {
  // request board from server
  let request = new XMLHttpRequest();

  request.onreadystatechange = function() {
    if (request.readyState == 4) {
      if (request.status == 200) {
        data = JSON.parse(request.responseText);
        // get the html element with ID "wordBankList" and store it as wordBankList
        const wordBankList = document.getElementById("wordBankList");

        data.words.forEach((word) => {
          let listItem = document.createElement("li"); //  create a new list item
          listItem.textContent = word; // set contnet of the list item to the current word
          wordBankList.appendChild(listItem); //  append the list item to the word banklist element
        });

      // draw the word search
      renderWordSearch(data.puzzle);
      } else {
        console.log("AJAX Error: " + request.responseText);
      }
    }
  }

  let windowPaths = window.location.href.split("/");
  let instanceID = windowPaths.at(-1) == '' ? windowPaths.at(-2) : windowPaths.at(-1);
  request.open("GET", "../getBoardDetails.php?instance=" + instanceID);
  request.send();
});

function renderWordSearch(puzzle) {
  let table = document.createElement("table");
  const container = document.getElementById("wordsearch");
  let startPoint = null;
  let endPoint = null;
  container.appendChild(table); // Drew the main table node on the document

  puzzle.forEach(function (row) {
    let tr = table.insertRow(); //Create a new row

    row.forEach(function (column) {
      let td = tr.insertCell();
      td.innerText = column; // Take string from placeholder variable and append it to <tr> node

      // cell hover is set to a random color
      td.addEventListener("mouseover", (event) => {
        td.style.backgroundColor = randomColor();
        td.style.fill = randomColor();
      });

      // reset the background to white once the cursor leaves the cell
      td.addEventListener("mouseleave", (event) => {
        td.style.backgroundColor = "white";
        td.style.fill = "white";
        
      });

      td.addEventListener("mousedown", (event) =>{
        startPoint = event.currentTarget;
      });

      td.addEventListener("mouseup", (event)=>{
        // TODO event listener logic here
        endPoint = event.currentTarget;
        let selectedWord  = getSelectedWord(startPoint,endPoint);
        checkWordInWordBank(selectedWord);
      });
    });
  });

  function randomColor() {
    let color = [];
    for (let i = 0; i < 3; i++) {
      color.push(Math.floor(Math.random() * 256) + 60);
    }

    return "rgb(" + color.join(", ") + ")";
  }

  function getSelectedWord(startPoint,endPoint) {
    const start = {
      row: startPoint.parentElement.rowIndex,
      column: startPoint.cellIndex
    };
    const end = {
      row: endPoint.parentElement.rowIndex,
      column: endPoint.parentElement.cellIndex
    };
    
    const direction = getDirection(start,end);
    return extractWordFromGrid(startPoint, direction);
  }

  function extractWordFromGrid(startTd, direction) {
    let word = "";
    let currentTd = startTd;
    
    while (isInsideGrid(currentTd)) {
        word += currentTd.innerText;
        currentTd = moveInDirection(currentTd, direction);
        
        // Break if we've looped back to the starting point.
        // This might happen if the moveInDirection doesn't find a valid next cell.
        if (currentTd === startTd) break;
    }
    
    return word;
}



  function isInsideGrid(td) {
    const gridSize = 13;
    const row = td.parentElement.rowIndex;
    const column = td.cellIndex;
    return row >= 0 && row < gridSize && column >= 0 && column < gridSize;
  }

  function getDirection(start,end){
    const HORIZONTAL = "HORIZONTAL";
    const VERTICAL = "VERTICAL";
    const DIAGONAL = "DIAGONAL";
    const NONE = "NONE";

    if (start.row === end.row){
      return HORIZONTAL;
    } else if (start.column === end.column){
      return VERTICAL;
    } else if (Math.abs(start.row = end.row) === Math.abs(start.column - end.column)) {
      return DIAGONAL;
    } else {
      return NONE;
    }
  }

  function moveInDirection(td,direction){
    const table = td.parentElement.parentElement;
    const row =  td.parentElement.rowIndex;
    const column = td.cellIndex;

    switch(direction) {
      case "HORIZONTAL":
        return table.rows[row].cells[column + 1] || td;
      case "VERTICAL":
        return table.rows[row + 1]?.cells[column] || td;
      case "DIAGONAL":
        return table.rows[row + 1]?.cells[column + 1] || td;
      default:
        return td;
    }
  }
  /*
  function wordSelected(){
    let selectedWord = getSelectedWord(startPoint, endPoint);
    checkWordInWordBank(selectedWOrd);

  }
  */
  function checkWordInWordBank(word) {
    const wordBankItems = document.querySelectorAll("#wordBankList li");
    wordBankItems.forEach(item => {
      if (item.textContent === word) {
        item.style.textDecoration = "line-through";
      }
    });
  }



}



