<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit;
}

// Database connection
$conn = new mysqli('db', 'user', 'password', 'my_db');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle delete user request
if (isset($_GET['delete'])) {
    $delete_username = $_GET['delete'];
    $sql = "DELETE FROM users WHERE username='$delete_username'";
    if ($conn->query($sql) === TRUE) {
        echo "User $delete_username deleted successfully.";
    } else {
        echo "Error deleting user: " . $conn->error;
    }
}

// Fetch users
$sql = "SELECT username FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Interface</title>
    <link rel="stylesheet" href="/styles.css">

</head>
<body>
    <h1>Admin Interface</h1>
    <h2>Registered Users</h2>
    <ul>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<li>" . htmlspecialchars($row['username']) . " <a href='admin.php?delete=" . urlencode($row['username']) . "'>Delete</a></li>";
            }
        } else {
            echo "<li>No users found.</li>";
        }
        ?>
    </ul>
    <a href="logout.php">Logout</a>
</body>
</html>

<?php
$conn->close();
?>
