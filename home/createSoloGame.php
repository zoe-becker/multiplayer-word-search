<?php
    /* This script is responsible for starting a singleplayer time attack game
       Accepted methods: POST only
       Required headers:
          1. name: name to use for the player

        Return: TimeAttackCreation object
    */

    require "../utilities/requestValidation.php";
    require "../utilities/gameGenerator.php";
    
    function main() {
        validatePOST(array("name"), true); // va.idate request

        $newPlayer = array(
            "name" => $_SERVER["HTTP_NAME"],
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