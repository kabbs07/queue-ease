<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$database = "queuing_system";

// Ensure output buffering is turned off
if (ob_get_level()) ob_end_clean();

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if it's a cashier login
    $sqlCashier = "SELECT * FROM users WHERE username = ?";
    $stmtCashier = $conn->prepare($sqlCashier);
    $stmtCashier->bind_param("s", $username);
    $stmtCashier->execute();
    $resultCashier = $stmtCashier->get_result();

    // Check if it's an admin login
    $sqlAdmin = "SELECT * FROM users WHERE username = ?";
    $stmtAdmin = $conn->prepare($sqlAdmin);
    $stmtAdmin->bind_param("s", $username);
    $stmtAdmin->execute();
    $resultAdmin = $stmtAdmin->get_result();

    if ($resultCashier->num_rows > 0) {
        $row = $resultCashier->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $row['username'];
            header('Location: cashier.php');
        } else {
            echo "Incorrect password!";
        }
    } elseif ($resultAdmin->num_rows > 0) {
        $row = $resultAdmin->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $row['username'];
            header('Location: admin.php');
        } else {
            echo "Incorrect password!";
        }
    } else {
        echo "Username not found!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
         body {
            display: flex;
            height: 100vh;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow: hidden;
            background-color: #1a1a1a;
        }
        

        .left-column video {
            width: 100%;
            height: 100vh;
            object-fit: cover;
            position: absolute;
            z-index: -1; /* Ensure video is displayed behind content */
        }

        .right-column {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 50px;
            background-color: rgba(34, 34, 34, 0.8); /* Slight transparency to show video */
        }

        .logo {
            width: 200px;
            margin-bottom: 20px;
        }
        .login-form {
            width: 100%;
            max-width: 400px;
            background-color: #333333;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s ease, opacity 0.3s ease;
        }
        .login-form h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #ffffff;
        }
        .login-form input[type="text"],
        .login-form input[type="password"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 20px;
            background-color: #444444;
            color: #ffffff;
            border: none;
            border-bottom: 2px solid #555555;
            border-radius: 0;
            outline: none;
            transition: border-color 0.3s ease;
        }
        .login-form input[type="text"]:focus,
        .login-form input[type="password"]:focus {
            border-color: #3498db;
        }
        .login-form input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #B70404;

            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }
        .login-form input[type="submit"]:hover,
        .login-form input[type="submit"]:focus {
            background-color: #F79327;
            transform: scale(1.05);
        }
        @media screen and (max-width: 768px) {
            .left-column video {
                position: fixed; /* Full background video */
                top: 0;
                left: 0;
                min-width: 100%;
                min-height: 100%;
            }

            .right-column {
                width: 100%;
                padding: 20px;
                background-color: transparent; /* No background color, showing the video */
            }
        }
    </style>
</head>
<body>
<div class="left-column">
    <video autoplay loop muted>
        <source src="stdomvid.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
</div>


    <div class="right-column">
        <img class="logo" src="logo-header.png" alt="Logo">
        <form class="login-form" id="loginForm" action="process_login.php" method="post">
    <input type="text" name="username" id="username" placeholder="Username" required>
    <input type="password" name="password" id="password" placeholder="Password" required>
    <input type="submit" value="Log in">
</form>

    </div>
    <script>
        // Basic front-end validation (Note: Always validate on the server side as well)
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;

            if (username === "" || password === "") {
                alert("Both fields are required.");
                e.preventDefault();
            }
        });
    </script>
</body>
</html>
