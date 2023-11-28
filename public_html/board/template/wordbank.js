let selectedCells = []; // to store the TD elements being selected
let direction = null; // Variable to store the current direction
let mouseIsPressed = false; // global variable to check if mouse is pressed or not
let foundWords = []; // stores the found words
let highlightColors = [];
let gameEndTime = 0;
let startTime = 0;
let gameLength = 0;
let cellMatrix = [];
let isHomeButtonClicked = false;
let timerIntervalObj;
let pollingIntervalObj;
let themeAssets = "../../themes/themeAssets/";

document.addEventListener("DOMContentLoaded", function (event) {
  pollingIntervalObj = setInterval(updateBoard, 2000);
});

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
  // if homebutton flag isn't clicked, prevent refresh
  if (!isHomeButtonClicked) {
    event.preventDefault();
  }
});

function getInitialBoard() {
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
        });

        // set up timer
        gameEndTime = data.expireTime;
        startTime = data.startTime;
        ticktok();
        timerIntervalObj = setInterval(ticktok, 1000);
        // draw the word search
        renderWordSearch(data.puzzle);
        reRenderPlayerlist(data.players);
      } else if (request.status == 403) {
        window.location.href = "../../home";
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
}

// calls for startSplashScreenCountdown function
document.addEventListener("DOMContentLoaded", function (event) {
  startSplashScreenCountdown();
});

// function for splash screen countdown
function startSplashScreenCountdown() {
  const splashScreen = document.getElementById("splash-screen");
  const countdownElement = document.getElementById("countdown");

  // fetch the start time from local storage
  let startTime = parseInt(localStorage.getItem("startTime"), 10);

  // if startTime is not a number, fallback to a 5 seconds countdown
  if (isNaN(startTime)) {
    console.error(
      "Invalid startTime from local storage, falling back to a 5 second countdown"
    );
    startTime = Math.floor(Date.now() / 1000) + 5;
  }

  const currentTime = Math.floor(Date.now() / 1000);

  // calculate the time left until the start time
  let timeLeft = startTime - currentTime;

  // this should never happen, but just in case, set a fallback
  if (timeLeft < 0) {
    console.error("Time left is less than zero, starting the game immediately");
    splashScreen.style.display = "none";
    getInitialBoard(); // start the game immediately
    return; // exit the function
  }

  // update the countdown every second
  countdownElement.textContent = timeLeft;
  const interval = setInterval(() => {
    countdownElement.textContent = timeLeft;

    if (timeLeft <= 0) {
      clearInterval(interval);
      splashScreen.style.display = "none";

      getInitialBoard(); // start the game
    }

    timeLeft--;
  }, 1000);
}

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

  // set the highlight colors to theme colors :)
  if (dataTheme.highlightColors) {
    highlightColors = dataTheme.highlightColors;
  }
}

function getBoardURL() {
  const currentUrl = window.location.href;
  return currentUrl;
}

function getBoardCode() {
  const currentUrl = getBoardURL();

  let code = currentUrl;
  if (code.endsWith("/")) {
    code = code.slice(0, -1); // Remove the trailing '/'
  }
  code = code.substring(code.lastIndexOf("/") + 1);
  return code;
}
//re-render playerlist and scores
function reRenderPlayerlist(players) {
  // get the HTML element with the class "players" and find the <ul> inside it
  const playersList = document.querySelector(".players ul");

  // remove the hard coded player names & scores
  playersList.innerHTML = "";

  // will append the player names and scores dynamically
  players.forEach((player) => {
    let listItem = document.createElement("li");
    listItem.innerHTML = `${player.name}: <span class="score">${player.score}</span>`;
    playersList.appendChild(listItem);
    //FIX THIS - handle append problem, currently infinitely adds children. by using name
    //update score each poll
  });
}
//scratches out desired word in wordbank
//local scratch may disappear for a second on first poll
function updateWordsFoundWordbank(word) {
  const wordBankList = document.getElementById("wordBankList");
  const wordBankItems = Array.from(wordBankList.getElementsByTagName("li"));

  wordBankItems.forEach((element) => {
    if (element.textContent == word) {
      element.style.textDecoration = "line-through";
    }
  });
}

