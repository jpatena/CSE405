<?php 
    try {
        // create PHP data object
        $dbhost = new PDO("mysql:host=localhost;dbname=track1", "root", NULL);
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
?>

<h2>Track1 Assignment</h2>
<p>Page Views: <?php echo $counter; ?></p>