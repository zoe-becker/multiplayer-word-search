<?php
/* utility function to get player object from the given player list
   returns false if player is not in the list
*/

// returns the index of the player or -1 if the player is not in the list
function util_get_player_index($playerToken, $players) {
    $foundPlayer = -1;

    for ($i = 0; $i<count($players); $i++) {
        if ($players[$i]["accessToken"] == $playerToken) {
            $foundPlayer = $i;
            break;
        }
    }

    return $foundPlayer;
}

?>