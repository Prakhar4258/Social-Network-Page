<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "network";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $pass  = $_POST['password'];

    $sql = "SELECT * FROM userdata WHERE Email='$email' LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);

        if ($row['Password'] === $pass) {
            // success
            $_SESSION['name']  = $row['Name'];
            $_SESSION['email'] = $row['Email'];

            header("Location: profile.php");
            exit();
        } else {
            echo "❌ Wrong password for this email!";
        }
    } else {
        echo "❌ Email not found in database!";
    }
}
?>
