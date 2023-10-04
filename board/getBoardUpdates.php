<?php
/* This script is responsible for returning updates to polling clients about the board, game expiration, etc.
    Additionally, contains logic for when game gets marked as expired.
*/
    // check request method
    if ($_SERVER["REQUEST_METHOD"] != "GET") {
        http_response_code(405);
    }

    date_default_timezone_set("UTC"); // keep timezone consistent
    
    $puzzle = file_get_contents($puzzle);
    $responseObject = array(
        "expired" => false,
        "foundWords" => array()
    );

    if (!$puzzle) {
        http_response_code(500);
        return "could not get board updates";
    }

    $puzzle = json_decode($puzzle,true);

    // check if game is expired
    if ($puzzle["expiration"] <= time()) {
        $responseObject["expired"] = true;
    }

    /* TODO: logic for returning found words */
    http_response_code(200);
    return json_encode($responseObject);

?>