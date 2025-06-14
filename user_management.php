<?php
include 'db.php'; 
?>
<!DOCTYPE html>
<html>
<head>
    <title>User Management</title>
    <link rel="stylesheet" href="stylee.css">
    <link rel="icon" type="image/png" href="/images/favicon-32x32.png">
    <style>
        body {
            border-radius: 50px;
        }
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
    </style>
</head>
<body>
<h1>User Management</h1>
<div class="uplcontainer">
    <form method="GET">
        <label for="username">Search Username:</label>
        <input type="text" name="username" id="username">
        <button style="padding: 10px 20px; 
                        margin-left: 553px; 
                        margin-top: 10px;
                        border: none; 
                        background-color: rgb(1, 130, 153); 
                        color: white; 
                        border-radius: 
                        5px; 
                        cursor: pointer;" 
                        type="submit">Search</button>
    </form>

    <?php
    function renderUserTable($result) {
        echo "<table>";
        echo "<tr><th>Username</th><th>Email</th><th>Role</th><th>Actions</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['username']}</td>";
            echo "<td>{$row['email']}</td>";
            echo "<td>{$row['role']}</td>";
            echo "<td><a href='update_user.php?id={$row['userID']}'>Update</a> | ";
            echo "<a href='delete_user.php?id={$row['userID']}' onclick=\"return confirm('Are you sure?')\">Delete</a></td>";
            echo "</tr>";
        }
        echo "</table>";
    }

    if (!isset($_GET['username'])) {
        $result = $conn->query("SELECT * FROM user");
        echo "<br><br><h3>All Users</h3>";
        renderUserTable($result);
    }

    if (isset($_GET['username'])) {
        $username = $_GET['username'];
        $stmt = $conn->prepare("SELECT * FROM user WHERE username LIKE ?");
        $stmt->bind_param("s", $username_like);
        $username_like = "%$username%";
        $stmt->execute();
        $result = $stmt->get_result();

        echo "<h3>Search Results</h3>";
        renderUserTable($result);

        $stmt->close();
    }
    ?>
</div>
</body>
</html>
