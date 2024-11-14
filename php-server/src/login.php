<?php
session_start();

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

    // Check if user exists
    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Retrieve the salt from the database
        $salt = $row['salt'];
        
        // Concatenate the salt with the inputted password
        $salted_password = $salt . $password;

        // Hash the inputted salted password and verify
        if (password_verify($salted_password, $row['password'])) {
            $_SESSION['username'] = $username; // Store username in session
            header("Location: landingpage.php"); // Redirect to landing page
            exit();        
        } else {
            $_SESSION['notification'] = "Invalid password.";
        }
    } else {
        $_SESSION['notification'] = "User not found.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header class="header-section">
        <h1 class="titleText">PHP-based Secure Web App</h1>
    </header>
    
    <div class="bodySection">
        <p>Please login using your username and password:</p>
        <div class="form-container">
            <form method="POST" action="">
                <label for="username">Username:</label>
                <input type="text" name="username" required>
                <br>
                <label for="password">Password:</label>
                <input type="password" name="password" required>
                <br>
                <input type="submit" value="Login">
            </form>
        </div>
        
        <p>Don't have an account? <button onclick="window.location.href='register.php'">Register here</button></p>    
    </div>
    <?php
    // Display notification
    if (isset($_SESSION['notification'])) {
        echo '<div class="notification">' . $_SESSION['notification'] . '</div>';
        unset($_SESSION['notification']); // Clear the notification after displaying it
    }
    ?>
</body>
</html>
