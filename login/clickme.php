<?php
    // If user is not logged in, then redirect to the login page
    session_start();
    if(!isset($_SESSION['username'])) {
        header('Location: ./');
    }
        
     // Connect to the database
    try {
        $dbhost = new PDO("mysql:host=localhost;dbname=login", "root", NULL);
    } catch (PDOException $e) {
        exit('Database connection failed: ' . $e->getMessage());
    }    
    // Retrieve the click count for logged in user
    $statement = $dbhost->prepare("SELECT click_count FROM users WHERE username= :username");
    $statement->bindParam(':username', $_SESSION['username']);
    $statement->execute() or exit("SELECT failed.");

    // If no matching user, redirect to login page
    if($statement->rowCount()==0) {
        header('Location: ./');
        exit();
    }

    // Extract the click count from the table
    $row = $statement->fetch() or exit("FETCH failed.");
    $click_count = $row["click_count"];
?>
<h2> Clickme Page</h2>

<form action="logout.php" method ="post">
    <input type="submit" value="Logout" />
</form>

<p id="counter"><?php print($click_count) ?></p>

<button id="button">Click Me!</button>

<script src="ajax.js"></script>
<script>
/*global ajax*/

(function() {    
    var count = <?php print($click_count)?>;
    var counter = document.getElementById('counter');
    var button = document.getElementById('button');
    button.onclick = function() {
        counter.innerHTML = ++count;
        // Call function from script to record clicks
        ajax('record_click.php');
    }
})();
</script>
