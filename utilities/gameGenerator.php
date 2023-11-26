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
    function generateGameInstance($theme, $players, $mode, $settings) {
        global $GAME_DIR, $INSTANCE_TEMPLATE_DIR, $GENERATOR_PATH;

        $themePath = getThemeFilePath($theme);
        $difficulty = $settings["difficulty"];
        $size = $settings["size"];
        $shape = $settings["shape"];
        $wordCount = 0;

        // resolve difficulty into format generator uses
        if ($difficulty == "easy") {
            $difficulty = 1;
            $wordCount = GAME_EASY_WORDCOUNT;
        } elseif ($difficulty == "medium") {
            $difficulty = 2;
            $wordCount = GAME_MEDIUM_WORDCOUNT;
        } else {
            $difficulty = 3;
            $wordCount = GAME_HARD_WORDCOUNT;
        }

        // resolve size into format generator uses
        if ($size == "small") {
            $size = GAME_SMALL_GRID_SIZE;
        } else if ($size == "medium") {
            $size = GAME_MEDIUM_GRID_SIZE;
        } else {   
            $size = GAME_LARGE_GRID_SIZE;
        }

        // generate command line command
        // format = [python path] [generate.py path] [theme file path] [word count] [difficulty] [grid size] [shape]
        $command = PYTHON_INTERPRETER_PATH . " " . 
            $GENERATOR_PATH . "/generate.py" . 
            " $themePath " .
            " $wordCount " .
            " $difficulty " .
            " $size" . 
            " $shape";

        // ask generator make a grid
        $result = exec($command);

        // interpret curl result and initialize board
        if ($result) {
            $puzzle = json_decode($result, true);
            $puzzle["startTime"] = time() + 5; // Added 5 sec delay
            $puzzle["expireTime"] = time() + ($mode == "multiplayer" ? MULTIPLAYER_GAME_LEN : TIMEATTACK_GAME_LEN) + 5;
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

        return array($gameLink, $puzzle["startTime"]);
    }

?>