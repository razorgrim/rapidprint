<?php
include('includes/db.php');
include('includes/session.php');
include('includes/header.php');

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "<div class='error-message'>You do not have authorization to access this page.</div>";
    header("Refresh: 3; url=index.php"); // Redirect to the homepage after 3 seconds
    exit();
}

// Generate a 10-digit random membership card number
function generateMembershipCardNumber() {
    return str_pad(mt_rand(1, 9999999999), 10, '0', STR_PAD_LEFT);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role']; // Get the selected role from the form

    // Check if passwords match
    if ($password !== $confirm_password) {
        echo "<div class='error-message'>Passwords do not match. Please try again.</div>";
    } else {
        try {
            // Check if email already exists
            $check_stmt = $conn->prepare("SELECT * FROM User WHERE Email = ?");
            $check_stmt->execute([$email]);
            if ($check_stmt->rowCount() > 0) {
                echo "<div class='error-message'>Email already registered. Please use another email.</div>";
            } else {
                // Hash the password
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Generate a random 10-digit membership card number
                $membership_card_number = generateMembershipCardNumber();

                // Default points for new users
                $points = 0;

                // Insert user data into the database
                $stmt = $conn->prepare("
                    INSERT INTO User (Name, Email, Password, Role, MembershipCardNumber, Points)
                    VALUES (?, ?, ?, ?, ?, ?)
                ");
                $stmt->execute([$name, $email, $hashed_password, $role, $membership_card_number, $points]);

                echo "<div class='success-message'>
                        Registration successful! Your Membership Card Number is: <strong>$membership_card_number</strong>. 
                        <a href='login.php'>Login here</a>
                      </div>";
            }
        } catch (PDOException $e) {
            echo "<div class='error-message'>Error: " . $e->getMessage() . "</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        
        body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                background: 
                    linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), /* Adds a dark overlay */
                    url('assets/images/background.jpg') no-repeat center center; /* Background image */
                background-size: cover; /* Ensures the background image covers the screen */
                
            }


        .register-container {
            width: 100%;
            max-width: 400px;
            margin: 50px auto;
            padding: 30px;
            background-color: rgba(255, 255, 255, 0.9); /* Add slight transparency */
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .register-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .register-container label {
            display: block;
            margin-bottom: 8px;
            color: #555;
        }

        .register-container input[type="text"],
        .register-container input[type="password"],
        .register-container input[type="email"],
        .register-container select {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .register-container input[type="submit"] {
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

        .register-container input[type="submit"]:hover {
            background-color: #5cb85c;
        }

        .register-container a {
            text-decoration: none;
            color: #66CDAA;
            display: block;
            text-align: center;
            margin-top: 20px;
        }

        .register-container a:hover {
            text-decoration: underline;
        }

        .success-message, .error-message {
            text-align: center;
            margin: 10px auto;
            width: 80%;
            padding: 10px;
            border-radius: 4px;
        }

        .success-message {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>

    <div class="register-container">
        <h2>Register</h2>
        <form method="POST">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>

            <label for="role">User Type:</label>
            <select id="role" name="role" required>
                <option value="student">Student</option>
                <option value="staff">Staff</option>
                <option value="admin">Admin</option>
            </select>

            <input type="submit" value="Register">
        </form>
    </div>

</body>
</html>

<?php include('includes/footer.php'); ?>
