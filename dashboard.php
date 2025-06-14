<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

$username = $_SESSION['username'];

$conn = new mysqli("localhost", "root", "", "cordial");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user's uploads from both dailymaterials and acadmaterials
$userUploads = [];
$stmt = $conn->prepare("
    SELECT 
        m.materialID, 
        m.category, 
        d.title, 
        d.shortdesc, 
        d.date, 
        d.uploaded_by, 
        d.file_name, 
        d.likeCount, 
        d.field,
        '' AS edu_level, 
        '' AS subject, 
        '' AS materialType
    FROM materials m
    JOIN dailymaterials d ON m.materialID = d.materialID
    WHERE d.uploaded_by = ?

    UNION ALL

    SELECT 
        m.materialID, 
        m.category, 
        a.title, 
        a.shortdesc, 
        a.date, 
        a.uploaded_by, 
        a.file_name, 
        a.likeCount, 
        '' AS field,
        a.edu_level, 
        a.subject, 
        a.materialType
    FROM materials m
    JOIN acadmaterials a ON m.materialID = a.materialID
    WHERE a.uploaded_by = ?
    
    ORDER BY date DESC
");

$stmt->bind_param("ss", $username, $username);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $row['field'] = isset($row['field']) ? $row['field'] : '';
    $row['edu_level'] = isset($row['edu_level']) ? $row['edu_level'] : '';
    $row['subject'] = isset($row['subject']) ? $row['subject'] : '';
    $row['materialType'] = isset($row['materialType']) ? $row['materialType'] : '';

    $userUploads[] = $row;
}

$stmt->close();

$totalUsersResult = $conn->query("SELECT COUNT(*) as total FROM user");
$totalUsers = $totalUsersResult->fetch_assoc()['total'];

