<?php
    // If user already logged in, then redirect to clickme page
    session_start();
    if (isset($_SESSION['username'])) {
        header('Location: ./clickme.php');
        exit(); // Ignores rest of code below when executed
    }
?>

<h2>Login Page</h2>
<form action="login.php" method="post">
Username: <input type="text"     value = "alice" name="username" size="36" /> <br>
Password: <input type="password" value = "1234"  name="password" size="36" /> <br>
          <input type="submit"   value = "Submit" />
</form>