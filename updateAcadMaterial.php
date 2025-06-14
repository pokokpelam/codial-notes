<?php
include 'db.php';
session_start();
$userID = $_GET['userID'];

$query = "SELECT * FROM acadmaterials WHERE materialID='$id'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $shortdesc = $_POST['shortdesc'];
    $materialType = $_POST['materialType'];

    $updateQuery = "UPDATE acadmaterials SET shortdesc='$shortdesc', materialType='$materialType' WHERE materialID='$id'";
    mysqli_query($conn, $updateQuery);
    header("Location: dashboard.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Academic Material</title>
    <link rel="stylesheet" href="stylee.css">
</head>
<body>
    <h2>Update Academic Material</h2>
    <form method="POST">
        <label>Title (Read-only):</label>
        <input type="text" value="<?= $row['title'] ?>" readonly><br><br>

        <label>Short Description:</label>
        <textarea name="shortdesc" required><?= $row['shortdesc'] ?></textarea><br><br>

        <label>Material Type:</label>
        <input type="text" name="materialType" value="<?= $row['materialType'] ?>" required><br><br>

        <button type="submit">Update</button>
    </form>
</body>
</html>
