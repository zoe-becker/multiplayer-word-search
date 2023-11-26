<?php
    /* Responsible for changing the selected theme at the hosts request
        Accepted methods: POST only
        Required headers:
            1. lobby: lobby id of the lobby to change
            2. token: access token of the requesting user
            3. theme: formatted theme name to change to (first letter capitalized)

        return: none
    */
    $INCLUDE_PATH = require "../includePath.php";
    require_once "$INCLUDE_PATH/config/gameConfig.php";
    require "$INCLUDE_PATH/utilities/fileSyncronization.php";
    require "$INCLUDE_PATH/utilities/requestValidation.php";
    require "$INCLUDE_PATH/utilities/themeFetcher.php";
    require "$INCLUDE_PATH/utilities/validateLobby.php";

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
        // called validatePost function
        validatePOST(['token', 'theme', 'lobby'], true);

        // get the access token, theme & lobby code from HTTP headers 
        $accessToken = $_SERVER["HTTP_TOKEN"];
        $theme = $_SERVER["HTTP_THEME"];
        $lobbyCode = $_SERVER["HTTP_LOBBY"];

        $lobbyID = validateLobby($lobbyCode, true);

        $lobbyDataPath = "$lobbyCode/" . LOBBY_DATAFILE_NAME;
        $lobbyStream = flock_acquireEX($lobbyDataPath); // acquire exclusive lock on lobbyData file
        $lobbyData = json_decode(fread($lobbyStream, filesize($lobbyDataPath)), true);

        verifyAccessToken($lobbyData, $accessToken);

        verifyTheme($theme);

        // set the theme key in lobbyData object
        $lobbyData['theme'] = $theme;

        // rewinds the file pointer, write the updated lobby data, and release the lock
        rewind($lobbyStream);
        ftruncate($lobbyStream, 0);
        fwrite($lobbyStream, json_encode($lobbyData));
        flock_release($lobbyStream); // release lock

        http_response_code(200); // successful request
    }

    main();
?>