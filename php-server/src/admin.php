<?php
session_start(); 

// Redirect to login page if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); 
    exit();
}

// Redirect to landing page if not admin
if ($_SESSION['username'] !== 'admin') {
    header("Location: landingpage.php"); 
    exit();
}

// Database connection
$conn = new mysqli('db', 'user', 'password', 'my_db');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle 'delete user'
if (isset($_GET['delete'])) {
    $delete_username = $_GET['delete'];
    $sql = "DELETE FROM users WHERE username='$delete_username'";
    if ($conn->query($sql) === TRUE) {
        echo '<div class="notification success">User ' . htmlspecialchars($delete_username) . ' deleted successfully.</div>';
    } else {
        echo '<div class="notification">Error deleting user: ' . $conn->error . '</div>';
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
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header class="header-section">
        <h1 class="titleText">Admin Interface</h1>
    </header>
    
    <div class="bodySection">
        <h2>Registered Users</h2>
        <div class="list-container">
            <div class="user-list">
                <?php
                // Display users
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='user-item'>" . htmlspecialchars($row['username']) . " <a class='next-btn' href='admin.php?delete=" . urlencode($row['username']) . "'>Delete</a></div>";
                    }
                } else {
                    echo "<div class='user-item'>No users found.</div>";
                }
                ?>
            </div>
        </div>
        <button id="logout-btn" onclick="window.location.href='logout.php'">Logout</button>
    </div>
</body>
</html>

<?php
$conn->close();
?>
