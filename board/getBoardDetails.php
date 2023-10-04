<?php
// This function is responsible for the ititial data needed by the client to setup their board

    $puzzle = file_get_contents("puzzle.json");

    if ($puzzle) {
        http_response_code(200);
        return $puzzle;
    } else {
        http_response_code(500);
        return "Puzzle retrieval error.";
    }
?>