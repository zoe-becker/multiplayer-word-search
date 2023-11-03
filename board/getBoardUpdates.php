<?php
/* This function is responsible for the ititial data needed by the client to setup their board
    Accepted methods: GET only
    Required query parameters:
        1. game: game id (including the prefix)

    Return: PuzzleState object (see docs)
*/
    require "../utilities/sanitizePlayers.php";
    require "../utilities/fileSyncronization.php";
    require "../utilities/requestValidation.php";
    require "validateGame.php";
    require "updateDB.php";

    $GAMEFILE_NAME = "puzzle.json";

    // check whether game is expired
    // returns true if the game has expired
    function checkGameExpiration(&$puzzle) {
        $isExpired = false;

        // check if game is expired
        if ($puzzle["expireTime"] <= time()) {
            $isExpired = true;
            if ($puzzle["dbUpdated"] == false) {
                foreach ($puzzle["players"] as $player) {
                    updateDataBase($player["name"], $player["score"], $puzzle["theme"]);
                }
            }
            $puzzle["dbUpdated"] = true;
        }

        return $isExpired;
    }
    function main() {
        global $GAMEFILE_NAME;
        validateGET(array("game"), true); // validate request

        date_default_timezone_set("UTC"); // keep timezone consistent
        $gameID = $_GET["game"];
        $gamefilePath = "$gameID/$GAMEFILE_NAME";

        validateGame($gameID, true); // validate game exists

        $puzzle = json_decode(flock_read_and_release($gamefilePath), true); // read data
    
        $expired = checkGameExpiration($puzzle); // see if game has expired
        
        $responseObject = array(
            "expired" => $expired,
            "foundWords" => $puzzle["foundWords"],
            "players" => util_sanitize_players($puzzle["players"])
        );

        http_response_code(200);
        echo json_encode($responseObject);
    }

    main();
?>