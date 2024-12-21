<?php
include('includes/session.php');
include('includes/db.php');

// Check if the user is an admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit();
}

// Handle CRUD actions for koperasibranch and printingpackage
$action = $_GET['action'] ?? '';
$target = $_GET['target'] ?? '';

// Function to fetch data
function fetchAll($conn, $table) {
    $stmt = $conn->prepare("SELECT * FROM $table");
    $stmt->execute();
    return $stmt->fetchAll();
}

// Function to delete data
if ($action == 'delete' && isset($_GET['Branchid'])) {
    $id = $_GET['id'];
    $table = ($target == 'koperasibranch') ? 'koperasibranch' : 'printingpackage';
    $stmt = $conn->prepare("DELETE FROM $table WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: admin_dashboard.php?target=$target");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        /* General styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            background-color:#66CDAA;
            background-size: cover;
        }

        .sidebar {
            width: 200px;
            background-color: #2d3a3f;
            color: white;
            padding: 20px;
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;  /* Center items horizontally */
            justify-content: flex-start; /* Start the content from the top */
        }

        .sidebar h2 {
            color: #66CDAA;
            text-align: center;
            
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
            
        }

        .sidebar ul li {
            margin: 15px 0;
        }

        .sidebar ul li a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px;
            border-radius: 4px;
        }

        .sidebar ul li a:hover {
            background-color: #66CDAA;
        }

        .main-content {
            flex: 1;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        table th {
            background-color: #2d3a3f;
            color: white;
        }

        a.btn {
            text-decoration: none;
            color: white;
            background-color: #66CDAA;
            padding: 5px 10px;
            border-radius: 4px;
            display: inline-block;
        }

        a.btn-danger {
            background-color: #e55c5c;
        }

        a.btn:hover {
            opacity: 0.8;
        }

        form input, form button {
            padding: 8px;
            margin: 5px 0;
        }

        .logo {
            width: 50px;  /* Adjust size here */
            height: auto; /* Maintain aspect ratio */
            margin-bottom: 5px; /* Add some space below the logo */
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Make the logo clickable and redirect to UMPSA website -->
        <a href="https://www.umpsa.edu.my" target="_blank">
            <img src="assets/images/umpsa.png" alt="RapidPrint Logo" class="logo"> <!-- Replace with actual logo path -->
        </a>
        <h2>Admin Panel</h2>
        <ul>
            <li><a href="admin_dashboard.php?target=koperasibranch">Manage Koperasi Branch</a></li>
            <li><a href="admin_dashboard.php?target=printingpackage">Manage Printing Package</a></li>
            <li><a href="register.php">Register New User</a></li> 
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <h1>Admin Dashboard</h1>

        <?php if ($target == 'koperasibranch' || $target == 'printingpackage'): ?>
            <h2>Manage  <?php echo ucfirst($target); ?></h2>
            <a href="add_record.php?target=<?php echo $target; ?>" class="btn">Add New Record</a>
            
            <?php
            // Fetch and display records
            $data = fetchAll($conn, $target);
            ?>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Branch</th>
                        <th>Address</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $row): ?>
                        <tr>
                            <td><?php echo $row['BranchID']; ?></td>
                            <td><?php echo $row['BranchName']; ?></td>
                            <td><?php echo $row['Address']; ?></td>
                            <td>
                                <a href="edit_record.php?id=<?php echo $row['BranchID']; ?>&target=<?php echo $target; ?>" class="btn">Edit</a>
                                <a href="admin_dashboard.php?action=delete&id=<?php echo $row['BranchID']; ?>&target=<?php echo $target; ?>" class="btn btn-danger" onclick="return confirm('Are you sure?');">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Welcome to the Admin Dashboard. Use the menu to manage records.</p>
        <?php endif; ?>
    </div>
</body>
</html>

