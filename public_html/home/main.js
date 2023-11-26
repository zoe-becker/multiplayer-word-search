let requestingLobbyLock = false;

function createLobby() {
  if (requestingLobbyLock == false) {
    // start request for new board
    requestingLobbyLock = true;
    let request = new XMLHttpRequest();

    // handle response
    request.onreadystatechange = function () {
      if (request.readyState == 4) {
        requestingLobbyLock = false; // free lock here due to back/forward caches
        if (request.status == 200) {
          window.location.href = request.responseText;
        } else {
          console.log("AJAX Error:" + request.responseText);
        }
      }
    };

    // send request
    request.open("GET", "createLobby.php");
    request.send();
  }
}

document.addEventListener("DOMContentLoaded", function () {
  const gameForm = document.getElementById("gameForm");
  const gameCode = document.getElementById("gameCode");
  const result = document.getElementById("result");
  const joinButton = document.getElementById("joinButton");

  joinButton.addEventListener("click", function () {
    const input = gameCode.value.trim();
    if (isValidGameCode(input)) {
      window.location.href = `../lobby/${input}`;
    } else {
      alert("Invalid game code.");
    }
  });

  // Function to validate game code format
  function isValidGameCode(code) {
    const regex = /^lb-[0-9a-fA-F]{13}$/;
    return regex.test(code);
  }
});

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
