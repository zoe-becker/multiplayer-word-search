<?php
/* This function is responsible for the ititial data needed by the client to setup their board
    Accepted methods: GET only
    Required query parameters:
        1. game: game id (including the prefix)

    Return: PuzzleState object (see docs)
*/
    $INCLUDE_PATH = require "../includePath.php";
    require_once "$INCLUDE_PATH/gameConfig.php";
    require "$INCLUDE_PATH/utilities/sanitizePlayers.php";
    require "$INCLUDE_PATH/utilities/fileSyncronization.php";
    require "$INCLUDE_PATH/utilities/requestValidation.php";
    require "$INCLUDE_PATH/utilities/validateGame.php";
    require "$INCLUDE_PATH/utilities/updateDB.php";

    // check whether game is expired
    // returns true if the game has expired
    // needs gamefilepath to lock file if game is expired so DB can be updated
    function checkGameExpiration(&$puzzle, $gamefilePath) {
        $isExpired = false;

        // check if game is expired
        if ($puzzle["expireTime"] <= time() || $puzzle["ended"]) {
            $isExpired = true;
            
            // initial check to prevent unnecessary file locks
            if ($puzzle["dbUpdated"] == false) {
                $gameStream = flock_acquireEX($gamefilePath); // lock file while DB updating
                $puzzle = json_decode(fread($gameStream, filesize($gamefilePath)), true);

                // final check that DB wasn't already updated since file could have been written between
                // initial read lock in main and lock here
                if ($puzzle["dbUpdated"] == false) {
                    foreach ($puzzle["players"] as $player) {
                        updateDataBase($player["name"], $player["score"]);
                    }
                }

                $puzzle["dbUpdated"] = true; 
                $puzzle["ended"] = true;
                rewind($gameStream);
                ftruncate($gameStream, 0);
                fwrite($gameStream, json_encode($puzzle));
            }
        }

        return $isExpired;
    }
    function main() {
        validateGET(array("game"), true); // validate request

        date_default_timezone_set("UTC"); // keep timezone consistent
        $gameID = $_GET["game"];
        $gamefilePath = "$gameID/" . GAME_DATAFILE_NAME;

        validateGame($gameID, true); // validate game exists

        $puzzle = json_decode(flock_read_and_release($gamefilePath), true); // read data
    
        $expired = checkGameExpiration($puzzle, $gamefilePath); // see if game has expired
        
        $responseObject = array(
            "expired" => $expired,
            "foundWords" => $puzzle["foundWords"],
            "players" => util_sanitize_players($puzzle["players"])
        );

        if ($expired) {
            $responseObject["key"] = $puzzle["key"];
        }

        http_response_code(200);
        echo json_encode($responseObject);
    }

    main();
?>