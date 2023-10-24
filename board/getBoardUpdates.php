<?php
/* This function is responsible for the ititial data needed by the client to setup their board
    Accepted methods: GET only
    Required query parameters:
        1. game: game id (including the prefix)

    Return: PuzzleState object (see docs)
*/
    // check request method
    if ($_SERVER["REQUEST_METHOD"] != "GET") {
        http_response_code(405);
        exit(-1);
    }

    // check query parameters
    if (!array_key_exists("game", $_GET)) {
        http_response_code(400);
        exit(-2);
    }

    date_default_timezone_set("UTC"); // keep timezone consistent
    
    $gameID = $_GET["game"];

    // verify game instance exists
    if (!file_exists($gameID)) {
        echo "invalid instance ID";
        http_response_code(400);
        exit(-3);
    }

    include "../utilities/sanitizePlayers.php";
    $puzzle = json_decode(file_get_contents($gameID), true);

    $responseObject = array(
        "expired" => false,
        "foundWords" => $puzzle["foundWords"],
        "players" => util_sanitize_players($puzzle["players"])
    );

    $puzzle = json_decode($puzzle,true);

    // check if game is expired
    if ($puzzle["expireTime"] <= time()) {
        if ($puzzle["dbUpdated"] == false) {
            include "updateDB.php";
            // SCRUM 90
        }
        $responseObject["expired"] = true;
    }

    
    http_response_code(200);
    return json_encode($responseObject);

?>