<?php
    /* Validates word found requests sent by the client and updates game data
    accordingly
        Accepted methods: POST only
        Required headers:
            1. game: game id
            2. token: access token of the requesting player
            3. wordinfo: json encoded WordInfo object

        return: players key of PuzzleState object
    */
    $GAMEFILE_NAME = "puzzle.json";
    $GAME_LENGTH = 180; 

    require "../utilities/requestValidation.php";
    require "../utilities/fileSyncronization.php";
    require "../utilities/getPlayer.php";
    require "../utilities/sanitizePlayers.php";
    require "validateGame.php";

    /* 
    Word score[base word 300 pts :: every letter more than 4 is an additional 50 pts]  
    time mult[ Green 1x -- Yellow 1.2x -- Red 2x] 
    Direction[horizontal and vertical: 1x -- diagonal 1.2x]

    Where:
    0-50% time left is green 
    1/6 - 50% time left is yellow
    0 - 1/6 time left is red
    */
    function calculateScore($word, $endTime, $direction, $mode) {
        global $GAME_LENGTH;
        $greenThreshold = $GAME_LENGTH * 0.5;
        $yellowThreshold = $GAME_LENGTH * 0.1667;
        $currentTime = time();
        $timeElapsed = $endTime - $currentTime;
        $orientation = "";
        $wordScore = 300;
        $greenMultiplier = 1;
        $yellowMultiplier = 1;
        $redMultiplier = 1;

        // Set multipliers based on game mode
        if ($mode == "multiplayer") {
            $greenMultiplier = 1;
            $yellowMultiplier = 1.2;
            $redMultiplier = 2;
        } else if ($mode == "timeAttack") {
            $greenMultiplier = 2;
            $yellowMultiplier = 1.2;
            $redMultiplier = 1;
        }

        if (strlen($word) > 4) {
            $wordScore += (strlen($word) - 4) * 50;
        }
        
        if ($timeElapsed >= $greenThreshold) {
            $wordScore *= $greenMultiplier; // Green logic
        } else if ($timeElapsed >= $yellowThreshold) {
            $wordScore *= $yellowMultiplier; // Yellow logic
        } else {
            $wordScore *= $redMultiplier; // Red logic
        }

        if ($direction == "N" || $direction == "S") {
            $orientation = "vertical";
        } else if ($direction == "E" || $direction == "W") {
            $orientation = "horizontal";
        } else {
            $orientation = "diagonal";
        }

        switch ($orientation) {
            case "horizontal":
                $wordScore *= 1;
                break;
            case "vertical":
                $wordScore *= 1;
                break;
            case "diagonal":
                $wordScore *= 1.2;
                break;
            default:
                $wordScore *= 1;
                break;
        }

        return $wordScore;
    }

    // validates that given word info is of valid form, specifically that it
    // contains all required keys
    function validateWordInfo($wordInfo) {
        $decoded = json_decode($wordInfo, true);
        $valid = true;

        if ($decoded) {
            if (!array_key_exists("direction", $decoded)) $valid = false;
            if (!array_key_exists("word", $decoded)) $valid = false;
            if (!array_key_exists("startRow", $decoded)) $valid = false;
            if (!array_key_exists("startCol", $decoded)) $valid = false;
        } else {
            $valid = false;
        }

        if (!$valid) {
            http_response_code(400);
            echo "malformed wordinfo";
            exit(-1);
        }
    }

    // Does the full validation of the word against the puzzle key
    // $puzzle: puzzle data as an associative array
    // $wordInfo: associative array (json decoded) WordInfo object
    function checkWord(&$puzzle, $wordInfo) {
        $key = &$puzzle["key"];

        // check that word exists, words are all caps in the key
        if (!array_key_exists($wordInfo["word"], $key)) return false;

        $wordkey = $key[$wordInfo["word"]];

        // verify index and direction are correct
        if ($wordkey["start_row"] != $wordInfo["startRow"]) return false;
        if ($wordkey["start_col"] != $wordInfo["startCol"]) return false;
        if ($wordkey["direction"] != $wordInfo["direction"]) return false;

        // check that word not already found
        if (array_key_exists($wordInfo["word"], $puzzle["foundWords"])) return false;

        return true; // return true if no checks fail
    }

    function main() {
        global $GAMEFILE_NAME;
        validatePOST(["game", "token", "wordinfo"], true); // validate request

        $gameID = $_SERVER["HTTP_GAME"];
        $token = $_SERVER["HTTP_TOKEN"];
        $wordInfoStr = $_SERVER["HTTP_WORDINFO"];
        $gameDataPath = "$gameID/$GAMEFILE_NAME";

        // validate gameID and wordInfo headers
        validateGame($gameID, true);
        validateWordInfo($wordInfoStr);

        $gameStream = flock_acquireEX($gameDataPath); // lock file since we may edit
        $puzzle = json_decode(fread($gameStream, filesize($gameDataPath)), true);
        $wordInfo = json_decode($wordInfoStr, true);

        $wordInfo["word"] = strtoupper($wordInfo["word"]); // words are all caps in the key
        $wordValid = checkWord($puzzle, $wordInfo);
        $plrIndex = util_get_player_index($token, $puzzle["players"]);

        // check that player is in this game
        if ($plrIndex == -1) {
            http_response_code(400);
            echo "player not found for this game";
            exit(-1);
        }

        // check that game hasnt expired
        if (time() >= $puzzle["expireTime"]) {
            http_response_code(400);
            echo "game is already over";
            exit(-1);
        }

        // check that the chosen word is valid
        if (!$wordValid) {
            http_response_code(400);
            echo "word selection invalid";
            exit(-1);
        }

        // if above checks pass, calculate score, increment player score, and add word to found words array
        $player = $puzzle["players"][$plrIndex];
        $wordValue = calculateScore($wordInfo["word"], $puzzle["expireTime"], $wordInfo["direction"], $puzzle["gameMode"]);
        $puzzle["players"][$plrIndex]["score"] += $wordValue;

        $foundWordObj = array(
            "start_row" => $wordInfo["startRow"],
            "start_col" => $wordInfo["startCol"],
            "direction" => $wordInfo["direction"],
            "name" => $player["name"]
        );

        $puzzle["foundWords"][$wordInfo["word"]] = $foundWordObj; // add found word to array
        
        // end game early if all words found
        if (count($puzzle["foundWords"]) == count($puzzle["words"])) {
            $puzzle["ended"] = true;
        }
        rewind($gameStream);
        fwrite($gameStream, json_encode($puzzle));
        flock_release($gameStream);

        http_response_code(200);
        echo json_encode(util_sanitize_players($puzzle["players"]));
    }

    main();
?>