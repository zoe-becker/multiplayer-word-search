<?php
/* This function is responsible for the ititial data needed by the client to setup their board
    Accepted methods: POST only
    Required headers:
        1. game: game id (including the prefix)
        2. token: access token of requester

    Return: PuzzleStructure object (see docs)
*/
    require "../utilities/getPlayer.php";
    require "../utilities/sanitizePlayers.php";
    require "../utilities/fileSyncronization.php";
    require "../utilities/requestValidation.php";
    require "validateGame.php";

    $GAMEFILE_NAME = "puzzle.json";

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
        global $GAMEFILE_NAME;
        validatePOST(array("game", "token"), true); // validate request

        $token = $_SERVER["HTTP_TOKEN"];
        $gameID = $_SERVER["HTTP_GAME"];
        $gamefilePath = "$gameID/$GAMEFILE_NAME";
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
            "expireTime" => $puzzle["expireTime"],
            "foundWords" => $puzzle["foundWords"],
            "players" => util_sanitize_players($puzzle["players"])
        );

        http_response_code(200);
        echo json_encode($response);
    }

    main();
?>