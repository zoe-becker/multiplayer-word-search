<?php
require_once("../database/db_connect.php");

function updateDataBase($playerName, $score, $gameTime, $scoreDate) {
    global $pdo;

    try {
        // Begin transaction
        $pdo->beginTransaction();
    
        // Prepare the insert statement
        $sql = "INSERT INTO all_time_lb (Player, Score, Date, game_time) 
                VALUES (:player_name, :score, :score_date, :game_time)";
    
        $stmt = $pdo->prepare($sql);
    
        // Bind parameters to the statement
        $stmt->bindParam(':player_name', $playerName, PDO::PARAM_STR);
        $stmt->bindParam(':score', $score, PDO::PARAM_INT);
        $stmt->bindParam(':game_time', $gameTime, PDO::PARAM_STR);
        $stmt->bindParam(':score_date', $scoreDate, PDO::PARAM_STR);
    
        // Execute the statement
        $stmt->execute();
    
        // Commit the transaction
        $pdo->commit();
    
    } catch (PDOException $e) {
        // Roll back the transaction if something failed
        $pdo->rollBack();
    
        echo "Error: " . $e->getMessage();
    }
}





    
?>