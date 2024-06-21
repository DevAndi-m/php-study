<?php
    include("database.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
        <h1>Register as a new user</h1>
        <br>
        <label>username:</label>
        <input type="text" name="username">
        <br>
        <label>password:</label>
        <input type="password" name="password">
        <br>
        <br>
        <input type="submit" name="submit" value="Regiser!">
    </form>
    Already registered?<a href="login.php">Log in</a> <br><br>
    <a href="users.php">Users List</a> <br><br>
</body>
</html>

<?php 
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);

        if(empty($username)) {
            echo "The username cannot be empty!";
        } elseif (empty($password)) {
            echo "The password cannot be empty!";
        } else {
            
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO users (user, password)
                    VALUES ('$username', '$hashed_password')";

            try {
                mysqli_query($conn, $sql);
                echo "You are now registered!";
            } catch(mysqli_sql_exception) {
                echo "There was an issue in your registration!";
            }

        }
    };

    mysqli_close($conn);
?>