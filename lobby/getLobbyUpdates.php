<?php
    /* This function is responsible for returning updates about the lobby state to polling clients
       Accepted methods: GET only
       Required query parameters:
          1. lobby: lobby id (including the prefix)

        Return: LobbyData object (see docs)
    */

    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        http_response_code(405);
        exit(-1);
    }
    
    if (!array_key_exists("lobby", $_GET)) {
        echo "invalid lobby id";
        http_response_code(400);
        exit(-2);
    }

    include "../utilities/sanitizePlayers.php";

    $LOBBY_DATAFILE_NAME = "lobbyData.json";
    $lobbyID = $_GET["lobby"];

    // verify lobby id exists
    if (!file_exists($lobbyID)) {
        echo "invalid instance ID";
        http_response_code(400);
        exit(-3);
    }

    $lobbyData = json_decode(file_get_contents("$lobbyID/$LOBBY_DATAFILE_NAME"), true);

    $response = array(
        "players" => util_sanitize_players($lobbyData["players"]),
        "gameLink" => $lobbyData["gameLink"]
    );

    http_response_code(200);
    echo json_encode($response);
?>