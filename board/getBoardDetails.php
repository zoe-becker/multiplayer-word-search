<?php
// This function is responsible for the ititial data needed by the client to setup their board

    // validate request method
    if ($_SERVER["REQUEST_METHOD"] != "GET") {
        http_response_code(405);
        exit(-1);
    }

    // validate query parameters
    if (!array_key_exists("instance", $_GET)) {
        http_response_code(400);
        exit(-2);
    }

    // validate instance is valid
    if (!file_exists($_GET["instance"])) {
        http_response_code(400);
        echo "instance not found";
        exit(-3);
    }
    
    // if request is valid fetch puzzle file
    $puzzle = json_decode(file_get_contents($_GET["instance"] . "/puzzle.json"), true);

    if ($puzzle) {
        unset($puzzle["key"]); // remove answer key from response 
        http_response_code(200);
        echo json_encode($puzzle);
    } else {
        http_response_code(500);
        echo "Puzzle retrieval error.";
    }
?>