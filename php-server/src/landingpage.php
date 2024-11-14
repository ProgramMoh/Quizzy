<?php
session_start(); 

// Redirect to login page if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); 
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Landing Page</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header class="header-section">
        <h1 class="titleText">Welcome to the Landing Page</h1>
    </header>

    <div class="bodySection">
        <h2>Hello, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>

        <div>
            <?php if ($_SESSION['username'] === 'admin') : ?>
                <button id="next-btn" onclick="window.location.href='admin.php'" style="margin-right: 1rem;">Go to Admin Interface</button>
            <?php endif; ?>
            <button id="quiz-btn" onclick="window.location.href='quiz.php'" style="margin-left: 1rem;">Start Quiz</button>
            <button id="logout-btn" onclick="window.location.href='logout.php'" style="margin-left = 1rem;">Logout</button>
        </div>
    </div>
</body>
</html>
