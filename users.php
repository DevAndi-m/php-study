<?php 
    include("database.php");

    $show_sql = "SELECT * FROM users";

    $result = mysqli_query($conn, $show_sql);

    if (mysqli_num_rows($result) > 0) {
        // Output data of each row
        echo "<ul>";
        while($row = mysqli_fetch_assoc($result)) {
            echo "<li>User ID: " . $row["id"]. " - username: " . $row["user"]. " - password: " . $row["password"] . " - Date and time: ". $row["reg_date"]. "</li>"; // Adjust based on your table columns
        }
        echo "</ul>";
    } else {
        echo "0 results";
    }
    
    // Close the connection
    mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    Go to <a href="index.php">Register</a> 
</body>
</html>