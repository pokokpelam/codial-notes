<?php
include 'db.php';

if (!isset($_GET['id'])) {
    die("User ID not provided.");
}

$userID = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM user WHERE userID = ?");
$stmt->bind_param("i", $userID);

if ($stmt->execute()) {
    echo "<script>alert('User deleted successfully'); window.location.href = 'user_management.php';</script>";
} else {
    echo "Error deleting user.";
}

$stmt->close();
?>
