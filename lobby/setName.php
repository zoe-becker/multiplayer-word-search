<?php
    /* This function is responsible for adding a new player to a particular lobby
       The first person to set their name in the lobby becomes the host
       Accepted methods: POST only
       Required headers:
          1. name: name of new player
          2. lobby: lobby id (including the prefix)

        Return: setNameResponse object
    */

    require "../utilities/fileSyncronization.php";
    require "../utilities/requestValidation.php";
    require "../utilities/themeFetcher.php";
    require "validateLobby.php";

    $LOBBY_DATAFILE_NAME = "lobbyData.json";

    // validates that game hasn't already started and name is valid
    // exits if something is invalid
    // NOTE: name is always valid right now
    function validateRequest(&$lobbyData, $name) {
        if ($lobbyData["gameLink"]) {
            echo "game already started";
            http_response_code(400);
            exit(-4);
        }
    }

    // adds player $name to the referenced lobbyData associative array and returns the new player object
    function addPlayer(&$lobbyData, $name) {
        $newPlayer = array(
            "name" => $name,
            "accessToken" => uniqid("", true), // create unique id, more entropy to reduce chance of collision
            "boardRetrieved" => false,
            "isHost" => false,
            "score" => 0
        );

        // first player to set name is set to be host
        
        if (count($lobbyData["players"]) == 0) {
            $newPlayer["isHost"] = true;
        }

        array_push($lobbyData["players"], $newPlayer);

        return $newPlayer;
    }

    function main() {
        global $LOBBY_DATAFILE_NAME;
        validatePOST(array("lobby", "name"), true); // validate request
        
        $requestedName = $_SERVER["HTTP_NAME"];
        $lobbyID = $_SERVER["HTTP_LOBBY"];

        validateLobby($lobbyID, true); // validate lobby exists

        $lobbyDataPath = "$lobbyID/$LOBBY_DATAFILE_NAME";
        $lobbyStream = flock_acquireEX($lobbyDataPath); // acquire lock on file since we may write to it
        $lobbyData = json_decode(fread($lobbyStream, filesize($lobbyDataPath)), true);

        // validate name is valid and game hasn't started
        validateRequest($lobbyData, $requestedName);

        $player = addPlayer($lobbyData, $requestedName);
        $isHost = $player["isHost"];
        // rewind stream so new data can be written and write new player
        rewind($lobbyStream); 
        fwrite($lobbyStream, json_encode($lobbyData));
        flock_release($lobbyStream); // release lock
        
        $response = array(
            "accessToken" => $player["accessToken"],
            "isHost" => $isHost
        );

        if ($isHost) {
            $response["themes"] = getThemeNames();
        }

        http_response_code(200);
        echo json_encode($response);
    }

    main();
?>