function updateBoard() {
  let request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.readyState == 4) {
      if (request.status == 200) {
        data = JSON.parse(request.responseText);
        //this checks to see if we have already found this word
        Object.keys(data.foundWords).forEach((key) => {
          if (!foundWords.includes(key)) {
            drawWord(key, data.foundWords[key]);
            foundWords.push(key);
            updateWordsFoundWordbank(key);
          }
        });

        reRenderPlayerlist(data.players);
        if (data.expired == true) {
          //handle game end
          clearInterval(pollingIntervalObj);
          ticktok(); // final timer update
          clearInterval(timerIntervalObj);
          //sort playerlist
          data.players.sort((a, b) => b.score - a.score);
          //add event listeners to home button
          homeButtonFunctionality();
          closeModal();
          //load final results page
          populateFinalResults(data.players);

          // add slight delay from game end to answers / leaderboard shown
          setTimeout(() => {
            // show unfound words
            Object.keys(data.key).forEach((key) => {
              if (!foundWords.includes(key)) {
                drawWord(key, data.key[key]);
                foundWords.push(key);
              }
            });

            //winners get confetti, losers cry
            toggleScreen("final-results-screen", "show");
            if (data.players[0].name === localStorage.getItem("playerName")) {
              winnerConfetti();
            }
          }, 3000);
          //use 'hide' on same call to hide the screen
          //but since its the end of game i have no call for it.
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

//draws word on board based on word data
//will assgin random color
function drawWord(word, foundWordinfo) {
  let startRow = foundWordinfo.start_row;
  let startCol = foundWordinfo.start_col;
  let rowIdxIncrement = 0;
  let colIdxIncrement = 0;
  let wordColor = randomColor();

  switch (foundWordinfo.direction) {
    case "N":
      rowIdxIncrement--;
      break;
    case "E":
      colIdxIncrement++;
      break;
    case "S":
      rowIdxIncrement++;
      break;
    case "W":
      colIdxIncrement--;
      break;
    case "NE":
      colIdxIncrement++;
      rowIdxIncrement--;
      break;
    case "SE":
      colIdxIncrement++;
      rowIdxIncrement++;
      break;
    case "NW":
      colIdxIncrement--;
      rowIdxIncrement--;
      break;
    case "SW":
      colIdxIncrement--;
      rowIdxIncrement++;
      break;
  }

  for (let i = 0; i < word.length; i++) {
    cell =
      cellMatrix[startRow + i * rowIdxIncrement][
        startCol + i * colIdxIncrement
      ];
    cell.style.backgroundColor = wordColor;
    cell.classList.add("found");
  }
}

function renderWordSearch(puzzle) {
  let table = document.createElement("table");
  const container = document.getElementById("wordsearch");
  container.appendChild(table); // Draw the main table node on the document

  puzzle.forEach(function (row, rIdx) {
    let tr = table.insertRow(); //Create a new row
    let matrixRow = [];
    row.forEach(function (column, cIdx) {
      let td = tr.insertCell();

      matrixRow.push(td); // add cell to internal matrix
      td.setAttribute("data-content", column);
      td.setAttribute("cellIndex", JSON.stringify({ row: rIdx, col: cIdx }));
      // cell hover is set to a random color
      td.addEventListener("mouseenter", (event) => {
        // as long as the letter is not part of a found word
        if (!td.classList.contains("found") && !mouseIsPressed) {
          // if cell is not empty
          if (td.getAttribute("data-content") !== "") {
            td.style.backgroundColor = randomColor();
            td.style.fill = randomColor();
        }
        // when mouse is pressed start the selection of the word
        }
        if (mouseIsPressed) {
          if (selectedCells.length < 2 && td.getAttribute("data-content") !== "") {
            if (selectedCells.length === 0) {
              selectedCells.push(td);
            } else if (selectedCells.length === 1 && getDirection(selectedCells[0], td) !== null) {
              selectedCells.push(td);
              direction = getDirection(selectedCells[0], selectedCells[1]);
              console.log(direction);
            }
            // check if the next cell selected is in the same direction
          } else {
            const newDirection = getDirection(
              selectedCells[selectedCells.length - 1],
              td
            );
            if (newDirection === direction) {
              selectedCells.push(td);
            }
          }
          highlightSelectedCells();
        }
      });

      td.addEventListener("mousedown", (event) => {
        if (td.getAttribute("data-content") !== ""){
          mouseIsPressed = true;
          selectedCells = [td]; // Start new selection
        }
        
      });

      document.addEventListener("mouseup", function () {
        mouseIsPressed = false;
        let selectedWord = selectedCells
          .map((cell) => cell.getAttribute("data-content"))
          .join(""); // concatenates the letters in the selected cells
        checkWordInWordBank(selectedWord);
      });

      // reset the background to transparent once the cursor leaves the cell
      td.addEventListener("mouseleave", (event) => {
        if (!selectedCells.includes(td) && !td.classList.contains("found")) {
          td.style.backgroundColor = "transparent";
          td.style.fill = "transparent";
        }
      });
    });

    cellMatrix.push(matrixRow);
  });
}

// Determine the direction of the highlight(in order to "lock" direction)
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
    // if cell is not part of a found word, should be highlightable
    if (!cell.classList.contains("found") && cell.getAttribute("data-content") !== "") {
      cell.style.backgroundColor = randomColor();
      cell.style.fill = randomColor();
    }
  });
}

