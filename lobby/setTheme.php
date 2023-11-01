<?php

    require "../utilities/fileSyncronization.php";
    require "../utilities/requestValidation.php";
    require "../utilities/themeFetcher.php";
    require "validateLobby.php";

    $LOBBY_DATAFILE_NAME = "lobbyData.json";

    // validates the request
    function validateRequest(&$accessToken, $theme) {
        // will check if both required headers are present
        if(empty($accessToken) || empty($theme)){
            echo "Missing required headers";
            http_response_code(400);
            exit;
        }
    }

    // will verify if access token is valid and if player is the host
    function verifyAccessToken($lobbyData, $accessToken){
        foreach ($lobbyData['players'] as $player){
            if($player['accessToken'] === $accessToken){
                if($player['isHost']){
                    return true;
                } else {
                    echo "Player is not the host";
                    http_response_code(403);
                    exit;
                }
            }
        }
        echo "Invalid access token";
        http_response_code(401);
        exit;
    }

// function used to verify if theme is in list of possible themes
    function verifyTheme($theme){
        $possibleThemes = getThemeNames();
        if(!in_array($theme, $possibleThemes)){
            echo "Invalid theme";
            http_response_code(400);
            exit;
        }
    }


    function main() {
        global $LOBBY_DATAFILE_NAME;

        if($_SERVER['REQUEST_METHOD'] !== 'POST'){
            http_response_code(405);
            exit("POST method required");
        }

        // get the access token and theme from HTTP headers
        $accessToken = $_SERVER["HTTP_ACCESSTOKEN"];
        $theme = $_SERVER["HTTP_THEME"];

        validateRequest($accessToken, $theme);

        $lobbyID = validateLobby("", false);

        $LobbyDataPath = "$lobbyID/$LOBBY_DATAFILE_NAME";
        $LobbyStream = flock_acquireEX($lobbyDataPath); // acquire exclusive lock on lobbyData file
        $lobbyData = json_decode(fread($LobbyStream, filesize($lobbyDataPath)), true);

        verifyAccessToken($lobbyData, $accessToken);

        verifyTheme($theme);

        // set the theme
        $lobbyData['theme'] = $theme;

        // rewinds the file pointer, write the updated lobby data, and release the lock
        rewind($LobbyStream);
        fwrite($lobbyStream, json_encode($lobbyData));
        flock_release($lobbyStream); // release lock

        http_response_code(200); // successful request
    }
    main();
?>