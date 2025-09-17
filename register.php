<?php
session_start();
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "network";


$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name     = mysqli_real_escape_string($conn, $_POST['name']);
    $dob      = $_POST['dob'];
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $confirm  = $_POST['confirmPassword'];

    
    if ($password !== $confirm) {
        header("Location: index.php?msg=password_mismatch");
        exit();
    }

    
    $check = mysqli_query($conn, "SELECT * FROM userdata WHERE email='$email'");
    if (mysqli_num_rows($check) > 0) {
        header("Location: index.php?msg=exists");
        exit();
    }

    
    $profile_pic = "default.png"; 
    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $file_name   = time() . "_" . basename($_FILES["profile_pic"]["name"]);
        $target_file = "{$target_dir}{$file_name}";
        if (move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_file)) {
            $profile_pic = $file_name; 
        }
    }

    
    $sql = "INSERT INTO userdata (name, dob, email, password, profile_pic) 
            VALUES ('$name', '$dob', '$email', '$password', '$profile_pic')";

    if (mysqli_query($conn, $sql)) {
        
        $_SESSION['name']        = $name;
        $_SESSION['email']       = $email;
        $_SESSION['profile_pic'] = $profile_pic;

        header("Location: profile.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
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
