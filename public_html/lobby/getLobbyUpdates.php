<?php
    /* This function is responsible for returning updates about the lobby state to polling clients
       Accepted methods: GET only
       Required query parameters:
          1. lobby: lobby id (including the prefix)

        Return: LobbyData object (see docs)
    */
    $INCLUDE_PATH = require "../includePath.php";
    require_once "$INCLUDE_PATH/config/gameConfig.php";
    require "$INCLUDE_PATH/utilities/requestValidation.php";
    require "$INCLUDE_PATH/utilities/sanitizePlayers.php";
    require "$INCLUDE_PATH/utilities/fileSyncronization.php";
    require "$INCLUDE_PATH/utilities/validateLobby.php";

    function main() {
        validateGET(array("lobby"), true); // validate request

        $lobbyID = $_GET["lobby"];
        $lobbyDataPath = "$lobbyID/" . LOBBY_DATAFILE_NAME;
        validateLobby($lobbyID, true); // validate lobby exists

        $lobbyData = json_decode(flock_read_and_release($lobbyDataPath), true);

        $response = array(
            "players" => util_sanitize_players($lobbyData["players"]),
            "gameLink" => $lobbyData["gameLink"],
            "theme" => $lobbyData["theme"]
        );
    
        http_response_code(200);
        echo json_encode($response);
    }

    main();
?>