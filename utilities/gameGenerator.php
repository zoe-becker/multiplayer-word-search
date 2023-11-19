<?php
    // contains the function for generating game instances
    require "themeFetcher.php";

    $GAME_DIR = "../board";
    $INSTANCE_TEMPLATE_DIR = $GAME_DIR . "/template";
    $GAME_LENGTH = 180;
    $INSTANCE_EXPIRATION_DELAY = 300; // amount of time after game ends before it is eligible to be deleted

    // calls the generator and returns a GamePuzzle object
    // parameters:
    // $theme: the word search theme to generate from
    // $players: the list of players to populate the GamePuzzle object with
    // $mode: the game mode to use ("multiplayer", "timeattack")
    // 
    // returns: the game link to the newly created instance on success, false otherwise
    function generateGameInstance($theme, $players, $mode) {
        global $GAME_LENGTH, $INSTANCE_EXPIRATION_DELAY, $GAME_DIR, $INSTANCE_TEMPLATE_DIR;

        // curl to generator for new grid
        $requestURI = "http://" . $_SERVER["SERVER_NAME"] . 
            "/word-search-generator/generator?theme=" . $theme;
        $request = curl_init($requestURI);

        curl_setopt($request, CURLOPT_RETURNTRANSFER, true); // to get response back
        curl_setopt($request, CURLOPT_FOLLOWLOCATION, true); // deployment server redirects http to https

        $puzzle = curl_exec($request);
        $curlStatus = curl_getinfo($request, CURLINFO_HTTP_CODE);

        // interpret curl result and initialize board
        if ($curlStatus == 200) {
            
            $puzzle = json_decode($puzzle, true);
            $puzzle["startTime"] = time();
            $puzzle["expireTime"] = time() + $GAME_LENGTH; // set match expiration date
            $puzzle["instanceExpiration"] = $puzzle["expireTime"] + $INSTANCE_EXPIRATION_DELAY;
            $puzzle["foundWords"] = new stdClass(); // empty map
            $puzzle["ended"] = false;
            $puzzle["players"] = $players;
            $puzzle["dbUpdated"] = false;
            $puzzle["gameMode"] = $mode;
            

            // extract theme data and add it to board data
            $themeData = getThemeData($theme);
            unset($themeData["words"]);
            $puzzle["theme"] = $themeData;
            $puzzle["theme"]["name"] = $theme;
            $puzzle = json_encode($puzzle);
            
        } else {
            http_response_code(500);
            echo "could not fetch word search board from generator. Curl error: " . curl_error($request);
            return false;
        }
        
        // close request
        curl_close($request);

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
        file_put_contents($instanceDir . "/puzzle.json", $puzzle);
        chmod($instanceDir . "/puzzle.json", 0660);

        // update lobby to indicate game has started
        $gameLink = "../" . $instanceDir . "/"; // add extra ../ since clients are in an instance directory

        return $gameLink;
    }

?>