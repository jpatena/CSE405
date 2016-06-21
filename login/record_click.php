<?php 
    // If user not logged in, redirect to login page
    session_start();
    if (!isset($_SESSION['username'])) {
        exit('Not logged in.');
    }

    // Connect to database
    try {
        $dbhost = new PDO("mysql:host=localhost;dbname=login", "root", NULL);
    } catch (PDOException $e) {
        exit('Database connection failed: ' . $e->getMessage());
    }    
        // increment the counter on the database
        $statement = $dbhost->prepare("UPDATE users SET click_count = click_count + 1 WHERE username = :username");
        $statement->bindParam(':username', $_SESSION['username']) or exit("bindParam failed.");
        $statement->execute() or exit("UPDATE failed.");
?>