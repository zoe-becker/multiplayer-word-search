<?php
/* Automatically deletes expired game instances on the server via a cron job
    *** in the local environment you must manually call this script or cleanup the instance directory yourself ***
*/
    date_default_timezone_set("UTC");
    $INSTANCE_PREFIX = "ws";
    $INSTANCE_FOLDER = "board";
    $GAMEFILE_NAME = "puzzle.json";
    $DELETION_DELAY = 300; // number of seconds after game expiration until instance deletion
    $gameInstances = scandir($INSTANCE_FOLDER);
    
    foreach ($gameInstances as $instance) {
        // check that $instance is actually a game instance
        if (str_starts_with($instance, $INSTANCE_PREFIX)) {
            $gamefile = file_get_contents("$INSTANCE_FOLDER/$instance/$GAMEFILE_NAME");

            if (!$gamefile) continue;
            $gamefile = json_decode($gamefile, true);

            if ($gamefile["endTime"] + $DELETION_DELAY <= time()) {
                rmdir_recursive($INSTANCE_FOLDER . "/$instance");
            }
        }
    }

    // deletes a nonempty directory and any subdirectories inside
    function rmdir_recursive($path) {
        $results = scandir($path);

        // empty directory so rmdir can be called
        foreach($results as $file) {
            if ($file == "." || $file == "..") continue;
            $filePath = $path . "/$file";

            if (is_dir($filePath)) {
                rmdir_recursive($path . "/$file"); // $file is a directory, call function again
            } else {
                unlink($filePath); // $file is a file, delete it
            }
        }

        rmdir($path); // directory now empty, safe to delete
    }
?>