<?php
/* utility function to get player object from the given player list
   returns false if player is not in the list
*/

function util_get_player($playerToken, $players) {
    $foundPlayer = false;

    foreach ($players as $player) {
        if ($player["accessToken"] == $playerToken) {
            $foundPlayer = $player;
            break;
        }
    }

    return $foundPlayer;
}

?>