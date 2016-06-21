<?php
    session_start();
    
    //$request = json_decode(file_get_contents("php://input"),true);
    
    // If user is not logged in
    if (!isset($_SESSION['username'])) {
        $response = array('result' => 'notLoggedIn');
        print(json_encode($response));
        exit();
    }
    
    $username = $_SESSION['username'];

    // Connect to the database
    try {
        // Create PHP data object
        $dbhost = new PDO("mysql:host=localhost;dbname=react", "root", NULL);
        $dbhost->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // select the click count from table
        $statement = $dbhost->prepare('SELECT click_count FROM users WHERE username=:username');
        $statement->bindParam(':username', $username);
        $statement->execute() or exit("SELECT failed.");
        
        if ($statement->rowCount() == 0) {
            // User record deleted after login
            exit();
        }
        
        // fetch the click count
        $row = $statement->fetch() or exit("FETCH failed.");
        $clickCount = $row["click_count"];
        
    } catch (PDOException $e) {
        // If fails to connect
        $response = array('result' => 'error', 'msg' => $e->getMessage());
        print(json_encode($response));
        exit();
    }     
    
    $response = array('result' => 'loggedIn', 'clickCount' => '$clickCount');
    print(json_encode($response));
?>