<?php
    /* Responsible for allowing a host to kick a player from the game
        Accepted methods: POST only
        Required headers:
            1. lobby: lobby id of the lobby to kick player from
            2. token: access token of the requesting user (user must be host to kick)
            3. name: name of the player to kick (cannot kick self)

        return: none
    */
    $INCLUDE_PATH = require "../includePath.php";
    require_once "$INCLUDE_PATH/config/gameConfig.php";
    require "$INCLUDE_PATH/utilities/fileSyncronization.php";
    require "$INCLUDE_PATH/utilities/requestValidation.php";
    require "$INCLUDE_PATH/utilities/validateLobby.php";
    require "$INCLUDE_PATH/utilities/getPlayer.php";

    // get the index of the given player name in the players array
    // returns -1 if not present
    function getPlrIndexFromArray($name, &$lobbyData) {
        $index = -1;

        for ($i = 0; $i<count($lobbyData["players"]); $i++) {
            if ($lobbyData["players"][$i]["name"] === $name) {
                $index = $i;
                break;
            }
        }

        return $index;
    }

    function main() {
        // called validatePost function
        validatePOST(['lobby', 'token', 'name'], true);

        // get the access token, name, & lobby code from HTTP headers 
        $accessToken = $_SERVER["HTTP_TOKEN"];
        $plrToKick = $_SERVER["HTTP_NAME"];
        $lobbyCode = $_SERVER["HTTP_LOBBY"];

        validateLobby($lobbyCode, true); // validate lobby

        $lobbyDataPath = "$lobbyCode/" . LOBBY_DATAFILE_NAME;
        $lobbyStream = flock_acquireEX($lobbyDataPath); // acquire exclusive lock on lobbyData file
        $lobbyData = json_decode(fread($lobbyStream, filesize($lobbyDataPath)), true);
        $playerIndex = util_get_player_index($accessToken, $lobbyData["players"]);
        
        // check that player is the host and that they aren't trying to kick themselves
        if ($playerIndex == -1) {
            http_response_code(400);
            echo "invalid access token";
            exit(-1);
        } else if ($lobbyData["players"][$playerIndex]["isHost"] == false) {
            http_response_code(400);
            echo "you are not the host";
            exit(-1);
        } else if ($lobbyData["players"][$playerIndex]["name"] === $plrToKick) {
            http_response_code(400);
            echo "you cannot kick yourself";
            exit(-1);
        }

        // check that player we want to kick is in this lobby, if so we get index
        $kickPlrIndex = getPlrIndexFromArray($plrToKick, $lobbyData);
        
        if ($kickPlrIndex == -1) {
            http_response_code(400);
            echo "player is not in lobby";
            exit(-1);
        }

        // remove player by replacing index with nothing, array_splice reindexes so indicies remain sequential
        array_splice($lobbyData["players"], $kickPlrIndex, 1);

        // rewinds the file pointer, write the updated lobby data, and release the lock
        rewind($lobbyStream);
        ftruncate($lobbyStream, 0);
        fwrite($lobbyStream, json_encode($lobbyData));
        flock_release($lobbyStream); // release lock

        http_response_code(200); // successful request
    }

    main();
?>