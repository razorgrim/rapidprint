<?php
include('includes/session.php');
include('includes/db.php');

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'staff') {
    header('Location: login.php');
    exit();
}
?>

<br><br>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard</title>
    <style>
       body {
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            height: 100vh;
            background-color: #f8f9fa;
            overflow: hidden;
        }
        /* Sidebar */
        .sidebar {
            width: 250px;
            background-color: #333;
            color: #fff;
            padding: 20px;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
        }
        .sidebar.minimized {
            width: 60px;
            padding: 10px;
            overflow: hidden;
        }
        .sidebar h2 {
            text-align: center;
            font-size: 20px;
            margin-bottom: 30px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            transition: all 0.3s ease;
        }
        .sidebar.minimized h2 {
            font-size: 0;
            margin-bottom: 10px;
        }
        .sidebar button {
            background: transparent;
            border: 1px solid #fff;
            color: #fff;
            padding: 10px;
            margin: 5px 0;
            text-align: left;
            cursor: pointer;
            transition: all 0.3s ease;
            white-space: nowrap;
        }
        .sidebar.minimized button {
            text-align: center;
            padding: 10px;
            font-size: 0;
        }
        .sidebar button::before {
            content: '\2630'; /* Hamburger icon */
            font-size: 16px;
            display: inline-block;
            margin-right: 10px;
            transition: all 0.3s ease;
        }
        .sidebar.minimized button::before {
            margin-right: 0;
            font-size: 16px;
        }
        /* Toggle Button */
        .toggle-btn {
            position: absolute;
            top: 10px;
            left: 250px;
            background: #28a745;
            color: #fff;
            border: none;
            padding: 10px;
            cursor: pointer;
            transition: left 0.3s ease;
            z-index: 100;
        }
        .sidebar.minimized + .toggle-btn {
            left: 60px;
        }
        /* Main Content */
        .main-content {
            flex: 1;
            padding: 20px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #28a745;
            color: #fff;
            padding: 15px;
            border-radius: 5px;
        }
        .header button {
            background-color: #fff;
            color: #28a745;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s;
        }
        .header button:hover {
            background-color: #e8e8e8;
        }
        .section-title {
            margin: 20px 0;
            font-size: 18px;
            font-weight: bold;
        }
        .order-section {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .order-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid #ddd;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .order-row span {
            flex: 1;
            text-align: center;
        }
        .order-row button {
            background-color: #28a745;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .order-row button:hover {
            background-color: #218838;
        }
        .footer {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            align-items: center;
        }
        .footer button {
            background-color: #28a745;
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        .footer button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <h2>Staff Panel</h2>
        <button>Manage Order Status and Invoice</button>
        <button>Scan QR</button>
        <button>Bonus Overview</button>
    </div>

    <!-- Toggle Button -->
    <button class="toggle-btn" id="toggleBtn">☰</button>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="header">
            <div><strong>STAFF DASHBOARD</strong></div>
            <button id="loginBtn" onclick="logout()">Logout</button>
        </div>

        <!-- Order Section -->
        <div class="section-title">Manage Order Status and Invoice</div>
        <div class="order-section">
            <div class="order-row">
                <span>Order Information</span>
                <button>Edit</button>
                <button>Update</button>
            </div>
            <div class="order-row">
                <span>Order Information</span>
                <button>Edit</button>
                <button>Update</button>
            </div>
            <div class="order-row">
                <span>Order Information</span>
                <button>Edit</button>
                <button>Update</button>
            </div>
            <!-- Footer -->
            <div class="footer">
                <span><strong>Total Bonus</strong></span>
                <button>Generate Invoice</button>
            </div>
        </div>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('toggleBtn');
        const loginBtn = document.getElementById('loginBtn');

        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('minimized');
            if (sidebar.classList.contains('minimized')) {
                toggleBtn.textContent = '☰';
            } else {
                toggleBtn.textContent = '✖';
            }
        });

        // Logout function
        function logout() {
            // Clear any session data if needed (e.g., localStorage, sessionStorage)
            // For example: localStorage.removeItem('userSession'); or sessionStorage.clear();
            
            // Redirect to the logout page or reload the page
            window.location.href = 'logout.php'; // Redirect to login page (modify the URL as needed)
            
            // Optionally, you can change the button back to "Login" if you want
            loginBtn.textContent = "Login";
        }
    </script>
</body>
</html>
