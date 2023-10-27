<?php
/* This function is responsible for the ititial data needed by the client to setup their board
    Accepted methods: POST only
    Required headers:
        1. game: game id (including the prefix)
        2. token: access token of requester

    Return: PuzzleStructure object (see docs)
*/
    // validate request method
    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        http_response_code(405);
        exit(-1);
    }

    // validate headers
    if (!array_key_exists("HTTP_TOKEN", $_SERVER) || !array_key_exists("HTTP_GAME", $_SERVER)) {
        http_response_code(400);
        exit(-2);
    }
    
    include "../utilities/getPlayer.php";
    include "../utilities/sanitizePlayers.php";

    $GAMEFILE_NAME = "puzzle.json";
    $token = $_SERVER["HTTP_TOKEN"];
    $gameID = $_SERVER["HTTP_GAME"];

    // validate instance is valid
    if (!file_exists($gameID)) {
        http_response_code(400);
        echo "instance not found";
        exit(-3);
    }

    include "../utilities/fileSyncronization.php";
    // if request is valid fetch puzzle file
    $gamefilePath = "$gameID/$GAMEFILE_NAME";
    $lockedStream = flock_acquireEX($gamefilePath); // modifying board state
    $puzzle = json_decode(fread($lockedStream, filesize($gamefilePath)), true);
    $player = util_get_player($token, $puzzle["players"]);

    // verify player is in the list
    if (!$player) {
        echo "player not found for this game instance";
        http_response_code(400);
        exit(-4);
    }

    // verify the user has not already requested the board
    // ensures multiple people do not use the same access ID to solve
    // the puzzle in parallel
    if ($player["boardRetrieved"] == true) {
        echo "you have already retrieved the board";
        http_response_code(403);
        exit(-5);
    }

    // update puzzle data with player's board retrieval marked
    $player["boardRetrieved"] = true;
    rewind($lockedStream); // rewind stream to overwrite file
    fwrite($lockedStream, json_encode($puzzle));

    $response = array(
        "puzzle" => $puzzle["puzzle"],
        "words" => $puzzle["words"],
        "expireTime" => $puzzle["expireTime"],
        "foundWords" => $puzzle["foundWords"],
        "players" => util_sanitize_players($puzzle["players"])
    );

    flock_release($lockedStream); // release lock
    http_response_code(200);
    echo json_encode($response);
?>