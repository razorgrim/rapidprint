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

echo "<h1>Manage Branches</h1>";

switch ($action) {
    case 'view':
        // Display the list of branches
        $stmt = $conn->prepare("SELECT * FROM branches");
        $stmt->execute();
        $branches = $stmt->fetchAll();

        echo "<table class='table'>
                <tr>
                    <th>Branch Name</th>
                    <th>Address</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>";

        foreach ($branches as $branch) {
            echo "<tr>
                    <td>" . htmlspecialchars($branch['branch_name']) . "</td>
                    <td>" . htmlspecialchars($branch['address']) . "</td>
                    <td>" . htmlspecialchars($branch['status']) . "</td>
                    <td>
                        <a href='?action=edit&id=" . $branch['id'] . "'>Edit</a> |
                        <a href='?action=delete&id=" . $branch['id'] . "'>Delete</a>
                    </td>
                  </tr>";
        }

        echo "</table>";
        break;

    case 'edit':
        // Handle the branch edit form
        $branch_id = $_GET['id'];
        $stmt = $conn->prepare("SELECT * FROM branches WHERE id = ?");
        $stmt->execute([$branch_id]);
        $branch = $stmt->fetch();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $branch_name = $_POST['branch_name'];
            $address = $_POST['address'];
            $status = $_POST['status'];

            // Update the branch in the database
            $stmt = $conn->prepare("UPDATE branches SET branch_name = ?, address = ?, status = ? WHERE id = ?");
            $stmt->execute([$branch_name, $address, $status, $branch_id]);

            echo "Branch updated successfully! <a href='?action=view'>Go back to branches</a>";
        }

        // Display the edit form
        echo "<form method='POST'>
                <label for='branch_name'>Branch Name:</label><br>
                <input type='text' id='branch_name' name='branch_name' value='" . htmlspecialchars($branch['branch_name']) . "' required><br><br>
                
                <label for='address'>Address:</label><br>
                <input type='text' id='address' name='address' value='" . htmlspecialchars($branch['address']) . "' required><br><br>
                
                <label for='status'>Status:</label><br>
                <select id='status' name='status'>
                    <option value='active'" . ($branch['status'] == 'active' ? ' selected' : '') . ">Active</option>
                    <option value='inactive'" . ($branch['status'] == 'inactive' ? ' selected' : '') . ">Inactive</option>
                </select><br><br>
                
                <input type='submit' value='Update Branch'>
              </form>";
        break;

    case 'delete':
        // Handle branch deletion
        $branch_id = $_GET['id'];
        $stmt = $conn->prepare("DELETE FROM branches WHERE id = ?");
        $stmt->execute([$branch_id]);
        echo "Branch deleted successfully! <a href='?action=view'>Go back to branches</a>";
        break;
}
?>

<button class='back-btn'><a href='admin_dashboard.php'>Back to Dashboard</a></button>

<?php include('includes/footer.php'); ?>
