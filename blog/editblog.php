<?php
    session_start();

    // Connect to the database
    try {
        $dbhost = new PDO("mysql:host=localhost;dbname=blog", "root", NULL);
    } catch (PDOException $e) {
        exit('Database connection failed: ' . $e->getMessage());
    }    
    // Retrieve blog text for logged in user
    $statement = $dbhost->prepare("SELECT blogtext FROM users WHERE username = :username");
    $statement->bindParam(':username', $_SESSION['username']);
    $statement->execute() or exit("SELECT failed.");

    // If no matching user, redirect to home page
    if($statement->rowCount()==0) {
        header('Location: ./');
        exit();
    }

    // Extract the blog text from the table
    $row = $statement->fetch() or exit("FETCH failed.");
    $blogtext = $row["blogtext"];
?>
<h2>Edit Blog Page</h2>

<p><a href="./">Home</a></p>
<form action="saveblogtext.php" method="post">
    <textarea name="blogtext" rows="12" cols="40"><?php print($blogtext) ?></textarea></br>
    <input type="submit" name="cancel" value="Cancel" size"24" />
    <input type="submit"               value="Save" size"24" />
</form>
