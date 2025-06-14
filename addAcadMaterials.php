<?php
session_start();
$uploaded_by = $_SESSION['username'];

$conn = new mysqli("localhost", "root", "", "cordial");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$title = $_POST['title'];
$edu_level = $_POST['edu_level'];
$subject = $_POST['subject'];
$shortdesc = $_POST['shortdesc'];
$materialType = $_POST['materialType'];
$category = $_POST['category'];

$target_dir = "uploads/";
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0777, true);
}

$originalFileName = basename($_FILES["file_name"]["name"]);
$target_file = $target_dir . $originalFileName;

$insertMaterials = $conn->prepare("INSERT INTO materials (category) VALUES (?)");
$insertMaterials->bind_param("s", $category);
$insertMaterials->execute();
$materialID = $conn->insert_id;

if (move_uploaded_file($_FILES["file_name"]["tmp_name"], $target_file)) {
    $sql = "INSERT INTO acadmaterials 
        (materialID, title, edu_level, subject, shortdesc, file_name, materialType, category, uploaded_by) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issssssss", $materialID, $title, $edu_level, $subject, $shortdesc, $originalFileName, $materialType, $category, $uploaded_by);

    if ($stmt->execute()) {
        echo "<script>
            alert('Note uploaded successfully!');
            window.location.href = 'dashboard.php';
        </script>";
    } else {
        echo "Error inserting into acadmaterials: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Error uploading file.";
}

$conn->close();
?>
