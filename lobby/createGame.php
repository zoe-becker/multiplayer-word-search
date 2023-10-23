<?php
    /* This function is responsible for starting a game from a lobby at the host's request
       Accepted methods: POST only
       Required headers:
          1. token: access token of the requester (the requester must be the lobby host)
          2. lobby: lobby id (including the prefix)
    */
    // verify request method
    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        http_response_code(405);
        exit(-1);
    }

    // verify proper headers exist
    if (!array_key_exists("HTTP_TOKEN", $_SERVER) || !array_key_exists("HTTP_LOBBY", $_SERVER)) {
        http_response_code(400);
        exit(-2);
    }

    $GAME_DIR = "../board";
    $INSTANCE_TEMPLATE_DIR = $GAME_DIR . "/template";
    $LOBBY_DATAFILE_NAME = "lobbyData.json";
    $GAME_LENGTH = 900;
    $INSTANCE_EXPIRATION_DELAY = 300; // amount of time after game ends before it is eligible to be deleted

    // extract parameters from headers
    $token = $_SERVER["HTTP_TOKEN"];
    $lobbyID = $_SERVER["HTTP_LOBBY"];
    
    // verify instance exists
    if (!file_exists($lobbyID)) {
        echo "invalid instance ID";
        http_response_code(400);
        exit(-3);
    }

    // verify that the requester is the host
    $lobbyData = json_decode(file_get_contents("$lobbyID/$LOBBY_DATAFILE_NAME"));
    $players = $lobbyData["players"];
    $validRequester = false;

    foreach ($players as $player) {
        if ($player["accessToken"] == $token) {
            if ($player["isHost"]) {
                $validRequester = true;
                break;
            }
        }
    }

    if (!$validRequester) {
        echo "Only hosts can start the game.";
        http_response_code(403);
        exit(-4);
    }
    
    // verify request
    $requestMethod = $_SERVER["REQUEST_METHOD"];

    if ($requestMethod != "POST") {
        http_response_code(400); // bad request
        exit(-1);
    }

    // request is valid, start game

    date_default_timezone_set("UTC"); // keep timezone consistent
    // curl to generator for new grid
    $requestURI = "http://" . $_SERVER["SERVER_NAME"] . "/word-search-generator/generator";
    $request = curl_init($requestURI);

    curl_setopt($request, CURLOPT_RETURNTRANSFER, true); // to get response back
    curl_setopt($request, CURLOPT_FOLLOWLOCATION, true); // deployment server redirects http to https

    $puzzle = curl_exec($request);

    // interpret curl result
    if ($puzzle) {
        $puzzle = json_decode($puzzle, true);
        $puzzle["endTime"] = time() + $GAME_LENGTH; // set match expiration date
        $puzzle["instanceExpiration"] = $puzzle["endTime"] + $INSTANCE_EXPIRATION_DELAY;
        $puzzle["foundWords"] = new stdClass(); // empty map
        $puzzle = json_encode($puzzle);
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

    http_response_code(200);
    echo $instanceDir; // echo path to new instance
?>