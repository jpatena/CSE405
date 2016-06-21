<?php
    session_start();
    
    // If user is not logged in
    if (!isset($_SESSION['username'])) {
        exit();
    }
    
    $username = $_SESSION['username'];

    // Connect to the database
    try {
        // Create PHP data object
        $dbhost = new PDO("mysql:host=localhost;dbname=react", "root", NULL);
        $dbhost->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
        $statement = $dbhost->prepare('UPDATE users SET click_count = click_count + 1 WHERE username=:username');
        $statement->bindParam(':username', $username);
        $statement->execute();
        $statement = $dbhost->prepare('SELECT click_count FROM users WHERE username=:username');
        $statement->bindParam(':username', $username);
        $statement->execute();
        if ($statement->rowCount() == 0) {
            $response = array('error' => 'Something unknown has happened');
            print(json_encode($response));
            exit();   
        }
        $row = $statement->fetch();
    } catch (PDOException $e) {
        // If fails to connect
        $response = array('result' => 'error', 'msg' => $e->getMessage());
        print(json_encode($response));
        exit();
    }     
    
    $clickCount = $row['click_count']; 
    
    $response = array('result' => 'success', 'clickCount' => $clickCount);
    print(json_encode($response));
?>