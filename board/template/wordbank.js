let selectedCells = []; // to store the TD elements being selected
let mouseIsPressed = false; // global variable to check if mouse is pressed or not
let foundWordsData = []; // stores the found words
// get the cookie labelled key
function getCookie(key) {
  let cookies = document.cookie.split("; ");
  let cookieValue = false;

  cookies.forEach(function (cookie) {
    if (cookie.startsWith(key)) {
      cookieValue = cookie.split("=")[1]; // get value from key-value pair
    }
  });

  return cookieValue;
}

// refresh warning
window.addEventListener("beforeunload", function (event) {
  event.preventDefault();
});

// checks when page is loaded
document.addEventListener("DOMContentLoaded", function (event) {

  // fetching player data & display with new function
  fetchPlayersAndScores();


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


// testing fetch player and scores function
function fetchPlayersAndScores(){
    // fetch player data from json file
    fetch('players.json')
      .then(response => response.json())
      .then(data =>{
        // get the HTML element with the class "players" and find the <ul> inside it
        const playersList = document.querySelector(".players ul");

        // remove the hard coded player names & scores
        playersList.innerHTML = "";

        // will append the player names and scores dynamically
        data.players.forEach(player => {
          let listItem = document.createElement("li");
          listItem.innerHTML = `${player.name}: <span class="score">${player.score}</span>`;
          playersList.appendChild(listItem);
        });
      })
      
}



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
        if (!td.classList.contains("found")) {
          td.style.backgroundColor = randomColor();
          td.style.fill = randomColor();
        }
        if (mouseIsPressed) {
          selectedCells.push(td); // Adds cell letter to selection array Scrum-62
          highlightSelectedCells();
        }
      });

      td.addEventListener("mousedown", (event) => {
        mouseIsPressed = true;
        selectedCells = [td]; // Start new selection
      });
      document.addEventListener("mouseup", function () {
        mouseIsPressed = false;
        let selectedWord = selectedCells.map((cell) => cell.innerText).join(""); // concatenates the letters in the selected cells
        let wordFound = checkWordInWordBank(selectedWord);
        if (!wordFound) {
          unhighlightSelectedCells();
        }
        selectedCells = []; // clears selected cell
      });

      // reset the background to white once the cursor leaves the cell
      td.addEventListener("mouseleave", (event) => {
        //want the image to fade out after a set timeout?
        if (!selectedCells.includes(td) && !td.classList.contains("found")) {
          td.style.backgroundColor = "white";
          td.style.fill = "white";
        }
      });
    });
  });
}

function highlightSelectedCells() {
  selectedCells.forEach((cell) => {
    cell.style.backgroundColor = randomColor();
    cell.style.fill = randomColor();
  });
}

function unhighlightSelectedCells() {
  selectedCells.forEach((cell) => {
    cell.style.backgroundColor = "white";
    cell.style.fill = "white";
  });
}

function checkWordInWordBank(word) {
  const wordBankList = document.getElementById("wordBankList");
  const wordBankItems = wordBankList.getElementsByTagName("li");
  let wordFound = false;
  let wordColor = randomColor();

  for (let i = 0; i < wordBankItems.length; i++) {
    if (wordBankItems[i].textContent === word) {
      // alert for debugging purposes
      //alert(`Found the word: ${word}`);

      wordBankItems[i].style.textDecoration = "line-through"; // crosses out words when found
      wordFound = true;

      if (wordFound) {
        let lastCell = selectedCells[selectedCells.length - 1];
        let rect = lastCell.getBoundingClientRect();
        let x = (rect.left + rect.right) / 2 / window.innerWidth;
        let y = (rect.top + rect.bottom) / 2 / window.innerHeight;

        // Set the same color for all cells in the found word
        selectedCells.forEach((cell) => {
          cell.style.backgroundColor = wordColor;
          cell.style.fill = wordColor;
        });

        triggerConfetti(x, y);
      }

      selectedCells.forEach((cell) => {
        cell.classList.add("found");
      });

      break;
    }
  }
  return wordFound;
}

function triggerConfetti(x, y) {
  const pop = new Audio("pop.wav");
  confetti({
    particleCount: 30,
    angle: 90,
    drift: 5,
    spread: 15,
    origin: { y: y, x: x },
  });
  pop.play();
}

function randomColor() {
  let color = [];
  for (let i = 0; i < 3; i++) {
    color.push(Math.floor(Math.random() * 256) + 90);
  }

  return "rgb(" + color.join(", ") + ")";
}
