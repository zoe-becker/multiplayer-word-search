<?php
require_once("db_connect.php");

function updateDataBase($playerName, $score) {
    global $pdo;

    try {
        // Begin transaction
        $pdo->beginTransaction();
    
        // Prepare the insert statement with the new table structure
        $sql = "INSERT INTO all_time_lb (Player, Score) 
                VALUES (:player_name, :score)";
    
        $stmt = $pdo->prepare($sql);
    
        // Bind parameters to the statement
        $stmt->bindParam(':player_name', $playerName, PDO::PARAM_STR);
        $stmt->bindParam(':score', $score, PDO::PARAM_INT);
        // If theme is not provided, bind NULL.
        //$stmt->bindValue(':theme', $theme, $theme === NULL ? PDO::PARAM_NULL : PDO::PARAM_STR);
    
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
