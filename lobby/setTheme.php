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
        
    }
    main();
?>