<?php
session_start();
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "network";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    
    $sql    = "SELECT * FROM userdata WHERE email='$email' AND password='$password' LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);

        $_SESSION['name']        = $row['name'];
        $_SESSION['email']       = $row['email'];
        $_SESSION['profile_pic'] = $row['profile_pic'];

        header("Location: profile.php");
        exit();
    } else {
        header("Location: profile.php?msg=invalid");
        exit();
    }
}
?>
