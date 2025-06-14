<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "cordial";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$materialID = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($materialID > 0) {
    $likeCount = 0;
    $tableUpdated = "";

    $result = $conn->query("SELECT likeCount FROM dailymaterials WHERE materialID = $materialID");
    if ($result && $result->num_rows > 0) {
        $conn->query("UPDATE dailymaterials SET likeCount = likeCount + 1 WHERE materialID = $materialID");
        $result = $conn->query("SELECT likeCount FROM dailymaterials WHERE materialID = $materialID");
        if ($row = $result->fetch_assoc()) {
            $likeCount = $row['likeCount'];
            $tableUpdated = "dailymaterials";
        }
    } else {
        $result = $conn->query("SELECT likeCount FROM acadmaterials WHERE materialID = $materialID");
        if ($result && $result->num_rows > 0) {
            $conn->query("UPDATE acadmaterials SET likeCount = likeCount + 1 WHERE materialID = $materialID");
            $result = $conn->query("SELECT likeCount FROM acadmaterials WHERE materialID = $materialID");
            if ($row = $result->fetch_assoc()) {
                $likeCount = $row['likeCount'];
                $tableUpdated = "acadmaterials";
            }
        }
    }

    if ($likeCount > 0) {
        echo json_encode([
            "likeCount" => $likeCount,
            "table" => $tableUpdated
        ]);
    } else {
        echo json_encode(["error" => "Material ID not found"]);
    }

} else {
    echo json_encode(["error" => "Invalid material ID"]);
}

$conn->close();
?>
