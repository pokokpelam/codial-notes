<?php
include 'db.php';

if (!isset($_GET['id'])) {
    die("User ID not specified.");
}

$userID = $_GET['id'];

// Fetch user info
$stmt = $conn->prepare("SELECT * FROM user WHERE userID = ?");
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $role = $_POST["role"];

    $update = $conn->prepare("UPDATE user SET username = ?, email = ?, role = ? WHERE userID = ?");
    $update->bind_param("sssi", $username, $email, $role, $userID);
    if ($update->execute()) {
        echo "<script>alert('User updated successfully'); window.location.href = 'user_management.php';</script>";
    } else {
        echo "Error updating user.";
    }
    $update->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update User Information</title>
    <link rel="stylesheet" href="stylee.css">
    <link rel="icon" type="image/png" href="/images/favicon-32x32.png">
</head>
<body>
<h1>Update User Information</h1>
<div class="uplcontainer">
    <form method="POST">
        <label>Username</label>
        <input type="text" name="username" value="<?php echo $user['username']; ?>" required>

        <label>Email</label>
        <input type="email" name="email" value="<?php echo $user['email']; ?>" required>

        <label>Role</label>
        <select name="role">
            <option value="normaluser" <?php if ($user['role'] == 'normaluser') echo 'selected'; ?>>Normal User</option>
            <option value="student" <?php if ($user['role'] == 'student') echo 'selected'; ?>>Student</option>
            <option value="educator" <?php if ($user['role'] == 'educator') echo 'selected'; ?>>Educator</option>
        </select>
        <button type="submit" class="upload-btn">Update</button>
        <br><br><br>
    </form>
</div>
</body>
</html>
