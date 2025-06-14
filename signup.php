<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = new mysqli("localhost", "root", "", "cordial");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$email = $_POST['email'];
$role = 'normaluser';

if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true && isset($_POST['role'])) {
    $role = $_POST['role'];
}

$stmt = $conn->prepare("INSERT INTO user (username, password, role, email) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $username, $password, $role, $email);

if ($stmt->execute()) {
    echo "<script>
        alert('Signup successful! Log in with the account you created.');
        window.location.href = 'login.html';
    </script>";
} else {
    echo "Signup failed: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
