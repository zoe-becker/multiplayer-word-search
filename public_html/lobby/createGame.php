<?php
    /* This function is responsible for starting a game from a lobby at the host's request
       Accepted methods: POST only
       Required headers:
          1. token: access token of the requester (the requester must be the lobby host)
          2. lobby: lobby id (including the prefix)

        Return: Relative path to the newly created game instance
    */
    $INCLUDE_PATH = require "../includePath.php";
    require_once "$INCLUDE_PATH/config/gameConfig.php";
    require "$INCLUDE_PATH/utilities/requestValidation.php";
    require "$INCLUDE_PATH/utilities/fileSyncronization.php";
    require "$INCLUDE_PATH/utilities/gameGenerator.php";
    require "$INCLUDE_PATH/utilities/validateLobby.php";

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
    
    function main() {
        validatePOST(array("lobby", "token"), true); // validate request

        // extract headers and generate lobby path
        $token = $_SERVER["HTTP_TOKEN"];
        $lobbyID = $_SERVER["HTTP_LOBBY"];
        $lobbyDataPath = "$lobbyID/" . LOBBY_DATAFILE_NAME;
        
        validateLobby($lobbyID, true); // validate lobby exists

        $lobbyStream = flock_acquireEX($lobbyDataPath); // acquire lock on lobby file since we may modify it 
        $lobbyData = json_decode(fread($lobbyStream, filesize($lobbyDataPath)), true);

        // validate game hasn't started and that player is host
        validateRequest($lobbyData, $token);

        
        date_default_timezone_set("UTC"); // keep timezone consistent
        $gameLink = generateGameInstance($lobbyData["theme"], $lobbyData["players"], "multiplayer", $settings); 

        // check that game creation was successful
        if (!$gamelink) {
            echo "game creation failed";
            exit(-1);
        }

        $startTime = $result["startTime"];
        $lobbyData["gameLink"] = $gameLink;

        // Created the response array with game link and start time
        $response = array(
            "gameLink" => $gameLink,
            "startTime" => $startTime
        );

         // reset stream to beginning for writing and write back that game has started
        rewind($lobbyStream);
        fwrite($lobbyStream, json_encode($lobbyData)); 

        // release lock and respond to client
        flock_release($lobbyStream); 
        http_response_code(200);
        echo json_encode($response);
    }

    main();
?>