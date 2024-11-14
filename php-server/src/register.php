<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header class="header-section">
        <h1 class="titleText">PHP-based Secure Web App</h1>
    </header>
    <div class="bodySection">
        <p>Please register using a username and a password:</p>
        <div class="form-container">
            <form method="POST" action="">
                <label for="username">Username:</label>
                <input type="text" name="username" required>
                <br>
                <label for="password">Password:</label>
                <input type="password" name="password" required>
                <br>
                <input type="submit" value="Register">
            </form>
        <?php
        // Database connection
        $conn = new mysqli('db', 'user', 'password', 'my_db');

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Handle username and password submission
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_POST['username'];
            $password = $_POST['password'];

            // Generate a salt
            $salt = bin2hex(random_bytes(16));

            // Concatenate the salt with the password
            $salted_password = $salt . $password;

            // Hash the salted password
            $hashed_password = password_hash($salted_password, PASSWORD_DEFAULT);

            // Insert user data into database
            $sql = "INSERT INTO users (username, password, salt) VALUES ('$username', '$hashed_password', '$salt')";
            if ($conn->query($sql) === TRUE) {
                echo '<div class="notification success">Registration successful! Redirecting to login in 3 seconds...</div>';
                echo '<meta http-equiv="refresh" content="3;url=login.php">'; // Redirect after 3 seconds
            } else {
                echo '<div class="notification">Error: ' . $conn->error . '</div>';
            }
        }
        ?>
        </div>
        <p>Already have an account? <button id="next-btn" onclick="window.location.href='login.php'">Login here</button></p>    
    </div>
</body>
</html>

<?php
$conn->close();
?>
