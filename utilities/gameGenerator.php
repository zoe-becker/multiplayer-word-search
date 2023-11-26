<?php
    // contains the function for generating game instances
    require_once __DIR__ . "/../config/gameConfig.php";
    require_once __DIR__ . "/../config/envConfig.php";
    require __DIR__ . "/themeFetcher.php";

    $GENERATOR_PATH = __DIR__ . "/../generator";
    $GAME_DIR = "../board";
    $INSTANCE_TEMPLATE_DIR = $GAME_DIR . "/template";

    // calls the generator and returns a GamePuzzle object
    // parameters:
    // $theme: the word search theme to generate from
    // $players: the list of players to populate the GamePuzzle object with
    // $mode: the game mode to use ("multiplayer", "timeattack")
    // 
    // returns: the game link to the newly created instance on success, false otherwise
    function generateGameInstance($theme, $players, $mode) {
        global $GAME_DIR, $INSTANCE_TEMPLATE_DIR, $GENERATOR_PATH;

        $themePath = getThemeFilePath($theme);
        $command = PYTHON_INTERPRETER_PATH . " " . $GENERATOR_PATH . "/generate.py" . " $themePath " . GENERATOR_WORD_COUNT;
        echo $command;
        // ask generator make a grid
        $result = exec($command);
        echo $result;
        // interpret curl result and initialize board
        if ($result) {
            $puzzle = json_decode($result, true);
            $puzzle["startTime"] = time() + 5; // Added 5 sec delay
            $puzzle["expireTime"] = time() + ($mode == "multiplayer" ? MULTIPLAYER_GAME_LEN : TIMEATTACK_GAME_LEN);
            $puzzle["instanceExpiration"] = $puzzle["expireTime"] + GAME_INSTANCE_EXPIRATION_DELAY;
            $puzzle["foundWords"] = new stdClass(); // empty map
            $puzzle["ended"] = false;
            $puzzle["players"] = $players;
            $puzzle["dbUpdated"] = false;
            $puzzle["gameMode"] = $mode;
            

            // extract theme data and add it to board data
            $themeData = getThemeData($theme);
            unset($themeData["words"]); // unnecessary
            $puzzle["theme"] = $themeData;
            $puzzle["theme"]["name"] = $theme;
            $puzzle = json_encode($puzzle);
            
        } else {
            http_response_code(500);
            echo "could not fetch word search board from generator.";
            return false;
        }

        /* create new game instance */
        $instanceID = "ws-" . uniqid();
        $instanceDir = $GAME_DIR . "/" . $instanceID;

        // create instance folder
        if (!mkdir($instanceDir)) {
            http_response_code(500);
            echo "could not create instance.";
            return false;
        }

        // copy files from template
        $files = scandir($INSTANCE_TEMPLATE_DIR);

        foreach($files as $file) {
            if ($file == "." || $file == "..") continue;

            $success = copy($INSTANCE_TEMPLATE_DIR . "/$file", $instanceDir . "/$file");
            if (!$success) {
                http_response_code(500);
                echo "failed copying files to new instance.";
                return false;
            }
        }

        // store puzzle json in text file, change permissions so users cannot access answers
        file_put_contents($instanceDir . "/" . GAME_DATAFILE_NAME, $puzzle);
        chmod($instanceDir . "/" . GAME_DATAFILE_NAME, 0660);

        // update lobby to indicate game has started
        $gameLink = "../" . $instanceDir . "/"; // add extra ../ since clients are in an instance directory

        return $gameLink;
    }

?>