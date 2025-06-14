<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CORDIAL: Admin Login</title>
    <link rel="icon" type="image/png" href="/images/favicon-32x32.png">
    <style>
        img {
            display: block;
            width: 20%;
            margin: auto;
        }

        .container {
            width: 40%;
            padding: 3%;
            margin: auto;
            background-color: #ffffff;
            border-radius: 7px;
            border-style: ridge;
            border-width: 1px;
            border-color: rgb(1, 130, 153);
        }

        h3 {
            font-family: system-ui, sans-serif;
            text-align: center;
            color: rgb(1, 130, 153);
            font-size: 170%;
            margin: 0;
        }

        label {
            text-align: center;
            font-size: 80%;
            font-family: system-ui, sans-serif;
            font-weight: 620;
            margin-left: 10px;
        }

        .tyun {
            display: block;
            width: 91%;
            padding: 12px;
            border: 1px solid rgb(1, 130, 153);
            border-radius: 5px;
            margin: auto;
        }

        .tyunning {
            font-family: system-ui, sans-serif;
            display: block;
            width: 100%;
            padding: 12px;
            border: 1px solid #018299;
            border-radius: 5px;
            background-color: #c9e0ff;
            margin: auto;
        }
    </style>
</head>
<body>
    <br><br>
    <img src="cordial logo.png" alt="logo">
    <br><br>

    <div class="container">
        <h3>ADMIN LOGIN</h3>
        <form action="adminLog.php" method="POST">
            <label for="username">ADMIN ID:</label><br>
            <input type="text" id="username" name="username" class="tyun" required><br>
            <label for="password">PASSWORD:</label><br>
            <input type="password" id="password" name="password" class="tyun" required><br><br>
            <input type="submit" value="LOGIN" class="tyunning">
        </form>
    </div>

    <?php if (isset($_GET['error'])): ?>
        <script>
            alert("Invalid ID or Password");
            if (history.replaceState) {
                history.replaceState(null, null, window.location.pathname);
            }
        </script>
    <?php endif; ?>
</body>
</html>
