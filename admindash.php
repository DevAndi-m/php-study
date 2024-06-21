<?php 
include('database.php');
session_start();

if (!isset($_SESSION['username']) && $_SESSION['acc_status'] == 1) {
    header("Location: login.php");
    exit;
} 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
    <h1>Admin Dashboard</h1>
    <?php 
        echo "Admin: " . $_SESSION['username'];
    ?>

    <div class="maincontainer">
        <div class="div-child one">
            <?php
                $show_sql = "SELECT * FROM users";

                $all_users = mysqli_query($conn, $show_sql);

                if(mysqli_num_rows($all_users) > 0) {
                    echo "<h1>Read Users</h1> <br><br>";
                    echo "<ul> ";
                    while($row = mysqli_fetch_assoc($all_users)) {
                        echo "<li>User ID: " . $row["id"]. "<br>username: " . $row["user"]. "<br>password: " . $row["password"] . "<br>Date and time created: ". $row["reg_date"]. "</li><br>"; // Adjust based on your table columns
                    }
                    echo "</ul>";     
                }
            ?>
        </div>
        <div class="div-child two">
            <h1>Create Users</h1> <br><br>
            <form action="admindash.php" method="post">
                <label>Username:</label>
                <input type="text" name="username"><br><br>
                <label>Password:</label>
                <input type="password" name="password"> <br><br>
                <label>Account Status:</label>
                <input type="num" name="acc_status" placeholder="Leave empty for 0"> <br><br>

                <input type="submit" name="create-account" value="Create user">
            </form>
            <?php 
                if($_SERVER["REQUEST_METHOD"] == "POST") {
                    if(isset($_POST["create-account"])) {
                        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
                        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
                        $account_status = filter_input(INPUT_POST, 'acc_status', FILTER_VALIDATE_INT);
            
                        if(empty($username)) {
                            echo"Username cannot be empty"; 
                        } elseif (empty($password)) {
                            echo "Password cannot be empty";
                        } else {
                            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
                            $create_sql = "INSERT INTO users (user, password, acc_status)
                                VALUES ('$username', '$hashed_password', '$account_status')";
            
                            try {
                            mysqli_query($conn, $create_sql);
                            echo "User has been created!";
                            } catch(mysqli_sql_exception) {
                                echo "There was an issue creating the user";
                            }
                        }
                    }
                }
            ?>
        </div>
        <div class="div-child three">
            <h1>Delete User</h1> <br><br>
            <form action="admindash.php" method="post">
                <label>ID of user to be deleted:</label>
                <input type="number" name="id"> <br><br>
                <input type="submit" name="delete_user" value="Delete user"> <br><br>
            </form>

            <?php 
                if($_SERVER["REQUEST_METHOD"] == "POST") {
                    if(isset($_POST['delete_user'])) {
                        $id_user = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

                        $del_sql = "DELETE FROM users WHERE id = $id_user";

                        $deleted_result = mysqli_query($conn, $del_sql);

                        try {
                            if($deleted_result && mysqli_affected_rows($conn) > 0) {
                                echo"User with id " . $id_user . " has been deleted successfuly";
                            } else {
                                echo"No account with id " . $id_user . " has been found!"; 
                            }
                        } catch(mysqli_sql_exception) {
                            echo "There was an error!";
                        }
                    }
                }
            ?>
        </div>
        <div class="div-child four">
            <h1>Edit a user</h1> <br><br>
            <form action="admindash.php" method="post">
                <label>ID of user:</label>
                <input type="number" name="id_user_edit"> <br><br>
                <label>New username:</label>
                <input type="text" name="username_edit"> <br><br>
                <label>New password:</label>
                <input type="text" name="password_edit"> <br><br>
                <label>Set account status:</label>
                <input type="number" name="acc_status_edit" placeholder="By default = 0"> <br><br>
                <input type="submit" name="edit_user" value="Confirm changes"> <br><br>
            </form>
            <?php 
                if($_SERVER["REQUEST_METHOD"] == "POST") {
                    if(isset($_POST['edit_user'])) {
                        $id_user_edit = filter_input(INPUT_POST, 'id_user_edit', FILTER_VALIDATE_INT);
                        $username_edit = filter_input(INPUT_POST, 'username_edit', FILTER_SANITIZE_SPECIAL_CHARS);
                        $password_edit = filter_input(INPUT_POST, 'password_edit', FILTER_SANITIZE_SPECIAL_CHARS);
                        $account_status_edit = filter_input(INPUT_POST, 'acc_status_edit' , FILTER_VALIDATE_INT);

                        if(empty($id_user_edit)) {
                            echo"The ID cannot be empty!";
                        } elseif (empty($username_edit)) {
                            echo"The username cannot be empty!";
                        } elseif (empty($password_edit)) {
                            echo"The password cannot be empty!";
                        } else {
                            $hashed_pass = password_hash($password_edit, PASSWORD_DEFAULT);
                            $edit_sql = "UPDATE users SET user = '$username_edit', password = '$hashed_pass', acc_status = '$account_status_edit' WHERE id = $id_user_edit";

                            try {
                                $edited_user_result = mysqli_query($conn, $edit_sql);

                                if($edited_user_result && mysqli_affected_rows($conn) > 0 ) {
                                    echo "User with id " . $id_user_edit . " edited successfully: <br><br> 
                                          username: " . $username_edit . "<br> 
                                          password: " . $password_edit . "<br>
                                          account status: " . $account_status_edit . "<br>";
                                }

                            } catch (mysqli_sql_exception) {
                                echo"Error:";
                            }
                            
                        }
                    }
                }
            ?>
        </div>
    </div>
</body>
</html>

<?php
    mysqli_close($conn);
?>