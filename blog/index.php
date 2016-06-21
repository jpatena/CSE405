<?php
    session_start();

    // Connect to the database
    try {
        $dbhost = new PDO("mysql:host=localhost;dbname=blog", "root", NULL);
    } catch (PDOException $e) {
        exit('Database connection failed: ' . $e->getMessage());
    }    
    // Retrieve the blog text for logged in user
    $statement = $dbhost->prepare("SELECT username FROM users");
    $statement->bindParam(':username', $_GET['u']);
    $statement->execute() or exit("SELECT failed.");
?>

<h2>Available Blogs</h2></h2>
<ul>
<?php
// display all the users
foreach($statement as $row) {
    $u = $row['username'];
    echo '<li><a href="viewblog.php?u=' . $u . '">' . $u . '</a></li>';
}
?>
</ul>

<?php if(isset($_SESSION['username'])) { ?>
    <!-- if logged in, show logout -->
    <form action="logout.php" method ="post">
        <input type="submit" value="Logout" />
    </form>
<?php } else { ?>
    <!-- if not logged in, show login -->
    <form action="login.php" method="post">
        Username: <input type="text"     value = "blake" name="username" size="16" /> <br>
        Password: <input type="password" value = "1234"  name="password" size="16" /> <br>
          <input type="submit"   value = "Login" />
    </form>
<?php } ?>
