<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="stylee.css">
    <link rel="icon" type="image/png" href="/images/favicon-32x32.png">
    <style>

        body {
            background-color:rgb(32, 65, 70);
        }

        .dashboard {
            display: flex;
            min-height: 100vh;

        }
        .sidebar {
            width: 220px;
            background-color: #e0f7fa;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
            border-radius: 7px;
        }
        .sidebar a {
            display: block;
            padding: 10px;
            margin-bottom: 10px;
            background: rgb(1,130,153);
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .sidebar a:hover {
            background: rgb(0, 100, 120);
        }
        .content {
            flex: 1;
            padding: 40px;
        }
        iframe {
            width: 100%;
            height: 120vh;
            border: none;
            background-color: #e0f7fa;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
            border-radius: 7px;
        }
        
    </style>
</head>
<body>
<div class="dashboard">
    <div class="sidebar">
        <h2>Admin Menu</h2>
        <a href="user_management.php" target="contentFrame"><strong>User Management</strong></a>
        <a href="materials_management.php" target="contentFrame"><strong>Materials Management</strong></a>
        <a href="report.php" target="contentFrame"><strong>Admin Report</strong></a>
        <a href="approval.php" target="contentFrame"><strong>Application Approvals</strong></a>
        <br><br><br><br><br><br><br><br><br><br>
        <a href="index.html"><strong>Logout</strong></a>

    </div>
    <div class="content">
        <iframe name="contentFrame" src="user_management.php"></iframe>
    </div>
</div>
</body>
</html>
