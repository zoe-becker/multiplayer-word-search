<?php
// Contains important path information and database credentials
//
// !!!IMPORTANT!!!
// YOU MUST FILL OUT THE FOLLOWING REQUIRED FIELDS FOR THE GAME TO WORK PROPERLY:
// DB_USER - database username
// DB_PASSWORD - database password
// PYTHON_INTERPRETER_PATH - must be >=3.7
// PUBLIC_HTML_PATH - path to public_html directory of the word search

// THIS FILE MUST BE RENAMED TO "envConfig.php" AFTER FILLING OUT REQUIRED FIELDS

// Path config
define("PUBLIC_HTML_PATH", "");

// Database config
define("DB_USER", "");
define("DB_PASSWORD", "");
define ("DB_HOST", "127.0.0.1");
define ("DB_NAME", "ws_leaderboard");
define("DB_CHARSET", "utf8");
define ("DB_OPTS", [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
]);

// Python config
define("PYTHON_INTERPRETER_PATH", ""); // MUST SET THIS TO PYTHON >=3.7 EXECUTABLE PATH
?>