<?php
/* This function is responsible for the ititial data needed by the client to setup their board
    Accepted methods: POST only
    Required headers:
        1. game: game id (including the prefix)
        2. token: access token of requester

    Return: PuzzleStructure object (see docs)
*/
    $INCLUDE_PATH = require "../includePath.php";
    require_once "$INCLUDE_PATH/gameConfig.php";
    require "$INCLUDE_PATH/utilities/getPlayer.php";
    require "$INCLUDE_PATH/utilities/sanitizePlayers.php";
    require "$INCLUDE_PATH/utilities/fileSyncronization.php";
    require "$INCLUDE_PATH/utilities/requestValidation.php";
    require "$INCLUDE_PATH/utilities/validateGame.php";

    // checks that a given player is eligible to retrieve the game board
    // exits if ineligible
    function validateEligibility($player) {
        // verify the user has not already requested the board
        // ensures multiple people do not use the same access ID to solve
        // the puzzle in parallel
        if ($player["boardRetrieved"] == true) {
            echo "you have already retrieved the board";
            http_response_code(403);
            exit(-1);
        }
    }

    function main() {
        validatePOST(array("game", "token"), true); // validate request

        $token = $_SERVER["HTTP_TOKEN"];
        $gameID = $_SERVER["HTTP_GAME"];
        $gamefilePath = "$gameID/" . GAME_DATAFILE_NAME;
        validateGame($gameID, true); // validate game exists

        // if request is valid fetch puzzle file
        $gameStream = flock_acquireEX($gamefilePath); // modifying board state
        $puzzle = json_decode(fread($gameStream, filesize($gamefilePath)), true);
        $player_index = util_get_player_index($token, $puzzle["players"]);

        if ($player_index == -1) {
            http_response_code(400);
            echo "player not found for this game instance";
            exit(-1);
        }

        if ($puzzle["ended"] == true) {
            http_response_code(403);
            echo "game has already ended";
            exit(-1);
        }

        $playerData = $puzzle["players"][$player_index];
        validateEligibility($playerData); // validate player can retrieve board

        // update puzzle data with player's board retrieval marked and write data back to file
        // ignore for test environment so board doesn't have to be reset every time
        if ($gameID != "testenv") {
            $puzzle["players"][$player_index]["boardRetrieved"] = true;
        }

        rewind($gameStream); // rewind stream and truncate to overwrite file
        ftruncate($gameStream, 0);
        fwrite($gameStream, json_encode($puzzle));
        flock_release($gameStream); // release lock

        $response = array(
            "puzzle" => $puzzle["puzzle"],
            "words" => $puzzle["words"],
            "startTime" => $puzzle["startTime"],
            "expireTime" => $puzzle["expireTime"],
            "foundWords" => $puzzle["foundWords"],
            "theme" => $puzzle["theme"],
            "players" => util_sanitize_players($puzzle["players"])
        );

        http_response_code(200);
        echo json_encode($response);
    }

    main();
?>