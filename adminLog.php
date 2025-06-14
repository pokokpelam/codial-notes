<?php
$host = "localhost";
$username = "root";       
$password = "";           
$dbname = "cordial";      

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$adminID = $_POST['username'];
$adminPass = $_POST['password'];

$stmt = $conn->prepare("SELECT * FROM admins WHERE adminID = ? AND password = ?");
$stmt->bind_param("ss", $adminID, $adminPass); 
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    header("Location: adminDash.php");
    exit();
} else {
    header("Location: adminLogHandler.php?error=1");
    exit();
}

$stmt->close();
$conn->close();
?>
