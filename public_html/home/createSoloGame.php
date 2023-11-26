<?php
    /* This script is responsible for starting a singleplayer time attack game
       Accepted methods: POST only
       Required headers:
          1. name: name to use for the player

        Return: TimeAttackCreation object
    */
    $INCLUDE_PATH = require "../includePath.php";
    require_once "$INCLUDE_PATH/config/gameConfig.php";
    require "$INCLUDE_PATH/utilities/requestValidation.php";
    require "$INCLUDE_PATH/utilities/gameGenerator.php";

    function main() {
        validatePOST(array("name"), true); // va.idate request

        $name = $_SERVER["HTTP_NAME"];

        // validate name
        if (strlen($name) < 1 || strlen($name) >= USER_MAX_NAME_LEN) {
            echo "name does not fit size constraints";
            http_response_code(400);
            exit(-4);
        }

        $newPlayer = array(
            "name" => $name,
            "accessToken" => uniqid("", true), // create unique id, more entropy to reduce chance of collision
            "boardRetrieved" => false,
            "isHost" => false,
            "score" => 0
        );

        $settings = json_decode("{'difficulty': 'medium' , 'size': 'medium', 'shape': ''}", true);
        // create game instance
        $gameLink = generateGameInstance("timeattack", array($newPlayer), "timeattack", $settings);

        if (!$gameLink) {
            echo "game creation failed";
            exit(-1);
        }

        // echo response
        $response = array(
            "link" => $gameLink,
            "accessToken" => $newPlayer["accessToken"]
        );

        echo json_encode($response);
    }

    main();
?>