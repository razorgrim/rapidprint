<?php
// Get the current page name
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Link to external style.css file -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <!-- Header Menu -->
    <header>
        <!-- Logo and Title (on the left side) -->
        <div style="display: flex; align-items: center;">
            <!-- Make the logo clickable and redirect to UMPSA website -->
            <a href="https://www.umpsa.edu.my" target="_blank">
                <img src="assets/images/umpsa.png" alt="RapidPrint Logo" class="logo" > <!-- Replace with actual logo path -->
            </a>
            <h1>RapidPrint</h1>
        </div>
        
        <!-- Right side menu with Login/Register or Logout based on session -->
        <div class="menu">
            <a href="index.php">Home</a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <!-- If logged in, show Logout and Hide Register/Login links -->
                <?php if (in_array($current_page, ['student_profile.php', 'staff_dashboard.php'])): ?>
                    <!-- If on any dashboard page, show only Logout -->
                    <a href="logout.php">Logout</a>
                <?php elseif (in_array($current_page, ['register.php'])): ?>
                    <a href="admin_dashboard.php">Dashboard</a>
                <?php elseif ($current_page != 'login.php' && $current_page != 'register.php'): ?>
                    <!-- If not on login/register page, show Logout -->
                    <a href="logout.php">Logout</a>
                <?php endif; ?>
            
            <?php endif; ?>
        </div>
    </header>
    
</body>
</html>
