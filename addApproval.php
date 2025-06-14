<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cordial";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo "<script>alert('Database connection failed.'); window.location.href = 'approve.html';</script>";
    exit();
}

$submittedUsername = $_POST['username'];
$name = $_POST['name'];
$school = $_POST['school'];
$role = $_POST['role'];

if (empty($submittedUsername) || empty($name) || empty($school) || empty($role)) {
    echo "<script>alert('All fields are required.'); window.location.href = 'approve.html';</script>";
    exit();
}

$stmt = $conn->prepare("SELECT userID FROM user WHERE username = ?");
$stmt->bind_param("s", $submittedUsername);
$stmt->execute();
$stmt->bind_result($userID);
$stmt->fetch();
$stmt->close();

if (!$userID) {
    echo "<script>alert('Username not found. Please register or check your spelling.'); window.location.href = 'approve.html';</script>";
    exit();
}

if (!isset($_FILES['document']) || $_FILES['document']['error'] !== UPLOAD_ERR_OK) {
    echo "<script>alert('Error uploading document. Please try again.'); window.location.href = 'approve.html';</script>";
    exit();
}

$uploadDir = "uploads/approvals/";
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$uploadedFileName = basename($_FILES['document']['name']);
$targetPath = $uploadDir . uniqid() . "_" . $uploadedFileName;

if (!move_uploaded_file($_FILES['document']['tmp_name'], $targetPath)) {
    echo "<script>alert('Failed to save uploaded file.'); window.location.href = 'approve.html';</script>";
    exit();
}

$stmt = $conn->prepare("INSERT INTO applications (userID, username, name, role, school, file_name, status, created_at) VALUES (?, ?, ?, ?, ?, ?, 'pending', NOW())");
$stmt->bind_param("isssss", $userID, $submittedUsername, $name, $role, $school, $targetPath);

if ($stmt->execute()) {
    echo "<script>alert('Application submitted successfully!'); window.location.href = 'dashboard.php';</script>";
} else {
    echo "<script>alert('Error submitting application: " . $stmt->error . "'); window.location.href = 'approve.html';</script>";
}

$stmt->close();
$conn->close();
?>
