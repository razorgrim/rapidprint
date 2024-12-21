<?php
session_start();
include('includes/header.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapid Print</title>
    <!-- Link to external style.css file -->
    <link rel="stylesheet" href="assets/css/style.css">

</head>
<style>
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
    .homepage-info {
        text-align: center;
        color: #fff;
        margin-top: 50px;
        padding: 20px;
        background-color: rgba(0, 0, 0, 0.7);
        border-radius: 10px;
        max-width: 800px;
        margin-left: auto;
        margin-right: auto;
    }

    .container {
        text-align: center;
        color: #fff;
        margin-top: 20px;
    }
    .admin-welcome {
    font-size: 24px;
    text-align: center;
    color: #fff;
    margin-top: 20px;
    }

</style>
<body>
    <div class="homepage-info">
        <?php echo "<div class='admin-welcome'>Welcome to the Admin Profile, " . htmlspecialchars($_SESSION['name']) . "!</div>"; ?>

        <p>Rapid Print is your one-stop solution for all printing needs. Whether you are a student, staff member, or administrator, our platform makes it easy to manage your printing tasks with efficiency and ease. Explore our services today and simplify your workflow!</p>
    </div>
    <div class="container">
            <p><a href="admin_dashboard.php">Go to Admin Dashboard</a></p>
        
    </div>

</body>
</html>
<?php include('includes/footer.php'); ?>