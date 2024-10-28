<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

include 'config.php';

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE id='$user_id'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Account</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background: url('images/background.jpeg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            text-align: center;
            position: relative;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        p {
            font-size: 18px;
            color: #555;
            margin-bottom: 30px;
        }

        a {
            display: inline-block;
            padding: 10px 20px;
            margin: 5px;
            text-decoration: none;
            background-color: #3498db;
            color: white;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        a:hover {
            background-color: #2980b9;
        }

        .logout {
            background-color: #e74c3c;
        }

        .logout:hover {
            background-color: #c0392b;
        }

        /* Back to Main Menu Button */
        .back-menu {
            background-color: #27ae60;
            color: #fff;
            text-decoration: none;
            padding: 12px 25px;
            border-radius: 5px;
            position: absolute;
            bottom: -40px;
            left: 50%;
            transform: translateX(-50%);
            transition: background-color 0.3s ease;
        }

        .back-menu:hover {
            background-color: #229954;
        }
    </style>
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update your account?');
        }

        function confirmDelete() {
            return confirm('Are you sure you want to delete your account? This action cannot be undone.');
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>Welcome, <?php echo htmlspecialchars($user['username']); ?>!</h2>
        <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>

        <a href="update.php" onclick="return confirmUpdate();">Update Account</a>
        <a href="delete.php" class="logout" onclick="return confirmDelete();">Delete Account</a>
        <a href="logout.php" class="logout">Logout</a>

        <!-- Back to Main Menu Button -->
        <a href="user_index.html" class="back-menu">Back to Main Menu</a>
    </div>
</body>
</html>
