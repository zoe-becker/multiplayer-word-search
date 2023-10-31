<?php
    $GAMEFILE_NAME = "puzzle.json";

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
        $MAX_TIME = 180; // 3 minutes
        $greenThreshold = $MAX_TIME * 0.5; // 1:30 or 90 seconds
        $yellowThreshold = $MAX_TIME * 0.1667; // 0:30 or 30 seconds
        //$startTime = strtotime($time);
        //hardcoded for testing
        //$currentTime = "2023-10-31 01:57:12";
        $currentTime = time();
        $timeElapsed = $currentTime - $time;

        $orientation = "";

        $wordScore = 300;

        if (strlen($word) > 4) {
            $wordScore += (strlen($word) - 4) * 50;
        }

        
        if ($timeElapsed <= $greenThreshold) {
            $wordScore *= 1; // Green logic
        } else if ($timeElapsed <= ($MAX_TIME - $yellowThreshold)) {
            $wordScore *= 1.2; // Yellow logic
        } else {
            $wordScore *= 2; // Red logic
        }


        if ($direction == "N" || $direction == "S") {
            $orientation = "vertical";
        } else if ($direction == "E" || $direction == "W") {
            $orientation = "horizontal";
        } else {
            $orientation = "diagonal";
        }

        switch ($orientation) {
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


    // Test Cases
    /*
    function main() {
        // Test Cases
        $testCases = [
            ["hello", "2023-10-31 01:56:00", "N"], // 72 seconds passed
            ["apple", "2023-10-31 01:55:00", "E"], // 132 seconds passed
            ["banana", "2023-10-31 01:54:00", "SE"], // 192 seconds passed
            ["kiwi", "2023-10-31 01:56:50", "N"], // 22 seconds passed
            ["orange", "2023-10-31 01:54:50", "SW"] // 132 seconds passed 
            
        ];
    
        foreach ($testCases as $testCase) {
            $word = $testCase[0];
            $time = $testCase[1];
            $direction = $testCase[2];
            
            $score = calculateScore($word, $time, $direction);
            echo "Word: $word, Time: $time, Direction: $direction -> Score: $score<br>";
            
        }
    }

    main();
    */
?>