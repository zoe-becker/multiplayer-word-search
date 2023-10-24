let selectedCells = [];  // to store the TD elements being selected
let mouseIsPressed = false; // global variable to check if mouse is pressed or not

// get the cookie labelled key
function getCookie(key) {
  let cookies = document.cookie.split("; ");
  let cookieValue = false;

  cookies.forEach(function(cookie) {
    if (cookie.startsWith(key)) {
      cookieValue = cookie.split("=")[1]; // get value from key-value pair
    }
  })

  return cookieValue;
}

// checks when page is loaded
document.addEventListener("DOMContentLoaded", function (event) {
  // request board from server
  let request = new XMLHttpRequest();
  

  request.onreadystatechange = function () {
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
  };

  let windowPaths = window.location.href.split("/");
  let instanceID =
    windowPaths.at(-1) == "" ? windowPaths.at(-2) : windowPaths.at(-1);
  request.open("POST", "../getInitialBoard.php");
  request.setRequestHeader("game", instanceID);
  request.setRequestHeader("token", getCookie("accessToken"));
  request.send();
});

function renderWordSearch(puzzle) {
  let table = document.createElement("table");
  const container = document.getElementById("wordsearch");
  container.appendChild(table); // Drew the main table node on the document

  puzzle.forEach(function (row) {
    let tr = table.insertRow(); //Create a new row

    row.forEach(function (column) {
      let td = tr.insertCell();
      td.innerText = column; // Take string from placeholder variable and append it to <tr> node

      // cell hover is set to a random color
      td.addEventListener("mouseenter", (event) => {
        td.style.backgroundColor = randomColor();
        td.style.fill = randomColor();
        if(mouseIsPressed){
          selectedCells.push(td); // Adds cell letter to selection array Scrum-62
        }
      });

      td.addEventListener("mousedown", (event) => {
        mouseIsPressed = true;
        selectedCells = [td];  // Start new selection
        td.style.backgroundColor = randomColor();
        td.style.fill = randomColor();
      });
    document.addEventListener("mouseup", function() {
      mouseIsPressed = false;
      let selectedWord = selectedCells.map(cell => cell.innerText).join(""); // concatenates the letters in the selected cells
      let wordFound = checkWordInWordBank(selectedWord);
      if(!wordFound){
        selectedCells.forEach(cell => {
          cell.style.backgroundColor = "white";
          cell.style.fill = "white";

        })
      }
      selectedCells = []; // clears selected cell
    });

      // reset the background to white once the cursor leaves the cell
      td.addEventListener("mouseleave", (event) => {
        //want the image to fade out after a set timeout?
        if(!selectedCells.includes(td)){
          td.style.backgroundColor = "white";
          td.style.fill = "white";
        }
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
}

function checkWordInWordBank(word) {
  const wordBankList = document.getElementById("wordBankList");
  const wordBankItems = wordBankList.getElementsByTagName("li");
  let wordFound = false;

  for(let i = 0; i < wordBankItems.length; i++) {
      if(wordBankItems[i].textContent === word) {
          // alert for debugging purposes
          //alert(`Found the word: ${word}`);

          wordBankItems[i].style.textDecoration = "line-through"; // crosses out words when found
          wordFound = true;

          // TODO scrum 26

       
          
          break;
      }
  }
  return wordFound;
}
