let requestingLobbyLock = false;

function createLobby() {
    if (requestingLobbyLock == false) {
        // start request for new board
        requestingLobbyLock = true;
        let request = new XMLHttpRequest();

        // handle response
        request.onreadystatechange = function() {
            if (request.readyState == 4) {
                if (request.status == 200) {
                    location.href = request.responseText;
                } else {
                    console.log("AJAX Error:" + request.responseText);
                    requestingLobbyLock = false; // allow user to try again
                }
            }
        }

        // send request
        request.open("POST", "createLobby.php");
        request.send();
    }
}