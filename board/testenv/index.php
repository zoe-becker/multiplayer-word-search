<?php
// Sets up the test environment
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

    copy("$TEST_FILES_DIR/$file", $file);
}

echo file_get_contents("$TEMPLATE_DIR/index.html");
echo "<script src='testenv.js'></script>"; // load test js
?>