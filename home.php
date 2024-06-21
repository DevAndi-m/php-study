<?php 
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<h1>Welcome to the homepage, <?php echo $_SESSION["username"] ?> </h1>
<h3>Account status is: <?php echo $_SESSION["acc_status"] ?> </h3>

<a href="pages/page1.php">Page 1</a>
<a href="pages/page2.php">Page 2</a>
<a href="pages/page3.php">Page 3</a><br> <br>

<form action="home.php" method="post">
    <input type="submit" name="submit" value="Log out">
</form>
    
<?php 
    if ($_SESSION['acc_status'] == 1) {
        echo '<a href="admindash.php">Go to admin dashboard</a>';
    }
?>
</body>
</html>

<?php 
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $_SESSION = array();

        session_destroy();
    
        header("Location: index.php");
        exit;
    }
?>
