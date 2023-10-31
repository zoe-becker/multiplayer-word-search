<?php
    $GAMEFILE_NAME = "puzzle.json";
    $MAX_TIME = 180; // 3 minutes
    /* 
    Word score[base word 300 pts :: every letter more than 4 is an additional 50 pts]  
    time mult[ Green 1x -- Yellow 1.2x -- Red 2x] 
    Direction[horizontal and vertical: 1x -- diagonal 1.2x]

    Where:
    3:00 - 1:30 is green 
    1:29- 0:30 is yellow
    0:29- 0:00 is red
    please give counter suggestions
    */
    function calculateScore($word, $time, $direction) {
        $startTime = strtotime($time);
        $currentTime = time();
        $timeElapsed = strtotime($currentTime) - $startTime;

        $orientation = "";

        $wordScore = 300;

        if (strlen($word) > 4) {
            $wordScore += (strlen($word) - 4) * 50;
        }

        if ($timeElapsed <= 90) {
            $wordScore *= 1;
        } else if ($timeElapsed <= 150) {
            $wordScore *= 1.2;
        } else {
            $wordScore *= 2;
        }


        if ($direction == "N" || $direction == "S") {
            $orientation = "vertical";
        } else if ($direction == "E" || $direction == "W") {
            $orientation = "horizontal";
        } else {
            $orientation = "diagonal";
        }

        switch ($direction) {
            case "horizontal":
                $wordScore *= 1;
                break;
            case "vertical":
                $wordScore *= 1;
                break;
            case "diagonal":
                $wordScore *= 1.2;
                break;
            default:
                $wordScore *= 1;
                break;
        }

        return $wordScore;
    }

    function main() {
        // Set the default timezone to UTC
        date_default_timezone_set('UTC');

        // Create a DateTime object for the current time
        $currentUTC = new DateTime();

        $currentTime = time();
        
    }

    main();
?>