<?php
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "network";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['name'])) {
    $name     = $_POST['name'];
    $email    = $_POST['email'];
    $password = $_POST['password'];
    $dob      = $_POST['dob'];

    
    $check_sql = "SELECT * FROM userdata WHERE Email = '$email'";
    $result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($result) > 0) {
        
        header("Location: index.php?msg=exists");
        exit();
    } else {
        
        $insert_sql = "INSERT INTO userdata (Name, Email, Password, dob) 
                       VALUES ('$name', '$email', '$password', '$dob')";

        if (mysqli_query($conn, $insert_sql)) {
            header("Location: index.php?msg=registered");
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Social Network</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="card">
        <h2>Login</h2>
        <form action="welcome.php" method="post">
            <label for="email">Email Address:</label>
            <input type="email" name="email" id="email" required><br><br>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required><br><br>

            <button type="submit">Login</button>
            <div class="hint">Don't have an account? <a href="index.php">Create Account</a></div>
        </form>
    </div>
</body>
</html>
