<?php
include('includes/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    
    // Insert new record into the selected table
    $table = $_GET['target'];  // Either koperasibranch or printingpackage
    
    $stmt = $conn->prepare("INSERT INTO $table (name, description) VALUES (?, ?)");
    $stmt->execute([$name, $description]);
    
    header("Location: admin_dashboard.php?target=$table");
    exit();
}
?>

<form method="POST">
    <label>Name:</label><br>
    <input type="text" name="name" required><br><br>
    
    <label>Description:</label><br>
    <textarea name="description" required></textarea><br><br>
    
    <button type="submit">Add Record</button>
</form>
