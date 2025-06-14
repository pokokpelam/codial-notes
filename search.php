<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "cordial";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$search = isset($_GET['subject']) ? $conn->real_escape_string($_GET['subject']) : '';


$sqlDaily = "
SELECT 
    dm.materialID, 
    dm.title, 
    dm.shortdesc, 
    dm.date, 
    dm.uploaded_by, 
    dm.file_name, 
    m.category, 
    dm.likeCount, 
    dm.field, 
    NULL AS edu_level, 
    NULL AS subject, 
    NULL AS materialType
FROM dailymaterials dm
JOIN materials m ON dm.materialID = m.materialID
WHERE dm.title LIKE '%$search%' 
   OR dm.shortdesc LIKE '%$search%' 
   OR dm.field LIKE '%$search%' 
   OR dm.uploaded_by LIKE '%$search%'
";

$sqlAcad = "
SELECT 
    am.materialID, 
    am.title, 
    am.shortdesc, 
    am.date, 
    am.uploaded_by, 
    am.file_name, 
    m.category, 
    am.likeCount, 
    NULL AS field, 
    am.edu_level, 
    am.subject, 
    am.materialType
FROM acadmaterials am
JOIN materials m ON am.materialID = m.materialID
WHERE am.title LIKE '%$search%' 
   OR am.shortdesc LIKE '%$search%' 
   OR am.subject LIKE '%$search%' 
   OR am.edu_level LIKE '%$search%' 
   OR am.materialType LIKE '%$search%' 
   OR am.uploaded_by LIKE '%$search%'
";

$sqlCombined = "$sqlDaily UNION $sqlAcad ORDER BY date DESC";

$result = $conn->query($sqlCombined);

$materials = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $materials[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($materials);
