<?php
    /* Responsible for changing the selected theme at the hosts request
        Accepted methods: POST only
        Required headers:
            1. token: access token of the requesting user
            2. theme: formatted theme name to change to (first letter capitalized)

        return: none
    */
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

        // called validatePost function
        validatePOST(['token', 'theme', 'lobby'], true);

        // makes sure request method is POST
        if($_SERVER['REQUEST_METHOD'] !== 'POST'){
            http_response_code(405);
            exit("POST method required");
        }

        // get the access token, theme & lobby code from HTTP headers 
        $accessToken = $_SERVER["HTTP_TOKEN"];
        $theme = $_SERVER["HTTP_THEME"];
        $lobbyCode = $_SERVER["HTTP_LOBBY"];

        validateRequest($accessToken, $theme);

        $lobbyID = validateLobby($lobbyCode, true);

        $lobbyDataPath = "$lobbyCode/$LOBBY_DATAFILE_NAME";
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