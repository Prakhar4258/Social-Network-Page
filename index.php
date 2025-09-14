<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Social Network</title>
    <link rel="stylesheet" href="style.css">   
</head>
<body>
    <div class="card">
        <h2>Join Social Network</h2>

        
        <?php if (isset($_GET['msg']) && $_GET['msg'] == 'exists') { ?>
            <p style="color:red;">User already exists! Please login below.</p>
        <?php } elseif (isset($_GET['msg']) && $_GET['msg'] == 'registered') { ?>
            <p style="color:green;">Registration successful! Please login below.</p>
        <?php } ?>

        <form action="register.php" method="post" enctype="multipart/form-data">
            <div class="avatar">
                <img id="preview" src="download.png" alt="avatar">
                <br>
                <label for="profile_pic">Upload Profile Pic</label>
                <input type="file" id="profile_pic" name="profile_pic" accept="image/*">
            </div>

            <label for="name">Name:</label>
            <input type="text" name="name" id="name" required><br><br>

            <label for="dob">Date of Birth:</label>
            <input type="date" name="dob" id="dob" required><br><br>

            <label for="email">Email Address:</label>
            <input type="email" name="email" id="email" required><br><br>

            <div class="row">
                <div class="field">
                    <label for="password">Password</label>
                    <input id="password" name="password" type="password" placeholder="Enter password" required>
                    <div class="hint">Use A-Z, a-z, 0-9, !@#$%^&* in password</div>
                </div>

                <div class="field">
                    <label for="confirmPassword">Re - Password</label>
                    <input id="confirmPassword" name="confirmPassword" type="password" placeholder="Re-enter password" required>
                </div>
            </div>

          
            <button type="submit">Sign Up</button>
        </form>

      
        <form action="register.php" method="get" style="margin-top:10px;">
            <button type="submit">Login</button>
        </form>
    </div>

<script>
document.getElementById('profile_pic').addEventListener('change', function(event) {
    const [file] = event.target.files;
    if (file) {
        document.getElementById('preview').src = URL.createObjectURL(file);
    }
});
</script>
</body>
</html>
