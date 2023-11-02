let requestingLobbyLock = false;

function createLobby() {
  if (requestingLobbyLock == false) {
    // start request for new board
    requestingLobbyLock = true;
    let request = new XMLHttpRequest();

    // handle response
    request.onreadystatechange = function () {
      if (request.readyState == 4) {
        if (request.status == 200) {
          location.href = request.responseText;
        } else {
          console.log("AJAX Error:" + request.responseText);
          requestingLobbyLock = false; // allow user to try again
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
      const fullURL = `http://localhost/word-search-generator/lobby/${input}`;
      window.open(fullURL, "_blank");
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
