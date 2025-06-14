<?php
include 'db.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Report</title>
    <link rel="stylesheet" href="stylee.css">
    <link rel="icon" type="image/png" href="/images/favicon-32x32.png">
    <style>
        .report-section {
            background-color: #f9f9f9;
            border: 2px solid rgb(1, 130, 153);
            border-radius: 10px;
            padding: 10px;
            margin-bottom: 30px;
            box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.05);
        }

        .report-section h3 {
            margin-top: 0;
            color: rgb(1, 130, 153);
            border-bottom: 1px solid #ccc;
            padding-bottom: 10px;
            text-transform: uppercase;
            font-size: 20px;
        }

        .report-section ul {
            list-style-type: none;
            padding: 0;
        }

        .report-section ul li,
        .report-section p {
            padding: 1px 0;
            font-size: 16px;
            color: #333;
            text-transform: uppercase;
            font-weight: bold;
            letter-spacing: 0.5px;
        }

        .highlight {
            font-size: 18px;
            font-weight: bold;
            color: rgb(0, 102, 153);
            text-transform: uppercase;
        }

    </style>
</head>
<body>
    <h1 style="text-align:center;">Admin Report Summary</h1>
    <div class="uplcontainer">

        <!-- Total Users by Role -->
        <div class="report-section">
            <h3>Total Users by Role</h3>
            <ul>
                <?php
                $query = "SELECT role, COUNT(*) as total FROM user GROUP BY role";
                $result = $conn->query($query);
                while ($row = $result->fetch_assoc()) {
                    echo "<li><span class='highlight'>{$row['role']}</span>: {$row['total']}</li>";
                }
                ?>
            </ul>
        </div>

        <!-- Top Daily Material Field -->
        <div class="report-section">
            <h3>Top Daily Material Field</h3>
            <?php
            $query = "SELECT field, COUNT(*) as total FROM dailymaterials GROUP BY field ORDER BY total DESC LIMIT 1";
            $result = $conn->query($query);
            $row = $result->fetch_assoc();
            echo "<p><span class='highlight'>{$row['field']}</span> with {$row['total']} uploads</p>";
            ?>
        </div>

        <!-- Top Academic Material Type -->
        <div class="report-section">
            <h3>Top Academic Material Type</h3>
            <?php
            $query = "SELECT materialType, COUNT(*) as total FROM acadmaterials GROUP BY materialType ORDER BY total DESC LIMIT 1";
            $result = $conn->query($query);
            $row = $result->fetch_assoc();
            echo "<p><span class='highlight'>{$row['materialType']}</span> with {$row['total']} uploads</p>";
            ?>
        </div>

    </div>
</body>
</html>
