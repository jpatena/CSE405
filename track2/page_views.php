<?php 
    try {
        // create PHP data object
        $dbhost = new PDO("mysql:host=localhost;dbname=track2", "root", NULL);
    } catch (PDOException $e) {
        exit('Database connection failed: ' . $e->getMessage());
    }    
        // increment the counter on the database
        $statement = $dbhost->prepare("UPDATE page_views SET counter = counter + 1");
        $statement->execute() or exit("UPDATE failed.");
        
        // select the counter column from the page_views table
        $statement = $dbhost->prepare('SELECT counter FROM page_views');
        $statement->execute() or exit("SELECT failed.");
        
        // fetch and display the counter
        $row = $statement->fetch() or exit("FETCH failed.");
        $counter = $row["counter"];
        
        // format response as JSON object
        $responseObject = array(counter => $counter);
        $jsonString = json_encode($responseObject);
        print($jsonString);
?>