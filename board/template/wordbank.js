let selectedCells = []; // to store the TD elements being selected
let direction = null; // Variable to store the current direction
let mouseIsPressed = false; // global variable to check if mouse is pressed or not
let foundWords = []; // stores the found words
let gameEndTime = 0;
let startTime = 0;
let gameLength = 0;

let timerIntervalObj;
let themeAssets = '../../themes/themeAssets/'
document.addEventListener("DOMContentLoaded", function (event) {
  setInterval(updateBoard, 2000);
});


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

// ticks the timer down
function ticktok() {
  let timer = document.getElementById("timer");
  let timeLeft = gameEndTime - Math.floor(Date.now() / 1000);
  gameLength = gameEndTime - startTime;
  let minutesLeft = Math.floor(timeLeft / 60);
  let secondsLeft = timeLeft - minutesLeft * 60;

  // check if timer is finished
  if (timeLeft <= 0) {
    clearInterval(timerIntervalObj);
    minutesLeft = 0;
    secondsLeft = 0;
  }

  if (secondsLeft < 10) {
    secondsLeft = "0" + secondsLeft;
  }

  timer.textContent = minutesLeft + ":" + secondsLeft;

  if (timeLeft >= gameLength * 0.5) {
    timer.style.color = "green";
  } else if (timeLeft >= gameLength * 0.1667) {
    timer.style.color = "orange";
  } else {
    timer.style.color = "red";
  }
}

// refresh warning
window.addEventListener("beforeunload", function (event) {
  event.preventDefault();
});

// checks when page is loaded
document.addEventListener("DOMContentLoaded", function (event) {
  // fetching player data & display with new function
  //fetchPlayersAndScores();

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

          // rendering theme
          renderTheme(data.theme);

          // set up timer
          gameEndTime = data.expireTime;
          startTime = data.startTime;
          ticktok();
          timerIntervalObj = setInterval(ticktok, 1000);
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
  request.setRequestHeader("token", localStorage.getItem("accessToken"));
  request.send();
});

// function to get themes and its features
function renderTheme(dataTheme) {
  if (dataTheme.backgroundImage) {
    document.body.style.backgroundImage = `url(${
      themeAssets + dataTheme.backgroundImage
    })`;
  }

  if (dataTheme.playerBoxColor) {
    const playerBox = document.querySelector(".players");
    if (playerBox) {
      playerBox.style.backgroundColor = dataTheme.playerBoxColor;
    }
  }

  //not working
  if (dataTheme.tableBox) {
    const tableBox = document.querySelector("table");
    if (tableBox) {
      tableBox.style.backgroundColor = dataTheme.tableBox;
    }
  }

  if (dataTheme.wordBankBox) {
    const wordBankBox = document.querySelector(".word-bank");
    if (wordBankBox) {
      wordBankBox.style.backgroundColor = dataTheme.wordBankBox;
    }
  }

  if (dataTheme.timerBox) {
    const timerBox = document.querySelector("#timer");
    if (timerBox) {
      timerBox.style.backgroundColor = dataTheme.timerBox;
    }
  }
}

// testing fetch player and scores function
function fetchPlayersAndScores() {
  // fetch player data from json file
  fetch("players.json")
    .then((response) => response.json())
    .then((data) => {
      // get the HTML element with the class "players" and find the <ul> inside it
      const playersList = document.querySelector(".players ul");
    });
}

function getBoardURL() {
  const currentUrl = window.location.href;
  return currentUrl;
}

