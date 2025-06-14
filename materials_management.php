<?php
include 'db.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Materials Management</title>
    <link rel="icon" type="image/png" href="/images/favicon-32x32.png">
    <link rel="stylesheet" href="stylee.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid rgb(1, 130, 153);
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #e0f7fa;
        }

        h4 {
            text-align: center;
            margin-top: 0;
            font-size: 22px;
            color: rgb(1, 130, 153);
        }
    </style>
</head>
<body>
<h1>Materials Management</h1>
<div class="uplcontainer">
    <form method="GET">
        <label for="username">Search Materials by Username:</label>
        <input type="text" name="username" id="username">
        <button style="padding: 10px 20px; 
                        margin-left: 553px; 
                        margin-top: 10px;
                        border: none; 
                        background-color: rgb(1, 130, 153); 
                        color: white; 
                        border-radius: 5px; 
                        cursor: pointer;" 
                        type="submit">Search</button>
    </form>

    <?php
    function renderMaterialsTable($result, $type) {
        if ($result->num_rows > 0) {
            echo "<br><h4>$type Materials</h4>";
            echo "<table>";
            echo "<tr><th>Title</th><th>Uploaded By</th><th>Actions</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['title']) . "</td>";
                echo "<td>" . htmlspecialchars($row['uploaded_by']) . "</td>";

                // Safely encode filename
                $fileUrl = 'uploads/' . rawurlencode($row['file_name']);

                echo "<td>
                        <a href='$fileUrl' target='_blank'>View File</a> | 
                        <a href='delete_material.php?table=" . strtolower($type) . "materials&id=" . $row['materialID'] . "' onclick=\"return confirm('Delete this material?')\">Delete</a>
                      </td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No $type materials found.</p>";
        }
    }

    if (!isset($_GET['username'])) {
        echo "<br><br><h3>All Daily Materials</h3>";
        $daily = $conn->query("SELECT * FROM dailymaterials");
        renderMaterialsTable($daily, 'Daily');

        echo "<br><br><h3>All Academic Materials</h3>";
        $acad = $conn->query("SELECT * FROM acadmaterials");
        renderMaterialsTable($acad, 'Academic');
    } else {
        $username = $_GET['username'];

        $stmt = $conn->prepare("SELECT * FROM dailymaterials WHERE uploaded_by LIKE ?");
        $like = "%$username%";
        $stmt->bind_param("s", $like);
        $stmt->execute();
        $daily = $stmt->get_result();
        renderMaterialsTable($daily, 'Daily');

        $stmt = $conn->prepare("SELECT * FROM acadmaterials WHERE uploaded_by LIKE ?");
        $stmt->bind_param("s", $like);
        $stmt->execute();
        $acad = $stmt->get_result();
        renderMaterialsTable($acad, 'Academic');

        $stmt->close();
    }
    ?>
</div>
</body>
</html>
