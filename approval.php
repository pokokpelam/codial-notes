<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['app_id'], $_POST['status'])) {
    $app_id = $_POST['app_id'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE applications SET status = ? WHERE applicationID = ?");
    $stmt->bind_param("si", $status, $app_id);
    $stmt->execute();
    $stmt->close();

    if ($status === 'approved') {
        $query = $conn->prepare("SELECT userID, role FROM applications WHERE applicationID = ?");
        $query->bind_param("i", $app_id);
        $query->execute();
        $result = $query->get_result();
        $applicant = $result->fetch_assoc();
        $query->close();

        $updateUser = $conn->prepare("UPDATE user SET role = ? WHERE userID = ?");
        $updateUser->bind_param("si", $applicant['role'], $applicant['userID']);
        $updateUser->execute();
        $updateUser->close();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Approval Page</title>
    <link rel="stylesheet" href="stylee.css">
</head>
<body>
<h1>User Applications</h1>
<div class="uplcontainer">
<?php
$result = $conn->query("SELECT * FROM applications WHERE status = 'pending'");
if ($result->num_rows > 0) {
    echo "<div class='search-results'>";
    while ($row = $result->fetch_assoc()) {
        echo "<div class='card'>";
        echo "<p><strong>Username:</strong> {$row['username']}</p>";
        echo "<p><strong>Name:</strong> {$row['name']}</p>";
        echo "<p><strong>Role:</strong> {$row['role']}</p>";
        echo "<p><strong>School:</strong> {$row['school']}</p>";
        echo "<p><strong>File:</strong><br><img src='{$row['file_name']}' alt='Uploaded File' 
                style='max-width:100%;height:auto;'></p>";
        echo "<form method='POST'>";
        echo "<input type='hidden' name='app_id' value='{$row['applicationID']}'>";
        echo "<select name='status'>
                <option value='approved'>Approve</option>
                <option value='rejected'>Reject</option>
              </select>";
        echo "<button type='submit'>Submit</button>";
        echo "</form>";
        echo "</div>";
    }
    echo "</div>";
} else {
    echo "<p>No applications yet.</p>";
}
?>
</div>
</body>
</html>
