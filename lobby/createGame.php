<?php
    /* This function is responsible for starting a game from a lobby at the host's request
       Accepted methods: POST only
       Required headers:
          1. token: access token of the requester (the requester must be the lobby host)
          2. lobby: lobby id (including the prefix)

        Return: Relative path to the newly created game instance
    */
    // verify request method
    require "../utilities/requestValidation.php";
    require "../utilities/fileSyncronization.php";
    require "../utilities/themeFetcher.php";
    require "validateLobby.php";

    $GAME_DIR = "../board";
    $INSTANCE_TEMPLATE_DIR = $GAME_DIR . "/template";
    $LOBBY_DATAFILE_NAME = "lobbyData.json";
    $GAME_LENGTH = 180;
    $INSTANCE_EXPIRATION_DELAY = 300; // amount of time after game ends before it is eligible to be deleted


    // validate that game has not started and that the player is the host
    // exits if invalid
    // $lobbyData: associative array of lobby data
    // $token: token of the player making the request
    function validateRequest(&$lobbyData, $token) {
        $players = $lobbyData["players"];

        // check that game has not already started
        if ($lobbyData["gameLink"]) {
            echo "game already started";
            http_response_code(400);
            exit(-1);
        }

        // check that the requester is the host
        $foundPlayer = false;
        foreach ($players as $player) {
            if ($player["accessToken"] == $token) {
                if ($player["isHost"]) {
                    $foundPlayer = true;
                    break;
                }
            }
        }

        if (!$foundPlayer) {
            echo "Only hosts can start the game.";
            http_response_code(400);
            exit(-1);
        }
    }

    // create game instance and return instance link, will exit if creation fails
    function createGame(&$lobbyData) {
        global $GAME_LENGTH, $INSTANCE_EXPIRATION_DELAY, $GAME_DIR, $INSTANCE_TEMPLATE_DIR, $THEME_DIR;

        // curl to generator for new grid
        $requestURI = "http://" . $_SERVER["SERVER_NAME"] . 
            "/word-search-generator/generator?theme=" . $lobbyData["theme"];
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
            $puzzle["players"] = $lobbyData["players"];
            $puzzle["dbUpdated"] = false;
            $puzzle["gameMode"] = "multiplayer";
            

            // extract theme data and add it to board data
            $themeData = getThemeData($lobbyData["theme"]);
            unset($themeData["words"]);
            $puzzle["theme"] = $themeData;

            $puzzle = json_encode($puzzle);
            $puzzle["theme"]["name"] = $lobbyData["theme"];
        } else {
            http_response_code(500);
            echo "could not fetch word search board from generator. Curl error: " . curl_error($request);
            exit(-2);
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
            exit(-3);
        }

        // copy files from template
        $files = scandir($INSTANCE_TEMPLATE_DIR);

        foreach($files as $file) {
            if ($file == "." || $file == "..") continue;

            $success = copy($INSTANCE_TEMPLATE_DIR . "/$file", $instanceDir . "/$file");
            if (!$success) {
                http_response_code(500);
                echo "failed copying files to new instance.";
                exit(-4);
            }
        }

        // store puzzle json in text file, change permissions so users cannot access answers
        file_put_contents($instanceDir . "/puzzle.json", $puzzle);
        chmod($instanceDir . "/puzzle.json", 0660);

        // update lobby to indicate game has started
        $gameLink = "../" . $instanceDir . "/"; // add extra ../ since clients are in an instance directory

        return $gameLink;
    }
    
    function main() {
        global $LOBBY_DATAFILE_NAME;
        validatePOST(array("lobby", "token"), true); // validate request

        // extract headers and generate lobby path
        $token = $_SERVER["HTTP_TOKEN"];
        $lobbyID = $_SERVER["HTTP_LOBBY"];
        $lobbyDataPath = "$lobbyID/$LOBBY_DATAFILE_NAME";
        
        validateLobby($lobbyID, true); // validate lobby exists

        $lobbyStream = flock_acquireEX($lobbyDataPath); // acquire lock on lobby file since we may modify it 
        $lobbyData = json_decode(fread($lobbyStream, filesize($lobbyDataPath)), true);

        // validate game hasn't started and that player is host
        validateRequest($lobbyData, $token);

        
        date_default_timezone_set("UTC"); // keep timezone consistent
        $gameLink = createGame($lobbyData); // request valid, create game

        $lobbyData["gameLink"] = $gameLink;

         // reset stream to beginning for writing and write back that game has started
        rewind($lobbyStream);
        fwrite($lobbyStream, json_encode($lobbyData)); 

        // release lock and respond to client
        flock_release($lobbyStream); 
        http_response_code(200);
        echo $gameLink;
    }

    main();
?>