<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] === 'normaluser') {
    echo "<script>alert('Access denied. You need educator/student approval.'); window.location.href = 'approve.html';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CORDIAL: Upload Material</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/images/favicon-32x32.png">
    <link rel="stylesheet" href="stylee.css">

    
</head>
<body>

    <div class="nav">
        <img src="cordial logo.png" alt="logo">
        <div>
            <a href="dashboard.php">Dashboard</a>
            <a href="upload.php">Upload</a>
            <a href="search.html">Search</a>
            <a href="logout.php">Logout</a>
            <a href="approve.html">EduApprove</a>

        </div>
    </div>

    <br><br>
    <div class="uplcontainer">
        <h3>Upload it now!</h3>
        <form name="Material Info" action="addAcadMaterials.php" method="POST" enctype="multipart/form-data">
            <label for="title">Title</label>
            <input type="text" id="title" name="title">

            <div class="form-row">
                <div>
                    <label for="edu_level">Education Level</label>
                    <select id="edu_level" name="edu_level">
                        <option value="">Select level</option>
                        <option value="Elementary">Elementary</option>
                        <option value="Primary School">Primary School</option>
                        <option value="Secondary School">Secondary School</option>
                        <option value="Pre-University">Pre-University/Foundations/Diploma</option>
                        <option value="Degree">Bachelor's Degree</option>
                        <option value="Masters">Masters</option>
                    </select>
                </div>
                <div>
                    <label for="subject">Subject</label>
                    <input type="text" id="subject" name="subject">
                </div>
                <div>
                    <label for="materialType">Material Type</label>
                    <select id="materialType" name="materialType">
                        <option value="">Select Type</option>
                        <option value="Quiz">Quiz</option>
                        <option value="Assignment">Assignment</option>
                        <option value="Lecture Notes">Lecture Notes</option>
                        <option value="Handwritten Notes">Handwritten Notes</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div>
                    <label for="shortdesc">Short Description</label>
                    <input type="text" id="shortdesc" name="shortdesc">
                </div>
            </div>

            <label for="file_name">Import file</label>
            <input type="file" id="file_name" name="file_name">

            <input type="submit" value="Upload" class="upload-btn">
            <br>
            <input type="hidden" id="category" name="category">
            <br><br><br>
        </form>
    </div>
    <script>
        const urlParams = new URLSearchParams(window.location.search);
        const category = urlParams.get('category');
        if (materialType) {
            document.getElementById('category').value = category;
        }
    </script>

</body>
</html>
