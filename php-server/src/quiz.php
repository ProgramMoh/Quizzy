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
    <link rel="stylesheet" href="additional_styles.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="SENG513 Assignment#2">
    <meta name="author" content="Mohamed Elnaggar">
    <title>Quizzy</title>
</head>
<body>
    <header class = "header-section">
        <div class="image-container">
            <img src="Quizzy.png" alt="logo" class="rotating-image">
        </div>

        <h1 class = "titleText">Welcome to Quizzy</h1>
    </header>
    <div class = "bodySection">
        <div class = "quiz-container">
            <div id = "quiz">
                <p class = "question" id = "question">Question appears here</p>
                <ul class = "choices" id = "choices"></ul>
                <button id = "next-btn">Next Question</button>
                <div id = "results"></div>
            </div>
        </div>
    </div>

    <script src = "quizscript.js"></script>
    
</body>
</html>