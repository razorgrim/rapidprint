<?php
session_start();
include('includes/header.php');

if ($_SESSION['role'] !== 'student') {
    header('Location: login.php');
    exit();
}

echo "Welcome to the Student Profile, " . $_SESSION['name'];
?>

<br><br>
<a href="logout.php">Logout</a>
<?php include('includes/footer.php'); ?>