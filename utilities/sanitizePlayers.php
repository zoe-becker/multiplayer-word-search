<?php
/* utility function to sanitize player objects so they can safely be sent to the client
    - removes accessToken and boardRetrieved keys from each player in given list
*/

function util_sanitize_players($players) {
    for ($i = 0; $i < count($players); $i++) {
        $sanitizedPlr = $players[$i]; // load unsanitized

        // sanitize
        unset($sanitizedPlr["boardRetrieved"]);
        unset($sanitizedPlr["accessToken"]);

        $players[$i] = $sanitizedPlr; // set unsanitized to newly sanitized
    }

    return $players;
}
?>