function getBoardCode() {
  const currentUrl = getBoardURL();

  let code = currentUrl;
  if (code.endsWith('/')) {
      code = code.slice(0, -1); // Remove the trailing '/'
  }
  code = code.substring(code.lastIndexOf('/') + 1);
  return code;
}
//re-render playerlist and scores
function reRenderPlayerlist(){
  // get the HTML element with the class "players" and find the <ul> inside it
  const playersList = document.querySelector(".players ul");

  // remove the hard coded player names & scores
  playersList.innerHTML = "";

   // will append the player names and scores dynamically
   data.players.forEach((player) => {
    let listItem = playersList.querySelector(`li[data-player-name="${player.name}"]`);

    // create list item if it doesn't exist
    if (!listItem) {
        listItem = document.createElement("li");
        listItem.setAttribute("data-player-name", player.name);
        listItem.innerHTML = `${player.name}: <span class="score">${player.score}</span>`;
        playersList.appendChild(listItem);
    } else {
      // update score
      const scoreSpan = listItem.querySelector(".score");
      scoreSpan.textContent = player.score;
    }

    //let listItem = document.createElement("li");
    //listItem.innerHTML = `${player.name}: <span class="score">${player.score}</span>`;
    //playersList.appendChild(listItem); 
    //FIX THIS - handle append problem, currently infinitely adds children. by using name
    //update score each poll
});
}
//scratches out desired word in wordbank
//local scratch may disappear for a second on first poll
function updateWordsFoundWordbank(word){
  const wordBankList = document.getElementById("wordBankList");
  const wordBankItems = wordBankList.getElementsByTagName("li");
  //iterate through wordbankitems first
  //FIX
  //wordBankItems[i].style.textDecoration = "line-through"; // crosses out words when found


}
function updateBoard(){
  let request = new XMLHttpRequest();
    
  request.onreadystatechange = function () {
    if (request.readyState == 4) {
      if (request.status == 200) {
        data = JSON.parse(request.responseText);
        //this checks to see if we have already found this word
        Object.keys(data).forEach(key => {
          if(!foundWords.includes(data.key)){
            drawWord(data.key);
            foundWords.push(key)
            updateWordsFoundWordbank(key);
            }
        });
        reRenderPlayerlist(data.players);

        if(data.ended === 'true'){
          //handle game end
        }
      } else {
        console.log("AJAX Error: " + request.responseText);
      }
    }
  };
  var boardCode = getBoardCode();
  var url = "../getBoardUpdates.php?game=" + boardCode;
  request.open("GET", url);
  request.send();
}
function drawWord(){
//draws word on board based on word data
//will assgin random color
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
        if (!td.classList.contains("found") && !mouseIsPressed) {
          td.style.backgroundColor = randomColor();
          td.style.fill = randomColor();
        }
        if (mouseIsPressed) {
          if (selectedCells.length < 2) {
            selectedCells.push(td);
            if (selectedCells.length === 2) {
              direction = getDirection(selectedCells[0], selectedCells[1]);
            }
          } else {
            const newDirection = getDirection(
              selectedCells[selectedCells.length - 1],
              td
            );
            if (newDirection === direction) {
              // highlightSelectedCells();
              selectedCells.push(td);
            }
          }
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
        if (!selectedCells.includes(td) && !td.classList.contains("found")) {
          td.style.backgroundColor = "transparent";
          td.style.fill = "transparent";
        }
      });
    });
  });
}

function getDirection(cell1, cell2) {
  // Calculate the direction based on the difference in row and column indexes
  const rowDiff = cell2.parentNode.rowIndex - cell1.parentNode.rowIndex;
  const colDiff = cell2.cellIndex - cell1.cellIndex;

  if (rowDiff === 0 && colDiff === 1) {
    return "E"; // East
  } else if (rowDiff === 1 && colDiff === 1) {
    return "SE"; // Southeast
  } else if (rowDiff === 1 && colDiff === 0) {
    return "S"; // South
  } else if (rowDiff === 1 && colDiff === -1) {
    return "SW"; // Southwest
  } else if (rowDiff === 0 && colDiff === -1) {
    return "W"; // West
  } else if (rowDiff === -1 && colDiff === -1) {
    return "NW"; // Northwest
  } else if (rowDiff === -1 && colDiff === 0) {
    return "N"; // North
  } else if (rowDiff === -1 && colDiff === 1) {
    return "NE"; // Northeast
  }
  return null; // Unknown direction
}

function highlightSelectedCells() {
  selectedCells.forEach((cell) => {
    if (!cell.classList.contains("found")) {
      cell.style.backgroundColor = randomColor();
      cell.style.fill = randomColor();
    }
  });
}

function unhighlightSelectedCells() {
  selectedCells.forEach((cell) => {
    if (!cell.classList.contains("found")) {
      cell.style.backgroundColor = "transparent";
      cell.style.fill = "transparent";
    }
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

  let minValue = 150; // Minimum RGB value to avoid being too close to black (adjust as needed)
  let maxValue = 255; // Maximum RGB value to avoid being too close to white (adjust as needed)
  for (let i = 0; i < 3; i++) {
    // color.push(Math.floor(Math.random() * 225) + 50);
    color.push(
      Math.floor(Math.random() * (maxValue - minValue + 1) + minValue)
    );
  }

  return "rgb(" + color.join(", ") + ")";
}
