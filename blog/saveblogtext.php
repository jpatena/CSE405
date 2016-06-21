<?php
    session_start();

    // If the user is not logged in or
    // If submitted data is invalid, redirect to home page
    if (!isset($_SESSION['username']) or !isset($_POST['blogtext'])) {
        header('Location: ./');
        exit();
    }

    // If user click cancel, redirect to view blog page
    if (isset($_POST['cancel'])) {
        header('Location: viewblog.php?u=' . $_SESSION['username']);
        exit();
    }

    // Assume that the Save button was clicked

    // Extract the submitted blogtext
    $blogtext = $_POST['blogtext'];;

    // Connect to the database
    try {
        $dbhost = new PDO("mysql:host=localhost;dbname=blog", "root", NULL);
    } catch (PDOException $e) {
        exit('Database connection failed: ' . $e->getMessage());
    }    
    // Retrieve the actual password for given user
    $statement = $dbhost->prepare("UPDATE users SET blogtext = :blogtext WHERE username= :username");
    $statement->bindParam(':blogtext', $blogtext);
    $statement->bindParam(':username', $_SESSION['username']);
    $statement->execute() or exit("UPDATE failed.");

    // Redirect to the view blog page confirm changes
    header('Location: viewblog.php?u=' . $_SESSION['username']);
?>