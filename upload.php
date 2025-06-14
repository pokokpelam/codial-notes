<?php
session_start();

if (!isset($_SESSION['username']) || !isset($_SESSION['role'])) {
    echo "<script>alert('Please log in to access this page.'); window.location.href = 'login.php';</script>";
    exit();
}

$role = $_SESSION['role'];
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CORDIAL: Upload</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/images/favicon-32x32.png">
    <link rel="stylesheet" href="stylee.css">
    <link rel="stylesheet" href="fade.css">

    <script>
        // Pass PHP role into JS variable
        const role = "<?php echo $role; ?>";

        function handleAcademicClick() {
            if (role =='normaluser') {
                alert("You need approval before uploading academic materials. Please visit the EduApprove page.");
                window.location.href = "approve.html";
                return false; // Prevent default navigation
            }
            // Otherwise, allow navigation
            window.location.href = "uploadacad.php?scope=academic";
        }

        function handleDailyClick() {
            window.location.href = "uploaddaily.html?scope=daily";
        }
    </script>
</head>
<body>
    <div class="nav">
        <img src="cordial logo.png" alt="logo">
        <div>
            <a href="dashboard.php">Dashboard</a>
            <a href="upload.php">Upload</a>
            <a href="search.html">Search</a>
            <a href="logout.php">Logout</a>
            <a href="approve.html">EduApprove</a>
        </div>
    </div>

    <h2 class="fade-up" style="text-align: center;">What's Your Scope?</h2>

    <div class="container fade-up">
        <div class="card">
            <button onclick="handleDailyClick()">DAILY LIFE</button>
            <div class="desc">
                <ul>
                    <li>Cooking Recipes</li>
                    <li>Sports Diary</li>
                    <li>Gardening Tips</li>
                    <li>Fashion Advice</li>
                    <li>Lyrics</li>
                </ul>
            </div>
        </div>

        <div class="card">
            <button onclick="handleAcademicClick()">ACADEMIC</button>
            <div class="desc">
                <ul>
                    <li>Past-Year Papers</li>
                    <li>Practice exams</li>
                    <li>Topic-based quizzes</li>
                    <li>Lecture Notes</li>
                    <li>Assignment examples</li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>
