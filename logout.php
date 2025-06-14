<?php
session_start();

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    $conn = new mysqli("localhost", "root", "", "cordial");
    if (!$conn->connect_error) {
        $stmt = $conn->prepare("INSERT INTO logouts (username) VALUES (?)");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->close();
        $conn->close();
    }
}

// End session
session_unset();
session_destroy();

// Redirect to logout page
header("Location: logout.html");
exit();
?>
