<?php
session_start();
include('includes/db.php');
include('includes/header.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Fetch user from the database
    $stmt = $conn->prepare("SELECT * FROM User WHERE Email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    // Verify the password
    if ($user && password_verify($password, $user['Password'])) {
        $_SESSION['user_id'] = $user['UserID'];
        $_SESSION['email'] = $user['Email'];
        $_SESSION['name'] = $user['Name'];
        $_SESSION['role'] = $user['Role'];
        $_SESSION['membership_card'] = $user['MembershipCardNumber'];
        $_SESSION['points'] = $user['Points'];

        // Redirect based on user role
        if ($user['Role'] == 'admin') {
            header('Location: admin_profile.php');
            exit;
        } elseif ($user['Role'] == 'student') {
            header('Location: index.php');
            exit;
        } elseif ($user['Role'] == 'staff') {
            header('Location: index.php');
            exit;
        } else {
            // If no role is matched, redirect to general dashboard
            header('Location: dashboard.php');
            exit;
        }
    } else {
        // Display error message for invalid login
        echo "<div class='error-message'>Invalid email or password.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Link to external style.css file -->
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        /* General styling for the page */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: 
                linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), /* Adds a dark overlay */
                url('assets/images/background.jpg') no-repeat center center; /* Background image */
            background-size: cover; /* Ensures the background image covers the screen */
            height: 100vh; /* Set the height to match the viewport height */
        }


        /* Login container */
        .login-container {
            width: 100%;
            max-width: 400px;
            margin: 50px auto;
            padding: 30px;
            background-color: rgba(255, 255, 255, 0.9); /* Add slight transparency */
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        /* Form elements */
        .login-container label {
            display: block;
            margin-bottom: 8px;
            color: #555;
        }

        .login-container input[type="text"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .login-container input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #66CDAA;
            border: none;
            border-radius: 4px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .login-container input[type="submit"]:hover {
            background-color: #5cbf9a;
        }

        .login-container a {
            display: block;
            text-align: center;
            margin-top: 15px;
            text-decoration: none;
            color: #FF6666;
        }

        .login-container a:hover {
            text-decoration: underline;
        }

        /* Error message */
        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            padding: 10px;
            margin: 15px auto;
            text-align: center;
            border-radius: 4px;
            width: 90%;
            max-width: 400px;
        }
    </style>
</head>
<body>

    <!-- Login Form -->
    <div class="login-container">
        <h2>Login</h2>
        <form method="POST">
            <label for="email">Email:</label>
            <input type="text" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <input type="submit" value="Login">
        </form>
    </div>

</body>
</html>

<?php include('includes/footer.php'); ?>

