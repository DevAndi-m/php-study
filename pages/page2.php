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
    <h1>Page 2</h1>

    Welcome back <?php echo $_SESSION["username"]?>
    
    <a href="../home.php">Go home</a>
</body>
</html>