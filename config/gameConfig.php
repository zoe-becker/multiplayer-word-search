<?php
// Contains variables to modify the behavior of the game


// lobby/user constants
define("LOBBY_INSTANCE_LIFETIME", 28800); // 8 hours
define("LOBBY_DATAFILE_NAME", "lobbyData.json");
define("USER_MAX_NAME_LEN", 13);

// game constants
define("GAME_DATAFILE_NAME", "puzzle.json");
define("GAME_INSTANCE_EXPIRATION_DELAY", 300); // instances are eligible for deletion at game end + this delay
define("MULTIPLAYER_DEFAULT_THEME", "Animals"); // any theme in theme folder, first letter capitalized
define("MULTIPLAYER_GAME_LEN", 180);
define("TIMEATTACK_GAME_LEN", 180);
define("MULTIPLAYER_WORD_BASE_SCORE", 300); // words worth this amount at a minimum in multiplayer
define("GENERATOR_WORD_COUNT", 9);

// testenv specific constants
define("TESTENV_GAME_LEN", 180);
?>