<?php
session_start();
include_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$user_type = $_SESSION['user_type'] ?? 'investor';

function fetchSingleValue($pdo, $sql, $params = []) {
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchColumn();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Dashboard - InvestKosovo</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" />
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
</head>
<body>

<div class="sidebar" id="sidebar">
    <div class="p-4 flex items-center">
        <div class="logo-icon">
            <i class="fas fa-landmark"></i>
        </div>
        <img class="daw" src="kosova1.png" alt="InvestKosovo Logo">
        <div class="logo-text">
            <a href="index.php" style="text-decoration:none;">
                <h1>InvestKosovo</h1>
                <p>Investment Hub</p>
            </a>
        </div>
    </div>
    <nav>
        <a href="dashboardi.php" class="active"><i class="fas fa-tachometer-alt"></i> <span class="nav-text">Dashboard</span></a>
        <a href="profilei.php"><i class="fas fa-user"></i> <span class="nav-text">Profile</span></a>
        <a href="opportunities.php"><i class="fas fa-chart-line"></i> <span class="nav-text">Opportunities</span></a>
        <a href="reports.php"><i class="fas fa-file-alt"></i> <span class="nav-text">Reports</span></a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> <span class="nav-text">Logout</span></a>
    </nav>
</div>

<main class="content" id="mainContent">
    <h1>Welcome to InvestKosovo Dashboard</h1>
        <script>
            console.log(<?= json_encode($user_type) ?>);
        </script>

    <?php if ($user_type === 'admin'): ?>

        <section class="admin-panel">
            <h2>Admin Panel Summary</h2>
            <?php
                $total_users = fetchSingleValue($pdo, "SELECT COUNT(*) FROM users");
                $total_opportunities = fetchSingleValue($pdo, "SELECT COUNT(*) FROM investment_opportunities");
                $total_leads = fetchSingleValue($pdo, "SELECT COUNT(*) FROM leads");
            ?>
            <ul>
                <li><strong>Total Users:</strong> <?= htmlspecialchars($total_users) ?></li>
                <li><strong>Investment Opportunities:</strong> <?= htmlspecialchars($total_opportunities) ?></li>
                <li><strong>Investor Leads:</strong> <?= htmlspecialchars($total_leads) ?></li>
            </ul>

            <h3>Latest 5 Investment Opportunities</h3>
            <?php
                $stmt = $pdo->query("SELECT io.title, s.name AS sector, io.capital_min, io.capital_max, io.risk_level, io.timeline_months 
                                     FROM investment_opportunities io
                                     LEFT JOIN sectors s ON io.sector_id = s.sector_id
                                     ORDER BY io.created_at DESC
                                     LIMIT 5");
                $opportunities = $stmt->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Sector</th>
                        <th>Capital Range</th>
                        <th>Risk Level</th>
                        <th>Timeline (Months)</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($opportunities as $opp): ?>
                    <tr>
                        <td><?= htmlspecialchars($opp['title']) ?></td>
                        <td><?= htmlspecialchars($opp['sector'] ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars(number_format($opp['capital_min'], 2)) ?> - <?= htmlspecialchars(number_format($opp['capital_max'], 2)) ?></td>
                        <td><?= htmlspecialchars(ucfirst($opp['risk_level'])) ?></td>
                        <td><?= htmlspecialchars($opp['timeline_months']) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </section>

    <?php else: // Investor view ?>
        <section class="investor-panel">
            <h2>Your Profile Info</h2>
            <?php
                $stmt = $pdo->prepare("SELECT full_name, email FROM users WHERE user_id = ?");
                $stmt->execute([$user_id]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                $stmt = $pdo->prepare("SELECT * FROM company_profiles WHERE user_id = ?");
                $stmt->execute([$user_id]);
                $company = $stmt->fetch(PDO::FETCH_ASSOC);
            ?>
            <p><strong>Name:</strong> <?= htmlspecialchars($user['full_name']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
            <?php if ($company): ?>
                <p><strong>Company Name:</strong> <?= htmlspecialchars($company['name']) ?></p>
                <p><strong>Company Size:</strong> <?= htmlspecialchars(ucfirst($company['size'])) ?></p>
                <p><strong>Investment Type:</strong> <?= htmlspecialchars($company['investment_type']) ?></p>
                <p><strong>Location:</strong> <?= htmlspecialchars($company['location']) ?></p>
            <?php else: ?>
                <p><em>No company profile found. <a href="company_profilei.php">Add one here</a>.</em></p>
            <?php endif; ?>

            <h3>Recommended Investment Opportunities</h3>
            <?php
                $stmt = $pdo->query("SELECT io.title, s.name AS sector, io.capital_min, io.capital_max, io.risk_level, io.timeline_months 
                                     FROM investment_opportunities io
                                     LEFT JOIN sectors s ON io.sector_id = s.sector_id
                                     ORDER BY io.created_at DESC
                                     LIMIT 5");
                $opportunities = $stmt->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Sector</th>
                        <th>Capital Range</th>
                        <th>Risk Level</th>
                        <th>Timeline (Months)</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($opportunities as $opp): ?>
                    <tr>
                        <td><?= htmlspecialchars($opp['title']) ?></td>
                        <td><?= htmlspecialchars($opp['sector'] ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars(number_format($opp['capital_min'], 2)) ?> - <?= htmlspecialchars(number_format($opp['capital_max'], 2)) ?></td>
                        <td><?= htmlspecialchars(ucfirst($opp['risk_level'])) ?></td>
                        <td><?= htmlspecialchars($opp['timeline_months']) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

            <h3>Latest News & Reports</h3>
            <?php
                $stmt = $pdo->query("SELECT title, published_at, type FROM cms_content ORDER BY published_at DESC LIMIT 5");
                $news = $stmt->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <ul>
                <?php foreach ($news as $item): ?>
                    <li>
                        <strong><?= htmlspecialchars($item['title']) ?></strong> 
                        (<?= htmlspecialchars(ucfirst($item['type'])) ?>) - <?= date('M d, Y', strtotime($item['published_at'])) ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>
    <?php endif; ?>
</main>
</body>
</html>
