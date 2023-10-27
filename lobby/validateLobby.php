<?php
// Checks for the existence of a lobby with id equal to $id (including the prefix)
// $id: id of the lobby to check
// $quitIfBad: if true, will set the http status code to 400 and emit an appropriate
//  error message, then terminate the script
// return: true if the lobby is valid
function validateLobby($id, $quitIfBad = false) {
    $valid = false;
    if (file_exists($id) && is_dir($id)) {
        $valid = true;
    }

    if (!$valid && $quitIfBad) {
        echo "invalid lobby ID";
        http_response_code(400);
        exit(-3);
    }

    return $valid;
}

?>