function unhighlightCells(cells) {
  cells.forEach((cell) => {
    // only unhighlight when the cell is not part of a found word
    if (!cell.classList.contains("found")) {
      cell.style.backgroundColor = "transparent";
      cell.style.fill = "transparent";
    }
  });
}

function checkWordInWordBank(word) {
  const wordBankList = document.getElementById("wordBankList");
  const wordBankItems = wordBankList.getElementsByTagName("li");
  let wordColor = randomColor();
  let wordFound = false;
  let queryCells = Array.from(selectedCells);

  for (let i = 0; i < wordBankItems.length; i++) {
    if (wordBankItems[i].textContent === word && !foundWords.includes(word)) {
      let validateRequest = new XMLHttpRequest();
      let wordIdx = JSON.parse(queryCells[0].getAttribute("cellIndex"));
      let wordinfo = {
        // required header
        direction: direction,
        startRow: wordIdx.row,
        startCol: wordIdx.col,
        word: word,
      };

      wordFound = true; // hold the selected cells as highlighted pending validation
      validateRequest.onreadystatechange = function () {
        if (validateRequest.readyState == 4) {
          if (validateRequest.status == 200) {
            // word found, make confetti and set cell to found and solid color
            let lastCell = queryCells[queryCells.length - 1];
            let rect = lastCell.getBoundingClientRect();
            let x = (rect.left + rect.right) / 2 / window.innerWidth;
            let y = (rect.top + rect.bottom) / 2 / window.innerHeight;

            // Set the same color for all cells in the found word
            queryCells.forEach((cell) => {
              cell.style.backgroundColor = wordColor;
              cell.style.fill = wordColor;
            });

            wordBankItems[i].style.textDecoration = "line-through"; // crosses out words when found
            triggerConfetti(x, y);

            // set each letter in the word to found
            queryCells.forEach((cell) => {
              cell.classList.add("found");
            });

            foundWords.push(word);
            reRenderPlayerlist(JSON.parse(validateRequest.responseText)); // instantly update score
          } else {
            console.log("AJAX Error: " + validateRequest.responseText);
            unhighlightCells(queryCells);
          }
        }
      };

      // create request to server for word validation
      validateRequest.open("POST", "../validateWord.php");
      validateRequest.setRequestHeader(
        "token",
        localStorage.getItem("accessToken")
      );
      validateRequest.setRequestHeader("game", getBoardCode());
      validateRequest.setRequestHeader("wordinfo", JSON.stringify(wordinfo));
      validateRequest.send();
      break;
    }
  }

  if (!wordFound) {
    // unhighlight immediately if not a word by local computation
    unhighlightCells(queryCells);
  }

  selectedCells = []; // clears selected cells in all cases

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

// Generate Random colors for letter/cell highlighting
function randomColor() {
  // if theme is selected, use preset colors
  if (highlightColors) {
    const randomIndex = Math.floor(Math.random() * highlightColors.length);
    return highlightColors[randomIndex];
  } else {
    let color = [];
    let minValue = 150; // Minimum RGB value to avoid being too close to black (adjust as needed)
    let maxValue = 255; // Maximum RGB value to avoid being too close to white (adjust as needed)
    for (let i = 0; i < 3; i++) {
      color.push(
        Math.floor(Math.random() * (maxValue - minValue + 1) + minValue)
      );
    }
    return "rgb(" + color.join(", ") + ")";
  }
}

//HIDING OR SHOWING SCREENS
function toggleScreen(screenId, action) {
  var screen = document.getElementById(screenId);
  if (screen) {
    if (action === "show") {
      screen.classList.remove("hidden");
    } else if (action === "hide") {
      screen.classList.add("hidden");
    }
  }
}

function populateFinalResults(players) {
  var rank = 1;
  var finalResultsPlayerList = document.getElementById(
    "final-results-player-list"
  );
  players.forEach((player) => {
    //create a new final-player-box element
    var finalPlayerBox = document.createElement("div");
    finalPlayerBox.classList.add("final-player-box");

    //create a final-player-rank element with the player's rank
    var finalPlayerRank = document.createElement("div");
    finalPlayerRank.classList.add("final-player-rank");
    var rankParagraph = document.createElement("p1");
    rankParagraph.textContent = rank + ".";
    finalPlayerRank.appendChild(rankParagraph);

    //create a final-player-info element with the player's name and score
    var finalPlayerInfo = document.createElement("div");
    finalPlayerInfo.classList.add("final-player-info");
    var nameParagraph = document.createElement("p1");
    nameParagraph.textContent = "Name: " + player.name;
    var scoreParagraph = document.createElement("p1");
    scoreParagraph.textContent = "Score: " + player.score;
    finalPlayerInfo.appendChild(nameParagraph);
    finalPlayerInfo.appendChild(scoreParagraph);

    //append finalPlayerRank and finalPlayerInfo to finalPlayerBox
    finalPlayerBox.appendChild(finalPlayerRank);
    finalPlayerBox.appendChild(finalPlayerInfo);

    //append finalPlayerBox to the finalResultsPlayerList
    finalResultsPlayerList.appendChild(finalPlayerBox);

    //increment the rank for the next player
    rank++;
  });
}

function winnerConfetti() {
  var end = Date.now() + 15 * 1000;

  // go Buckeyes!
  var colors = ["#bb0000", "#ffffff"];

  (function frame() {
    confetti({
      particleCount: 2,
      angle: 60,
      spread: 55,
      origin: { x: 0 },
      colors: colors,
    });
    confetti({
      particleCount: 2,
      angle: 120,
      spread: 55,
      origin: { x: 1 },
      colors: colors,
    });

    if (Date.now() < end) {
      requestAnimationFrame(frame);
    }
  })();
}

function homeButtonFunctionality() {
  var homeButton = document.getElementById("home-button");

  homeButton.addEventListener("mouseover", function () {
    homeButton.classList.add("brighten");
  });

  homeButton.addEventListener("mouseout", function () {
    homeButton.classList.remove("brighten");
  });
  homeButton.addEventListener("click", function () {
    isHomeButtonClicked = true; // set flag to true
    window.location.href = "../../home/";
  });
}

function closeModal() {
  var closeButton = document.getElementById("close-button");

  closeButton.addEventListener("mouseover", function () {
    closeButton.classList.add("brighten");
  });

  closeButton.addEventListener("mouseout", function () {
    closeButton.classList.remove("brighten");
  });

  closeButton.addEventListener("click", function () {
    toggleScreen("final-results-screen", "hide");
  });
  //toggleScreen('final-results-screen','hide');
}
