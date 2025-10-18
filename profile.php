<?php
session_start();
include_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch user data
$stmt = $pdo->prepare("SELECT full_name, email, user_type, created_at, last_login FROM users WHERE user_id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "User not found.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Profile - InvestKosovo</title>
    <style>
        /* Reset and base */
        * {
            box-sizing: border-box;
        }
        body, html {
            margin: 0; padding: 0; height: 100%;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #fefefe;
            color: #222;
        }

        /* Sidebar styles */
        .sidebar {
            background-color: #1e40af; /* blue-800 */
            color: white;
            width: 260px;
            height: 100vh;
            position: fixed;
            top: 0; left: 0;
            display: flex;
            flex-direction: column;
            box-shadow: 2px 0 8px rgba(0,0,0,0.1);
            transition: width 0.3s ease;
            overflow: hidden;
            z-index: 1000;
        }
        .sidebar.collapsed {
            width: 80px;
        }

        .sidebar .p-4 {
            padding: 1rem;
            display: flex;
            align-items: center;
            border-bottom: 1px solid #3b82f6; /* lighter blue */
        }
        .sidebar .logo-text h1 {
            font-size: 1.4rem;
            font-weight: 700;
            margin: 0;
            line-height: 1;
            color:rgb(255, 255, 255); /* blue-200 */
        }
        .sidebar .logo-text p {
            margin: 0;
            font-size: 0.75rem;
            color: #bfdbfe; /* blue-200 */
            font-weight: 500;
        }
        .logo-icon {
            margin-right: 0.75rem;
            font-size: 2rem;
            display: none; /* hidden per your snippet */
        }

        #toggleSidebar {
            background: transparent;
            border: none;
            cursor: pointer;
            font-size: 1.25rem;
            color: white;
        }

        nav {
            margin-top: 1.5rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        nav a {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: white;
            text-decoration: none;
            font-weight: 600;
            transition: background-color 0.2s ease;
        }
        nav a:hover, nav a.active {
            background-color: #2563eb; /* blue-700 */
        }
        nav i {
            margin-right: 0.75rem;
            width: 20px;
            text-align: center;
        }
        .nav-text {
            white-space: nowrap;
        }

        /* Main content */
        main.content {
            margin-left: 260px;
            padding: 2rem 3rem;
            min-height: 100vh;
            background: white;
            transition: margin-left 0.3s ease;
        }
        main.content.collapsed {
            margin-left: 80px;
        }

        h1 {
            color: #1e40af; /* blue-800 */
            margin-bottom: 1.5rem;
            font-weight: 700;
        }
        h2 {
            color: #2563eb; /* blue-700 */
            margin-top: 2rem;
            margin-bottom: 1rem;
        }
        ul {
            list-style-type: none;
            padding-left: 0;
        }
        ul li {
            padding: 0.3rem 0;
            font-size: 1rem;
            color: #374151; /* cool dark gray */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
            box-shadow: 0 0 10px rgb(59 130 246 / 0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        th, td {
            padding: 0.75rem 1rem;
            text-align: left;
        }
        th {
            background-color: #e0e7ff; /* light blue background */
            color: #1e40af; /* dark blue */
            font-weight: 700;
        }
        tr:nth-child(even) td {
            background-color: #f9fafb;
        }

        /* Responsive for smaller screens */
        @media (max-width: 768px) {
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
                flex-direction: row;
                padding: 0.5rem 1rem;
            }
            nav {
                flex-direction: row;
                margin-top: 0;
                overflow-x: auto;
            }
            nav a {
                padding: 0.5rem 1rem;
                font-size: 0.9rem;
            }
            main.content {
                margin-left: 0;
                padding: 1rem;
            }
        }
        
        .daw{height:3rem; width:auto;}
    </style>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" />
</head>
<body>
    
<div class="sidebar" id="sidebar">
    <div class="p-4 flex items-center">
        <div class="logo-icon">
            <i class="fas fa-landmark"></i>
        </div>
        <img class="daw" src="kosova1.png" alt="InvestKosovo Logo">
        <div class="logo-text">
            <h1 >InvestKosovo</h1>
            <p>Investment Hub</p>
        </div>
    </div>
    <nav>
        <a href="dashboardi.php"><i class="fas fa-tachometer-alt"></i> <span class="nav-text">Dashboard</span></a>
        <a href="profilei.php" class="active"><i class="fas fa-user"></i> <span class="nav-text">Profile</span></a>
        <a href="opportunities.php"><i class="fas fa-chart-line"></i> <span class="nav-text">Opportunities</span></a>
        <a href="reports.php"><i class="fas fa-file-alt"></i> <span class="nav-text">Reports</span></a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> <span class="nav-text">Logout</span></a>
    </nav>
</div>
<main class="content" id="mainContent">
    <h1>Your Profile</h1>
    <table>
        <tr>
            <th>Full Name</th>
            <td><?= htmlspecialchars($user['full_name']) ?></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><?= htmlspecialchars($user['email']) ?></td>
        </tr>
        <tr>
            <th>User Role</th>
            <td><?= ucfirst($user['user_type']) ?></td>
        </tr>
        <tr>
            <th>Member Since</th>
            <td><?= date('F j, Y', strtotime($user['created_at'])) ?></td>
        </tr>
        <tr>
            <th>Last Login</th>
            <td><?= date('F j, Y \a\t H:i', strtotime($user['last_login'])) ?></td>
        </tr>
    </table>
    </main>
</body>
</html>
