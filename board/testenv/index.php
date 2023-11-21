<?php
// sets up the test environment
$INCLUDE_PATH = require "../includePath.php";
require "$INCLUDE_PATH/gameConfig.php";
require "$INCLUDE_PATH/utilities/themeFetcher.php";

$TEMPLATE_DIR = "../template";
$TEST_FILES_DIR = "../testenvFiles";

$templateScan = scandir($TEMPLATE_DIR);
$testFilesScan = scandir($TEST_FILES_DIR);
$currentDirScan = scandir(".");

// clear test env
foreach ($currentDirScan as $file) {
    if ($file == "." || $file == ".." || $file == "index.php") continue;

    unlink($file);
}

// load in files from template
foreach ($templateScan as $file) {
    // skip index since we will copy contents later
    if ($file == "." || $file == ".." || $file == "index.html") continue;

    copy("$TEMPLATE_DIR/$file", $file);
}

// load in test files
foreach ($testFilesScan as $file) {
    if ($file == "." || $file == "..") continue;

    if ($file == "puzzle.json") {
        $puzzle = json_decode(file_get_contents("$TEST_FILES_DIR/$file"), true);
        $puzzle["theme"] = getThemeData($puzzle["theme"]);
        $puzzle["startTime"] = time();
        $puzzle["expireTime"] = time() + TESTENV_GAME_LEN;
        
        unset($puzzle["theme"]["words"]);
        file_put_contents("$file", json_encode($puzzle));
    } else {
        copy("$TEST_FILES_DIR/$file", $file);
    }
}

echo file_get_contents("$TEMPLATE_DIR/index.html");
echo "<script src='testenv.js'></script>"; // load test js
?>