<?php
    session_start();

    // Connect to the database
    try {
        $dbhost = new PDO("mysql:host=localhost;dbname=blog", "root", NULL);
    } catch (PDOException $e) {
        exit('Database connection failed: ' . $e->getMessage());
    }    
    // Retrieve the click count for logged in user
    $statement = $dbhost->prepare("SELECT blogtext FROM users WHERE username = :username");
    $statement->bindParam(':username', $_GET['u']);
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
<h2>Blog Page</h2>

<p><a href="./">Home</a></p>

<div id="blogtext"><?php print($blogtext) ?></div>

<?php if (isset($_SESSION['username']) and $_SESSION['username'] == $_GET['u']) { ?>
    <button onclick="window.location='editblog.php'">Edit</button>
<?php } ?>
