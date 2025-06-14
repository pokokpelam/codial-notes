<?php
include 'db.php';
session_start();
$userID = $_GET['userID'];

$query = "SELECT * FROM dailymaterials WHERE materialID='$id'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $shortdesc = $_POST['shortdesc'];

    $updateQuery = "UPDATE dailymaterials SET shortdesc='$shortdesc' WHERE materialID='$id'";
    mysqli_query($conn, $updateQuery);
    header("Location: dashboard.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Daily Material</title>
    <link rel="stylesheet" href="stylee.css">
</head>
<body>
    <h2>Update Daily Material</h2>
    <form method="POST">
        <label>Title (Read-only):</label>
        <input type="text" value="<?= $row['title'] ?>" readonly><br><br>

        <label>Short Description:</label>
        <textarea name="shortdesc" required><?= $row['shortdesc'] ?></textarea><br><br>

        <button type="submit">Update</button>
    </form>
</body>
</html>
