<?php
    session_start();
    
    $request = json_decode(file_get_contents("php://input"),true);

    $username = $request['username'];
    $password = $request['password'];
    
    if(is_null($username) || is_null($password)) {
        $response = array('result' => 'error', 'msg' => 'Invalid request');
        print(json_encode($response));
        exit();
    }

    // Connect to the database
    try {
        // Create PHP data object
        $dbhost = new PDO("mysql:host=localhost;dbname=react", "root", NULL);
  
        // select the counter column from the page_views table
        $statement = $dbhost->prepare('SELECT password, click_count FROM users WHERE username=:username');
        $statement->bindParam(':username', $username);
        $statement->execute() or exit("SELECT failed.");
        if ($statement->rowCount() == 0) {
            $response = array('result' => 'failure');
            print(json_encode($response));
            exit();   
        }
        
        // fetch the password
        $row = $statement->fetch() or exit("FETCH failed.");
        $actual_password = $row["password"];
        // if wrong password
        if ($password != $actual_password) {
            $response = array('result' => 'failure');
            print(json_encode($response));
            exit();       
        }
    } catch (PDOException $e) {
        // If fails to connect
        $response = array('result' => 'error', 'msg' => $e->getMessage());
        print(json_encode($response));
        exit();
    }       
    
    // Put username in session when logged in
    $_SESSION['username'] = $username;
    
    $clickCount = $row['click_count']; 
    
    $response = array('result' => 'success', 'clickCount' => $clickCount);
    print(json_encode($response));
?>