$recentUsersResult = $conn->query("SELECT username FROM logouts ORDER BY userID DESC LIMIT 5");
$recentUsers = [];
while ($row = $recentUsersResult->fetch_assoc()) {
    $recentUsers[] = $row['username'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CORDIAL: Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="fade.css">
    <link rel="icon" type="image/png" href="/images/favicon-32x32.png">
    
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            background-color:rgb(255, 255, 255);
            padding: 20px;
        }
        img {
            width: 25%;
            height: 25%;
            margin-right: 5px;
        }
        .container {
            padding: 10%;
            margin:auto;
            background-color:rgb(226, 243, 245);
            border-radius: 7px;
            border-style:ridge;
            border-width: 1px;
            border-color: rgb(1, 130, 153);
        }
        .choices {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 40px;
            border-radius: 7px;
            border-style:ridge;
            border-width: 1px;
            border-color: rgb(1, 130, 153);
        }
        .choices img {
            display: block;
            width: 20%;
            margin-left: 5px;
            float: left;
        }
        .choices a {
            margin-left: 20px;
            text-decoration: none;
            color: rgb(1, 130, 153);
            font-weight: bold;
            font-size: 16px;
        }
        .main {
            display: flex;
            justify-content: space-between;
            padding: 40px;
        }
        .left {
            flex: 1;
            
        }

        .left-box {
            background-color:rgb(226, 243, 245);
            padding: 3px;
            margin-right: 30px;
            border-radius: 7px;
            padding: 7px;
            border: 1px solid #0097bc;
        }

        .left-box-users {
            display: flex;
            background-color:rgb(255, 255, 255);
            padding: 3px;
            border-radius: 7px;
            padding: 7px;
        }

        .left h1 {
            font-size: 48px;
            margin-bottom: 3px;
            margin-top: 1px;
        }
        .left h3 {
            color: rgb(1, 130, 153);
            font-weight: normal;
            margin: 1px;            
        }
        .left h2 {
            color: rgb(1, 130, 153);
            font-size: 30px;
            margin-top: 20px;
        }
        .left .count {
            color: rgb(1, 130, 153);
            font-size: 40px;
            font-weight: bold;
        }
        .left ul {
            list-style: none;
            padding: 0;
        }
        .left ul li {
            margin: 5px 0;
            font-size: 16px;
            font-weight: 500;
        }
        .right {
            flex: 1;
            text-align: center;
        }

        .right h2 {
            margin-top: 1px;
        }
        .box {
            border-left: 5px solid #0097bc;
            padding: 30px;
            border-radius: 10px;
        }

        h3 {
            font-family: 'Segoe UI', sans-serif;
            font-size: 100%;
        }

        .btndw{
            padding: 10px;
            background-color:rgb(158, 197, 219);
            border: 1px solid #0097bc;
            border-radius: 7px;
            font-family: 'Segoe UI', sans-serif;
        }

        .btnde{
            padding: 10px;
            background-color:rgb(0, 0, 0);
            border: 1px solid #0097bc;
            color: white;
            border-radius: 7px;
            font-family: 'Segoe UI', sans-serif;
        }

    </style>
</head>
<body>

    <div  class="choices">
        <img src="cordial logo.png" alt="Cordial Logo">
        <div>
            <a href="dashboard.php">Dashboard</a>
            <a href="upload.php">Upload</a>
            <a href="search.html">Search</a>
            <a href="logout.php">Logout</a>
            <a href="approve.html">EduApprove</a>
        </div>
    </div>

    <div class="main">
        <div class="left">
            <h1 class="fade-up">Greetings, <?php echo htmlspecialchars($username); ?>!</h1>
            <h3 class="fade-up">Care to share some of your knowledge today?</h3>

            <br>
            <div class="left-box fade-up">
                <h2>Recently Active Users:</h2>
                <div class="left-box-users">
                    <ul>
                    <?php foreach ($recentUsers as $user): ?>
                        <li>@<?php echo htmlspecialchars($user); ?></li>
                    <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            
            <br>
            <div class="left-box fade-up">
            <h2>Currently Registered Users:</h2>
                <div class="left-box-users">
                    <div class="count"><?php echo $totalUsers; ?></div>
                </div>
            </div>
            
            <br>
            <div class="left-box fade-up">
            <h2>About CORDIAL</h2>
                    <div class="left-box-users">
                        <img style="margin-top: 25px" src="cordial square.png" alt="Cordial Square">
                        <h3 style="margin-left: 20px;
                                    text-decoration: none;
                                    color: rgb(0, 0, 0);
                                    font-weight: 500;
                                    font-size: 16px;
                                    text-align: right;"
                            >Cordial is an IT company built with students in mind. 
                            For the student notes and resource system named Cordial Notes, launching in 2025, 
                            we focus on creating simple, helpful systems that adds convenience to student's 
                            lives through providing them easier access to resources, and tools that helps them 
                            access useful materials for their education. Just like our name, we keep things 
                            friendly, clear, and made for real student needs. For students, made by students.
                        </h3>

                    </div>
            </div>

        </div>

        <div class="right">
            
            <div class="container fade-up">
                <h2 style="margin-top: 0; color: rgb(1, 130, 153);">Your Uploads</h2>
                    <?php if (count($userUploads) === 0): ?>
                        <p style="color: gray;">Nothing yet here. Share something, friend!</p>
                    <?php else: ?>
                        
                    <?php foreach ($userUploads as $upload): ?>
                    <div style="border: 1px solid #0097bc; background-color: white; border-radius: 8px; padding: 15px; margin: 15px 0; text-align: left;">
                        <h3><?php echo htmlspecialchars($upload['title']); ?></h3>

                        <?php if ($upload['category'] === 'acad'): ?>
                            <?php if (!empty($upload['edu_level'])): ?>
                                <strong>Level:</strong> <?php echo htmlspecialchars($upload['edu_level']); ?><br>
                            <?php endif; ?>

                            <?php if (!empty($upload['subject'])): ?>
                                <strong>Subject:</strong> <?php echo htmlspecialchars($upload['subject']); ?><br>
                            <?php endif; ?>

                            <?php if (!empty($upload['materialType'])): ?>
                                <strong>Type:</strong> <?php echo htmlspecialchars($upload['materialType']); ?><br>
                            <?php endif; ?>
                        <?php elseif ($upload['category'] === 'daily'): ?>
                            <?php if (!empty($upload['field'])): ?>
                                <strong>Field:</strong> <?php echo htmlspecialchars($upload['field']); ?><br>
                            <?php endif; ?>
                        <?php endif; ?>

                        <strong>Description:</strong> <?php echo htmlspecialchars($upload['shortdesc']); ?><br>
                        <strong>Date Uploaded:</strong> <?php echo htmlspecialchars($upload['date']); ?><br>
                        <strong>Likes:</strong> <?php echo htmlspecialchars($upload['likeCount']); ?><br><br>

                        <a href="uploads/<?php echo urlencode($upload['file_name']); ?>" download>
                            <button class="btndw"><strong>Download</strong></button>
                        </a>
                        <a href="deleteMaterials.php?id=<?php echo $upload['materialID']; ?>" onclick="return confirm('Are you sure you want to delete this?');">
                            <button class="btnde"><strong>Delete</strong></button>
                        </a>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

</body>
</html>
