<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

$conn = new mysqli("localhost", "root", "", "cordial");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$materialID = intval($_GET['id']);
$username = $_SESSION['username'];
$file = null;

$stmt = $conn->prepare("SELECT file_name FROM acadmaterials WHERE materialID = ? AND uploaded_by = ?");
$stmt->bind_param("is", $materialID, $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $file = $result->fetch_assoc()['file_name'];

    $deleteAcad = $conn->prepare("DELETE FROM acadmaterials WHERE materialID = ?");
    $deleteAcad->bind_param("i", $materialID);
    $deleteAcad->execute();
} else {
    $stmt = $conn->prepare("SELECT file_name FROM dailymaterials WHERE materialID = ? AND uploaded_by = ?");
    $stmt->bind_param("is", $materialID, $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $file = $result->fetch_assoc()['file_name'];

        $deleteDaily = $conn->prepare("DELETE FROM dailymaterials WHERE materialID = ?");
        $deleteDaily->bind_param("i", $materialID);
        $deleteDaily->execute();
    }
}

if ($file) {
    $filePath = "uploads/" . $file;
    if (file_exists($filePath)) {
        unlink($filePath);
    }

    $deleteMaterial = $conn->prepare("DELETE FROM materials WHERE materialID = ?");
    $deleteMaterial->bind_param("i", $materialID);
    $deleteMaterial->execute();
}

$conn->close();
header("Location: dashboard.php");
exit();
