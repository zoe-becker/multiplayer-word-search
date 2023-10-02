<?php
    $GAME_DIR = "board";
    $INSTANCE_TEMPLATE_DIR = $GAME_DIR . "/template";

    // verify request
    $requestMethod = $_SERVER["REQUEST_METHOD"];

    if ($requestMethod != "POST") {
        http_response_code(400); // bad request
        exit(-1);
    }

    // curl to generator for new grid
    $requestURI = "http://" . $_SERVER["SERVER_NAME"] . "/word-search-generator/generator";
    $request = curl_init($requestURI);

    curl_setopt($request, CURLOPT_RETURNTRANSFER, true); // to get response back
    curl_setopt($request, CURLOPT_FOLLOWLOCATION, true); // deployment server redirects http to https

    $puzzle = curl_exec($request);

    // interpret curl result
    if (!$puzzle) {
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

    // store puzzle json in text file
    file_put_contents($instanceDir . "/puzzle.json", $puzzle);

    echo $instanceDir; // echo path to new instance
?>