<?php
    session_start(); // Start the session

    // Database connection
    $conn = new mysqli('db', 'user', 'password', 'my_db');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Check if user exists
        $sql = "SELECT * FROM users WHERE username='$username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // Verify password
            if (password_verify($password, $row['password'])) {
                $_SESSION['username'] = $username; // Store username in session
                echo "Login successful! Welcome, " . htmlspecialchars($username);
            } else {
                echo "Invalid password.";
            }
        } else {
            echo "User not found.";
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
    <h1>User Login</h1>
    <form method="POST" action="">
        <label for="username">Username:</label>
        <input type="text" name="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" required>
        <br>
        <input type="submit" value="Login">
    </form>

</body>
</html>
