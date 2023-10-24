<?php
    /* This function is responsible for adding a new player to a particular lobby
       Accepted methods: POST only
       Required headers:
          1. name: name of new player
          2. lobby: lobby id (including the prefix)

        Return: access token of the newly created player
    */

    // verify method
    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        http_response_code(405);
        exit(-1);
    }

    // verify proper headers exist
    if (!array_key_exists("HTTP_NAME", $_SERVER) || !array_key_exists("HTTP_LOBBY", $_SERVER)) {
        http_response_code(400);
        exit(-2);
    }

    $LOBBY_DATAFILE_NAME = "lobbyData.json";

    $requestedName = $_SERVER["HTTP_NAME"];
    $lobbyID = $_SERVER["HTTP_LOBBY"];

    // verify instance id is valid
    if (!file_exists($lobbyID)) {
        echo "invalid instance code";
        http_response_code(400);
        exit(-1);
    }

    $lobbyData = json_decode(file_get_contents("$lobbyID/$LOBBY_DATAFILE_NAME"), true);
    $newPlayer = array(
        "name" => $requestedName,
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

    file_put_contents("$lobbyID/$LOBBY_DATAFILE_NAME", json_encode($lobbyData));
    http_response_code(200);
    echo $newPlayer["accessToken"];
?>