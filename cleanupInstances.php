<?php
/* Automatically deletes expired game instances on the server via a cron job
    *** in the local environment you must manually call this script or cleanup the instance directory yourself ***
*/
    $INSTANCE_PREFIX = "ws";
    $INSTANCE_FOLDER = "board";
    $gameInstances = scandir($INSTANCE_FOLDER);

    foreach ($gameInstances as $instance) {
        // check that $instance is actually a game instance
        if (str_starts_with($instance, $INSTANCE_PREFIX)) {
            rmdir_recursive($INSTANCE_FOLDER . "/$instance");
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