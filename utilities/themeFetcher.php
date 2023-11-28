<?php
// set of functions for getting various aspects of the available board themes

require_once __DIR__ . "/../config/envConfig.php";
$THEME_DIR = PUBLIC_HTML_PATH . "/themes";

// get an array of the names of all of the themes in a ready to be displayed
// format (the first letter capitalized)
// return: array of formatted theme names
function getThemeNames() {
    global $THEME_DIR;
    $themeScan = scandir($THEME_DIR);
    $themeList = array();

    foreach ($themeScan as $theme) {
        if ($theme == "." || $theme == ".." || $theme == "themeAssets") continue;
            $dotPos = strpos($theme, "."); // get dot from filename
            $name = substr($theme, 0, $dotPos);
            
            $name[0] = strtoupper($name[0]); // capitalize first letter
            array_push($themeList, $name);
    }

    return $themeList;
}

// get the json data about a theme from the given theme name
// $theme: formatted or literal theme name to get the data of
// return: json_decoded associative array of theme data
function getThemeData($theme) {
    global $THEME_DIR;
    $theme = strtolower($theme); // unformat if formatted

    $themeData = file_get_contents("$THEME_DIR/$theme.json");

    return json_decode($themeData, true);
}

// get the path to the theme file for the given theme name
// $theme: theme name
// return: absolute path to the theme file
function getThemeFilePath($theme) {
    global $THEME_DIR;
    
    $theme = strtolower($theme);
    return realpath("$THEME_DIR/$theme.json");
}

?>