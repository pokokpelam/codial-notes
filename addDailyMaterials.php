<?php
session_start();
$uploaded_by = $_SESSION['username'];

$conn = new mysqli("localhost", "root", "", "cordial");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$title = $_POST['title'];
$field = $_POST['field'];
$shortdesc = $_POST['shortdesc'];
$category = $_POST['category'];

$target_dir = "uploads/";
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0777, true);
}

$originalFileName = basename($_FILES["file_name"]["name"]);
$target_file = $target_dir . $originalFileName;

if (move_uploaded_file($_FILES["file_name"]["tmp_name"], $target_file)) {

    $sql_materials = "INSERT INTO materials (category) VALUES (?)";
    $stmt_materials = $conn->prepare($sql_materials);
    $stmt_materials->bind_param("s", $category);

    if (!$stmt_materials->execute()) {
        die("Error inserting into materials: " . $stmt_materials->error);
    }

    $materialID = $conn->insert_id;
    $stmt_materials->close();

    $sql_daily = "INSERT INTO dailymaterials (materialID, title, shortdesc, field, file_name, category, uploaded_by)
                  VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt_daily = $conn->prepare($sql_daily);
    $stmt_daily->bind_param("issssss", $materialID, $title, $shortdesc, $field, $originalFileName, $category, $uploaded_by);

    if ($stmt_daily->execute()) {
        echo "<script>
            alert('Note uploaded successfully!');
            window.location.href = 'dashboard.php';
        </script>";
    } else {
        echo "Error inserting into dailymaterials: " . $stmt_daily->error;
    }

    $stmt_daily->close();
} else {
    echo "Error uploading file.";
}

$conn->close();
?>
