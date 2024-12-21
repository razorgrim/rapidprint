<?php
include('includes/db.php');

if (isset($_GET['id']) && isset($_GET['target'])) {
    $id = $_GET['id'];
    $target = $_GET['target'];

    // Fetch the record to edit
    $stmt = $conn->prepare("SELECT * FROM $target WHERE id = ?");
    $stmt->execute([$id]);
    $record = $stmt->fetch();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $description = $_POST['description'];
        
        // Update the record
        $stmt = $conn->prepare("UPDATE $target SET name = ?, description = ? WHERE id = ?");
        $stmt->execute([$name, $description, $id]);
        
        header("Location: admin_dashboard.php?target=$target");
        exit();
    }
}
?>

<form method="POST">
    <label>Name:</label><br>
    <input type="text" name="name" value="<?php echo $record['name']; ?>" required><br><br>
    
    <label>Description:</label><br>
    <textarea name="description" required><?php echo $record['description']; ?></textarea><br><br>
    
    <button type="submit">Update Record</button>
</form>
