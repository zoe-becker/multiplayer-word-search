<?php
/* Automatically deletes expired game instances on the server via a cron job
    *** in the local environment you must manually call this script or cleanup the instance directory yourself ***
*/
    date_default_timezone_set("UTC");
    
    // cleanup expired lobbies and boards
    cleanup_instance_directory("../board", "ws-", "puzzle.json");
    cleanup_instance_directory("../lobby", "lb-", "lobbyData.json");

    // deletes any expired instances in the given directory
    // $directory: path to the directory to cleanup
    // $prefix: file name prefix to distinguish between instance/noninstance folders
    // $timeFile: data file in the instance folder that contains the expiration time
    //    for the instance. Should be a json file with an entry named "instanceExpiration"
    //    indicating the time the instance becomes eligible for deletion
    function cleanup_instance_directory($directory, $prefix, $timeFile) {
        $gameInstances = scandir($directory);
        foreach ($gameInstances as $instance) {
            // check that $instance is actually a game instance
            if (str_starts_with($instance, $prefix)) {
                $gamefile = file_get_contents("$directory/$instance/$timeFile");
    
                if (!$gamefile) continue;
                $gamefile = json_decode($gamefile, true);
    
                if ($gamefile["instanceExpiration"] <= time()) {
                    rmdir_recursive($directory . "/$instance");
                }
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