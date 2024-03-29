<?php
    /* This function is responsible for creating a lobby
       Accepted methods: GET only
       Required query params: none

       Return: Relative path to the newly created lobby instance
    */
    $INCLUDE_PATH = require "../includePath.php";
    require_once "$INCLUDE_PATH/config/gameConfig.php";
    require "$INCLUDE_PATH/utilities/requestValidation.php";
    
    $LOBBY_DIR = "../lobby";
    $INSTANCE_TEMPLATE_DIR = $LOBBY_DIR . "/template";

    // handles creation of the lobby
    // will exit with appropriate messages sent to client if creation fails
    function createLobby() {
        // load in globals
        global $LOBBY_DIR, $INSTANCE_TEMPLATE_DIR;

        $lobby = array();

        // set initial lobby state
        $lobby["instanceExpiration"] = time() + LOBBY_INSTANCE_LIFETIME;
        $lobby["players"] = array(); // first player added will become host
        $lobby["gameLink"] = false;
        $lobby["theme"] = MULTIPLAYER_DEFAULT_THEME;

        /* create new game instance */
        $instanceID = uniqid("lb-");
        $instanceDir = $LOBBY_DIR . "/" . $instanceID;

        // create instance folder
        if (!mkdir($instanceDir)) {
            http_response_code(500);
            echo "could not create instance.";
            exit(-2);
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

        // store lobby data in json file, change permissions so users cannot access user tokens of others
        file_put_contents($instanceDir . "/" . LOBBY_DATAFILE_NAME, json_encode($lobby));
        chmod($instanceDir . "/" . LOBBY_DATAFILE_NAME, 0660);

        return $instanceDir . "/"; // echo path to new instance
    }

    function main() {
        validateGET(array(), true); // validate request
        date_default_timezone_set("UTC"); // keep timezone consistent
        $instance = createLobby();

        http_response_code(200);
        echo $instance;
    }

    main();
?>