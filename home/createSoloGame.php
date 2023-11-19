<?php
    /* This script is responsible for starting a singleplayer time attack game
       Accepted methods: POST only
       Required headers:
          1. name: name to use for the player

        Return: TimeAttackCreation object
    */

    require "../utilities/requestValidation.php";
    require "../utilities/gameGenerator.php";
    
    $MAX_NAME_LENGTH = 13;

    function main() {
        global $MAX_NAME_LENGTH;

        validatePOST(array("name"), true); // va.idate request

        $name = $_SERVER["HTTP_NAME"];

        // validate name
        if (strlen($name) < 1 || strlen($name) >= $MAX_NAME_LENGTH) {
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

        $gameLink = generateGameInstance("timeattack", array($newPlayer), "timeattack");

        if (!$gameLink) {
            echo "game creation failed";
            exit(-1);
        }

        $response = array(
            "link" => $gameLink,
            "accessToken" => $newPlayer["accessToken"]
        );

        echo json_encode($response);
    }

    main();
?>