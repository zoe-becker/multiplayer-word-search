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

function submitTimeAttack() {
  username = document.getElementById("username").value;
  if (username.length < 1 || username.length > 13) {
    alert(
      "Invalid username. Username should be between 1 and 13 characters long."
    );
  } else {
    let request = new XMLHttpRequest();

    request.onreadystatechange = function () {
      if (request.readyState == 4) {
        if (request.status == 200) {
          // response has many <> tags and warnings that need to be stripped
          resp = request.response.split("\n");
          last_line = resp[resp.length - 1];
          data = JSON.parse(last_line);
          localStorage.setItem("accessToken", data.accessToken);
          //redirect to link
          window.location.href = data.link[0];
        } else {
          console.log("AJAX Error: " + request.responseText);
        }
      }
    };
    request.open("POST", "createSoloGame.php");
    request.setRequestHeader("name", username);
    request.send();
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
