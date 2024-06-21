<?php 
    include("database.php");
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Log in page</h1>
    Not registered?<a href="index.php">Sign up</a> <br><br>

    <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post"> 
        <label>username:</label>
        <input type="text" name="username"> <br> 
        <label>password:</label>
        <input type="password" name="password"> <br><br>
        <input type="submit" name="submit" value="login">  
    </form>

    <a href="users.php">Users List</a> <br><br>
</body>
</html>

<?php 
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        // sanitization and filtering per injections
        $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);

        if(empty($username)) {
            echo "The username cannot be empty!";
        } elseif (empty($password)) {
            echo "the password cannot be empty!";
        } else {   
            $log_sql = "SELECT user, password, acc_status FROM users
                        WHERE user = '{$username}'";

            $result_user = mysqli_query($conn, $log_sql);

            if($result_user) {
                // metoda: komplet rreshti next si associative array - KEY/VALUE
                $row = mysqli_fetch_assoc($result_user);

                $hashed_password = $row['password'];

                if(password_verify($password , $hashed_password)) {
                    $_SESSION["username"] = $username;
                    $_SESSION["acc_status"] = $row['acc_status'];
                    header("Location: home.php");
                    exit;
                } else{
                    echo "Your password is incorrect!";
                }
            } else {
                echo "User not found";
            }
        } 
    }else {
        echo "Error" . mysqli_error($conn);
    }

    mysqli_close($conn);
?>