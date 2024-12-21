<?php
session_start();
include('includes/db.php');
include('includes/header.php'); // Include the header for styling


// Check if user is logged in and has 'admin' role
if ($_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Get the action to decide what to display
$action = isset($_GET['action']) ? $_GET['action'] : 'view';

echo "<h1>Manage Printing Packages</h1>";

switch ($action) {
    case 'view':
        // Display the list of packages
        $stmt = $conn->prepare("SELECT * FROM printing_packages");
        $stmt->execute();
        $packages = $stmt->fetchAll();

        echo "<table class='table'>
                <tr>
                    <th>Package Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>";

        foreach ($packages as $package) {
            echo "<tr>
                    <td>" . htmlspecialchars($package['name']) . "</td>
                    <td>" . htmlspecialchars($package['description']) . "</td>
                    <td>" . htmlspecialchars($package['price']) . "</td>
                    <td>" . htmlspecialchars($package['status']) . "</td>
                    <td>
                        <a href='?action=edit&id=" . $package['id'] . "'>Edit</a> |
                        <a href='?action=delete&id=" . $package['id'] . "'>Delete</a> |
                        <a href='?action=suspend&id=" . $package['id'] . "'>" . 
                            ($package['status'] == 'active' ? 'Suspend' : 'Reactivate') . 
                        "</a>
                    </td>
                  </tr>";
        }

        echo "</table>";
        break;

    case 'edit':
        // Handle the package edit form
        $package_id = $_GET['id'];
        $stmt = $conn->prepare("SELECT * FROM printing_packages WHERE id = ?");
        $stmt->execute([$package_id]);
        $package = $stmt->fetch();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];

            // Update the package in the database
            $stmt = $conn->prepare("UPDATE printing_packages SET name = ?, description = ?, price = ? WHERE id = ?");
            $stmt->execute([$name, $description, $price, $package_id]);

            echo "Package updated successfully! <a href='?action=view'>Go back to packages</a>";
        }

        // Display the edit form
        echo "<form method='POST'>
                <label for='name'>Package Name:</label><br>
                <input type='text' id='name' name='name' value='" . htmlspecialchars($package['name']) . "' required><br><br>
                
                <label for='description'>Description:</label><br>
                <textarea id='description' name='description' required>" . htmlspecialchars($package['description']) . "</textarea><br><br>
                
                <label for='price'>Price:</label><br>
                <input type='text' id='price' name='price' value='" . htmlspecialchars($package['price']) . "' required><br><br>
                
                <input type='submit' value='Update Package'>
              </form>";
        break;

    case 'delete':
        // Handle package deletion
        $package_id = $_GET['id'];
        $stmt = $conn->prepare("DELETE FROM printing_packages WHERE id = ?");
        $stmt->execute([$package_id]);
        echo "Package deleted successfully! <a href='?action=view'>Go back to packages</a>";
        break;

    case 'suspend':
        // Handle package suspension or reactivation
        $package_id = $_GET['id'];
        $stmt = $conn->prepare("SELECT status FROM printing_packages WHERE id = ?");
        $stmt->execute([$package_id]);
        $package = $stmt->fetch();

        $new_status = ($package['status'] == 'active') ? 'suspended' : 'active';
        $stmt = $conn->prepare("UPDATE printing_packages SET status = ? WHERE id = ?");
        $stmt->execute([$new_status, $package_id]);

        echo "Package status updated to $new_status. <a href='?action=view'>Go back to packages</a>";
        break;
}
?>

<button class='back-btn'><a href='admin_dashboard.php'>Back to Dashboard</a></button>

<?php include('includes/footer.php'); ?>
