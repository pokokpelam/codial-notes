<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = new mysqli("localhost", "root", "", "cordial");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_POST['username'];
$password = $_POST['password'];


$stmt = $conn->prepare("SELECT password, role FROM user WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    
    if (password_verify($password, $row['password'])) {
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $row['role']; // ✅ This is the missing line

        echo "<script>
            alert('Login successful!');
            window.location.href = 'dashboard.php';
        </script>";
        exit();
    }
}

echo "<script>
    alert('Invalid username or password.');
    window.location.href = 'login.html';
</script>";
?>
