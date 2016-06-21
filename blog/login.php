<?php
    session_start();

    // Extract the submitted username and password
    $username = $_POST['username'];
    $submitted_password = $_POST['password'];

    // Redirect to home page when called
    function redirect() {
        header('Location: ./');
        exit();
    }

    // Check for invalid data entry
    if (!isset($username) or !isset($submitted_password)) {
        redirect();
    }
    
    // Connect to the database
    try {
        $dbhost = new PDO("mysql:host=localhost;dbname=blog", "root", NULL);
    } catch (PDOException $e) {
        exit('Database connection failed: ' . $e->getMessage());
    }    
        // Retrieve the actual password for given user
        $statement = $dbhost->prepare("SELECT password FROM users WHERE username= :username");
        $statement->bindParam(':username',$username);
        $statement->execute() or exit("SELECT failed.");

        // If no matching user, redirect to login page
        if($statement->rowCount()==0) {
            redirect();
        }

        // Fetch the actual password from the table
        $row = $statement->fetch() or exit("FETCH failed.");
        $actual_password = $row["password"];
        
        // If the submitted password doesn't match, redirect to login page
        if($submitted_password != $actual_password) {
            redirect();
        }
    // Log the user in
    $_SESSION['username'] = $username;

    // Redirect to the home page
    header('Location: ./')
?>