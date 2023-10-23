function requestBoard() {
    // start request for new board
    let request = new XMLHttpRequest();

    // handle response
    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            if (request.status == 200) {
                location.href = request.responseText;
            } else {
                console.log("AJAX Error:" + request.responseText);
            }
        }
    }

    // send request
    request.open("POST", "play.php");
    request.send();
}