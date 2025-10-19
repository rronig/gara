<?php
session_start();
include_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
$user_id = $_SESSION['user_id'];
$user_type = $_SESSION['user_type'];
$total_invested=$_SESSION['total_invested'];
if($total_invested==0):$total_value=0;else:$total_value=$_SESSION['total_value'];endif;
if($total_invested==0){$money_made=0;} else{
    $money_made=$total_value/$total_invested *100 -100;
}
// Fetch user info from DB (fetch all columns)
$stmt = $pdo->prepare("SELECT * FROM users WHERE user_id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
// Helper for profile picture
$profilePic = !empty($user['profile_picture']) ? htmlspecialchars($user['profile_picture']) : 'https://randomuser.me/api/portraits/men/32.jpg';

function fetchSingleValue($pdo, $sql, $params = []) {
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchColumn();
}
?>
<script>console.log('<?php echo $user_type ?>')</script>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - InvestKosovo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .sidebar {
            transition: all 0.3s ease;
        }
        .sidebar.collapsed {
            width: 70px;
        }
        .sidebar.collapsed .nav-text {
            display: none;
        }
        .sidebar.collapsed .logo-text {
            display: none;
        }
        .sidebar.collapsed .logo-icon {
            display: block;
        }
        .sidebar:not(.collapsed) .logo-icon {
            display: none;
        }
        .main-content {
            transition: margin-left 0.3s ease;
        }
        .risk-low {
            background-color: #10B981;
        }
        .risk-medium {
            background-color: #F59E0B;
        }
        .risk-high {
            background-color: #EF4444;
        }
        .chart-container {
            height: 300px;
        }
        @media (max-width: 768px) {
            .sidebar {
                position: absolute;
                z-index: 100;
                left: -250px;
            }
            .sidebar.active {
                left: 0;
            }
            .main-content {
                margin-left: 0 !important;
            }
        }
        .fafaroni{background-color: #2563eb; /* blue-700 */}
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div class="sidebar bg-blue-800 text-white w-64 fixed h-full">
            <div class="p-4 flex items-center">
                <div class="logo-icon hidden">
                    <i class="fas fa-landmark text-2xl"></i>
                </div>
                <img class="h-16 w-auto" src="kosova1.png" alt="InvestKosovo Logo">
                <div class="logo-text">
                    <h1 class="text-xl font-bold">InvestKosovo</h1>
                    <p class="text-xs text-blue-200">Investment Hub</p>
                </div>
            </div>
            <nav class="mt-6">
                <div class="px-4 py-2 fafaroni">
                    <a href="dashboardi.php" class="flex items-center text-white">
                        <i class="fas fa-tachometer-alt mr-3"></i>
                        <span class="nav-text">Dashboard</span>
                    </a>
                </div>
                <div class="px-4 py-2 hover:bg-blue-700">
                    <a href="profilei.php" class="flex items-center text-white">
                        <i class="fas fa-user mr-3"></i>
                        <span class="nav-text">Profile</span>
                    </a>
                </div>
                <div class="px-4 py-2 hover:bg-blue-700">
                    <a href="opportunity.php" class="flex items-center text-white">
                        <i class="fas fa-chart-line mr-3"></i>
                        <span class="nav-text">Opportunities</span>
                    </a>
                </div>
                <div class="px-4 py-2 hover:bg-blue-700">
                    <a href="reports.php" class="flex items-center text-white">
                        <i class="fas fa-file-alt mr-3"></i>
                        <span class="nav-text">Reports</span>
                    </a>
                </div>
                <div class="px-4 py-2 hover:bg-blue-700">
                    <a href="logout.php" class="flex items-center text-white">
                        <i class="fas fa-sign-out-alt mr-3"></i>
                        <span class="nav-text">Logout</span>
                    </a>
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="main-content flex-1 ml-64 overflow-auto">
            <!-- Top Navigation -->
            <header class="bg-white shadow-sm">
                <div class="flex justify-between items-center p-4">
                    <div class="flex items-center">
                        <button id="mobileMenuButton" class="md:hidden text-gray-600 focus:outline-none">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        <h1 class="text-xl font-semibold text-gray-800 ml-4">Dashboard</h1>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <button class="text-gray-600 focus:outline-none">
                                <i class="fas fa-bell text-xl"></i>
                                <span class="absolute top-0 right-0 h-2 w-2 rounded-full bg-red-500"></span>
                            </button>
                        </div>
                        <div class="flex items-center">
                            <img src="<?php echo $profilePic; ?>" alt="User" class="h-8 w-8 rounded-full">
                            <span class="ml-2 text-gray-700"><?= htmlspecialchars($user['full_name'] ?? 'User') ?></span>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Dashboard Content -->
            <main class="p-6">
                <!-- Welcome Banner -->
                <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-lg p-6 text-white mb-6">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                        <div>
                            <h2 class="text-2xl font-bold mb-2">Welcome back, <?= htmlspecialchars(explode(' ', $user['full_name'] ?? 'User')[0]) ?>!</h2>
                            <p class="mb-4">Here's what's happening with your investments today.</p>
                            <a href="opportunity.php" class="bg-white text-blue-600 px-4 py-2 rounded-md font-medium hover:bg-blue-50 transition">
                                View Portfolio
                            </a>
                        </div>
                        <div class="mt-4 md:mt-0">
                            <div class="bg-white bg-opacity-20 p-4 rounded-lg">
                                <p class="text-sm">Total Investment Value</p>
                                <p class="text-2xl font-bold"><?php  echo $total_value ?></p>
                                <p class="text-sm mt-1"><?php echo abs($money_made); if( $money_made<0){?>% lost<?php } else { ?>% won<?php } ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if ($user_type === 'admin'): ?>
                    <!-- Admin Dashboard -->
                    <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
                        <div class="p-6 border-b">
                            <h2 class="text-lg font-semibold text-gray-800">Admin Panel Summary</h2>
                        </div>
                        <div class="p-6">
                            <?php
                                $total_users = fetchSingleValue($pdo, "SELECT COUNT(*) FROM users");
                                $total_opportunities = fetchSingleValue($pdo, "SELECT COUNT(*) FROM investment_opportunities");
                                $total_leads = fetchSingleValue($pdo, "SELECT COUNT(*) FROM leads");
                            ?>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                                <div class="bg-white rounded-lg shadow p-6">
                                    <div class="flex items-center">
                                        <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                                            <i class="fas fa-users"></i>
                                        </div>
                                        <div>
                                            <p class="text-gray-500 text-sm">Total Users</p>
                                            <p class="text-2xl font-bold"><?= htmlspecialchars($total_users) ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-white rounded-lg shadow p-6">
                                    <div class="flex items-center">
                                        <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                                            <i class="fas fa-chart-line"></i>
                                        </div>
                                        <div>
                                            <p class="text-gray-500 text-sm">Investment Opportunities</p>
                                            <p class="text-2xl font-bold"><?= htmlspecialchars($total_opportunities) ?></p>
                                            <a href="create-opportunity.php" class="text-blue-600 hover:underline text-sm mt-1 inline-block">Create New Opportunity</a>
                                            <a href="create-sector.php" class="text-blue-600 hover:underline text-sm mt-1 inline-block ml-4">Create New Sector</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-white rounded-lg shadow p-6">
                                    <div class="flex items-center">
                                        <div class="p-3 rounded-full bg-purple-100 text-purple-600 mr-4">
                                            <i class="fas fa-handshake"></i>
                                        </div>
                                        <div>
                                            <p class="text-gray-500 text-sm">Investor Leads</p>
                                            <p class="text-2xl font-bold"><?= htmlspecialchars($total_leads) ?></p>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>

                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Latest Investment Opportunities</h3>
                            <?php
                                $stmt = $pdo->query("SELECT io.title, s.name AS sector, io.capital_min, io.capital_max, io.risk_level, io.timeline_months 
                                                    FROM investment_opportunities io
                                                    LEFT JOIN sectors s ON io.sector_id = s.sector_id
                                                    ORDER BY io.created_at DESC
                                                    LIMIT 5");
                                $opportunities = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            ?>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sector</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Capital Range</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Risk</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Timeline</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <?php foreach ($opportunities as $opp): ?>
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($opp['title']) ?></td>
                                                <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($opp['sector'] ?? 'N/A') ?></td>
                                                <td class="px-6 py-4 whitespace-nowrap">€<?= htmlspecialchars(number_format($opp['capital_min'], 2)) ?> - €<?= htmlspecialchars(number_format($opp['capital_max'], 2)) ?></td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="px-2 py-1 text-xs rounded-full risk-<?= strtolower($opp['risk_level']) ?>"><?= htmlspecialchars(ucfirst($opp['risk_level'])) ?></span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($opp['timeline_months']) ?> months</td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php elseif (strtolower(trim($user['country'] ?? 'Kosovo')) !== 'kosovo'): ?>
                    <!-- Diaspora Dashboard -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                        <!-- Diaspora Welcome -->
                        <div class="bg-gradient-to-r from-purple-600 to-blue-800 rounded-lg p-6 text-white mb-6 col-span-3">
                            <h2 class="text-2xl font-bold mb-2">Welcome Diaspora Investor, <?= htmlspecialchars(explode(' ', $user['full_name'] ?? 'User')[0]) ?>!</h2>
                            <p class="mb-4">As a member of the Albanian diaspora, you have unique opportunities to connect with and invest in Kosovo's growth. Explore tailored opportunities and resources below.</p>
                            <a href="index.php#opportunities" class="bg-white text-purple-700 px-4 py-2 rounded-md font-medium hover:bg-purple-50 transition">Explore Kosovo Opportunities</a>
                        </div>
                        <!-- Diaspora Quick Actions -->
                        <div class="bg-white rounded-lg shadow p-6">
                            <h2 class="text-lg font-semibold text-gray-800 mb-4">Diaspora Quick Actions</h2>
                            <div class="space-y-3">
                                <a href="invest.php" class="w-full flex items-center p-3 bg-purple-50 text-purple-700 rounded-md hover:bg-purple-100 transition">
                                    <i class="fas fa-globe-europe mr-3"></i>
                                    <span>Invest in Kosovo</span>
                                </a>
                                <a href="reports.php" class="w-full flex items-center p-3 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 transition">
                                    <i class="fas fa-file-export mr-3"></i>
                                    <span>View Diaspora Reports</span>
                                </a>
                                <a href="success-stories.php" class="w-full flex items-center p-3 bg-green-50 text-green-700 rounded-md hover:bg-green-100 transition">
                                    <i class="fas fa-star mr-3"></i>
                                    <span>Success Stories</span>
                                </a>
                                <a href="index.php#support" class="w-full flex items-center p-3 bg-yellow-50 text-yellow-700 rounded-md hover:bg-yellow-100 transition">
                                    <i class="fas fa-hands-helping mr-3"></i>
                                    <span>Diaspora Support</span>
                                </a>
                            </div>
                        </div>
                        <!-- Diaspora Investment Chart -->
                        <div class="bg-white rounded-lg shadow p-6 col-span-2">
                            <div class="flex justify-between items-center mb-4">
                                <h2 class="text-lg font-semibold text-gray-800">Diaspora Investment Performance</h2>
                                <div class="flex space-x-2">
                                    <button class="px-3 py-1 text-sm bg-purple-100 text-purple-700 rounded-md">1M</button>
                                    <button class="px-3 py-1 text-sm bg-purple-700 text-white rounded-md">6M</button>
                                    <button class="px-3 py-1 text-sm bg-purple-100 text-purple-700 rounded-md">1Y</button>
                                </div>
                            </div>
                            <div class="chart-container">
                                <canvas id="investmentChart"></canvas>
                            </div>
                        </div>
                    </div>
                    <!-- Diaspora Opportunities (moved below) -->
                    <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
                        <div class="p-6 border-b">
                            <h2 class="text-lg font-semibold text-gray-800">Opportunities for Diaspora</h2>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sector</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Capital Range</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Risk</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Timeline</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <?php
                                        $stmt = $pdo->query("SELECT io.title, s.name AS sector, io.capital_min, io.capital_max, io.risk_level, io.timeline_months 
                                                            FROM investment_opportunities io
                                                            LEFT JOIN sectors s ON io.sector_id = s.sector_id
                                                            ORDER BY io.created_at DESC
                                                            LIMIT 5");
                                        $opportunities = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    ?>
                                    <?php foreach ($opportunities as $opp): ?>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($opp['title']) ?></td>
                                            <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($opp['sector'] ?? 'N/A') ?></td>
                                            <td class="px-6 py-4 whitespace-nowrap">€<?= htmlspecialchars(number_format($opp['capital_min'], 2)) ?> - €<?= htmlspecialchars(number_format($opp['capital_max'], 2)) ?></td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 py-1 text-xs rounded-full risk-<?= strtolower($opp['risk_level']) ?>"><?= htmlspecialchars(ucfirst($opp['risk_level'])) ?></span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($opp['timeline_months']) ?> months</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="p-4 border-t text-center">
                            <a href="opportunity.php" class="text-purple-700 hover:text-purple-900 font-medium">View All Diaspora Opportunities</a>
                        </div>
                    </div>
                    <!-- Diaspora News -->
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <div class="p-6 border-b">
                            <h2 class="text-lg font-semibold text-gray-800">Diaspora News & Resources</h2>
                        </div>
                        <div class="divide-y divide-gray-200">
                            <?php
                                $stmt = $pdo->query("SELECT title, published_at, type FROM cms_content ORDER BY published_at DESC LIMIT 5");
                                $news = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            ?>
                            <?php foreach ($news as $item): ?>
                                <div class="p-4 hover:bg-gray-50 transition">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 h-10 w-10 rounded-full 
                                            <?php 
                                                switch($item['type']) {
                                                    case 'news': echo 'bg-purple-100 text-purple-700'; break;
                                                    case 'report': echo 'bg-blue-100 text-blue-700'; break;
                                                    case 'event': echo 'bg-green-100 text-green-700'; break;
                                                    default: echo 'bg-gray-100 text-gray-600';
                                                }
                                            ?> 
                                            flex items-center justify-center mr-3">
                                            <?php 
                                                switch($item['type']) {
                                                    case 'news': echo '<i class="fas fa-newspaper"></i>'; break;
                                                    case 'report': echo '<i class="fas fa-file-alt"></i>'; break;
                                                    case 'event': echo '<i class="fas fa-calendar-alt"></i>'; break;
                                                    default: echo '<i class="fas fa-info-circle"></i>';
                                                }
                                            ?>
                                        </div>
                                        <div>
                                            <h3 class="font-medium text-gray-800"><?= htmlspecialchars($item['title']) ?></h3>
                                            <p class="text-xs text-gray-500 mt-1">
                                                <?= htmlspecialchars(ucfirst($item['type'])) ?> - 
                                                <?= date('M d, Y', strtotime($item['published_at'])) ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php else: ?>
                    <!-- Investor/Expert Dashboard -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                        <!-- Profile Summary -->
                        <div class="bg-white rounded-lg shadow p-6">
                            <h2 class="text-lg font-semibold text-gray-800 mb-4">Your Profile Info</h2>
                            <?php
                                $stmt = $pdo->prepare("SELECT * FROM company_profiles WHERE user_id = ?");
                                $stmt->execute([$user_id]);
                                $company = $stmt->fetch(PDO::FETCH_ASSOC);
                            ?>
                            <div class="space-y-3">
                                <div>
                                    <p class="text-sm text-gray-500">Name</p>
                                    <p class="font-medium"><?= htmlspecialchars($user['full_name'] ?? 'User') ?></p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Email</p>
                                    <p class="font-medium"><?= htmlspecialchars($user['email'] ?? '') ?></p>
                                </div>
                                <?php if ($company): ?>
                                    <div>
                                        <p class="text-sm text-gray-500">Company Name</p>
                                        <p class="font-medium"><?= htmlspecialchars($company['name']) ?></p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Company Size</p>
                                        <p class="font-medium"><?= htmlspecialchars(ucfirst($company['size'])) ?></p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Investment Type</p>
                                        <p class="font-medium"><?= htmlspecialchars($company['investment_type']) ?></p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Location</p>
                                        <p class="font-medium"><?= htmlspecialchars($company['location']) ?></p>
                                    </div>
                                <?php else: ?>
                                    <div class="mt-4 text-center">
                                        <p class="text-sm text-gray-500 mb-2">No company profile found</p>
                                        <a href="company_profilei.php" class="text-blue-600 hover:text-blue-800 font-medium">Add Company Profile</a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="bg-white rounded-lg shadow p-6">
                            <h2 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h2>
                            <div class="space-y-3">
                            <!-- DEBUG START QUICK ACTIONS -->
                                <a href="invest.php" class="w-full flex items-center p-3 bg-blue-50 text-blue-600 rounded-md hover:bg-blue-100 transition">
                                    <i class="fas fa-plus-circle mr-3"></i>
                                    <span>Add New Investment</span>
                                </a>
                                <a href="reports.php" class="w-full flex items-center p-3 bg-green-50 text-green-600 rounded-md hover:bg-green-100 transition">
                                    <i class="fas fa-file-export mr-3"></i>
                                    <span>Generate Report</span>
                                </a>
                                <a href="index.php#opportunities" class="w-full flex items-center p-3 bg-purple-50 text-purple-600 rounded-md hover:bg-purple-100 transition">
                                    <i class="fas fa-search mr-3"></i>
                                    <span>Find Opportunities</span>
                                </a>
                                <a href="index.php" class="w-full flex items-center p-3 bg-yellow-50 text-yellow-600 rounded-md hover:bg-yellow-100 transition">
                                    <i class="fas fa-question-circle mr-3"></i>
                                    <span>Get Support</span>
                                </a>
                                <a href="create-opportunity.php" class="w-full flex items-center p-3 bg-pink-50 text-pink-600 rounded-md hover:bg-pink-100 transition">
                                    <i class="fas fa-lightbulb mr-3"></i>
                                    <span>Create New Opportunity</span>
                                </a>
                                <div style="background: red; color: white; padding: 10px; text-align: center;">TEST BOX - SHOULD BE VISIBLE</div>
                            <!-- DEBUG END QUICK ACTIONS -->
                            </div>
                        </div>

                        <!-- Investment Chart -->
                        <div class="bg-white rounded-lg shadow p-6">
                            <div class="flex justify-between items-center mb-4">
                                <h2 class="text-lg font-semibold text-gray-800">Investment Performance</h2>
                                <div class="flex space-x-2">
                                    <button class="px-3 py-1 text-sm bg-blue-100 text-blue-600 rounded-md">1M</button>
                                    <button class="px-3 py-1 text-sm bg-blue-600 text-white rounded-md">6M</button>
                                    <button class="px-3 py-1 text-sm bg-blue-100 text-blue-600 rounded-md">1Y</button>
                                </div>
                            </div>
                            <div class="chart-container">
                                <canvas id="investmentChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Recommended Opportunities -->
                    <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
                        <div class="p-6 border-b">
                            <h2 class="text-lg font-semibold text-gray-800">Recommended Investment Opportunities</h2>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sector</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Capital Range</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Risk</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Timeline</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <?php
                                        $stmt = $pdo->query("SELECT io.title, s.name AS sector, io.capital_min, io.capital_max, io.risk_level, io.timeline_months 
                                                            FROM investment_opportunities io
                                                            LEFT JOIN sectors s ON io.sector_id = s.sector_id
                                                            ORDER BY io.created_at DESC
                                                            LIMIT 5");
                                        $opportunities = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    ?>
                                    <?php foreach ($opportunities as $opp): ?>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($opp['title']) ?></td>
                                            <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($opp['sector'] ?? 'N/A') ?></td>
                                            <td class="px-6 py-4 whitespace-nowrap">€<?= htmlspecialchars(number_format($opp['capital_min'], 2)) ?> - €<?= htmlspecialchars(number_format($opp['capital_max'], 2)) ?></td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 py-1 text-xs rounded-full risk-<?= strtolower($opp['risk_level']) ?>"><?= htmlspecialchars(ucfirst($opp['risk_level'])) ?></span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($opp['timeline_months']) ?> months</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <button class="text-blue-600 hover:text-blue-800">View</button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="p-4 border-t text-center">
                            <a href="index.php#opportunities" class="text-blue-600 hover:text-blue-800 font-medium">View All Opportunities</a>
                            <?php if ($user_type === 'expert'): ?>
                                <a href="create-opportunity.php" class="ml-4 text-blue-600 hover:underline font-medium">Create New Opportunity</a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Latest News -->
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <div class="p-6 border-b">
                            <h2 class="text-lg font-semibold text-gray-800">Latest News & Reports</h2>
                        </div>
                        <div class="divide-y divide-gray-200">
                            <?php
                                $stmt = $pdo->query("SELECT title, published_at, type FROM cms_content ORDER BY published_at DESC LIMIT 5");
                                $news = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            ?>
                            <?php foreach ($news as $item): ?>
                                <div class="p-4 hover:bg-gray-50 transition">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 h-10 w-10 rounded-full 
                                            <?php 
                                                switch($item['type']) {
                                                    case 'news': echo 'bg-blue-100 text-blue-600'; break;
                                                    case 'report': echo 'bg-green-100 text-green-600'; break;
                                                    case 'event': echo 'bg-purple-100 text-purple-600'; break;
                                                    default: echo 'bg-gray-100 text-gray-600';
                                                }
                                            ?> 
                                            flex items-center justify-center mr-3">
                                            <?php 
                                                switch($item['type']) {
                                                    case 'news': echo '<i class="fas fa-newspaper"></i>'; break;
                                                    case 'report': echo '<i class="fas fa-file-alt"></i>'; break;
                                                    case 'event': echo '<i class="fas fa-calendar-alt"></i>'; break;
                                                    default: echo '<i class="fas fa-info-circle"></i>';
                                                }
                                            ?>
                                        </div>
                                        <div>
                                            <h3 class="font-medium text-gray-800"><?= htmlspecialchars($item['title']) ?></h3>
                                            <p class="text-xs text-gray-500 mt-1">
                                                <?= htmlspecialchars(ucfirst($item['type'])) ?> - 
                                                <?= date('M d, Y', strtotime($item['published_at'])) ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Toggle sidebar
        document.getElementById('toggleSidebar').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('collapsed');
            document.querySelector('.main-content').classList.toggle('ml-64');
            document.querySelector('.main-content').classList.toggle('ml-20');
        });

        // Mobile menu toggle
        document.getElementById('mobileMenuButton').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('active');
        });

        // Investment Chart
        const ctx = document.getElementById('investmentChart').getContext('2d');
        const investmentChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                datasets: [{
                    label: 'Portfolio Value (€)',
                    data: [150000, 165000, 172000, 185000, 195000, 210000, 245890],
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderColor: 'rgba(59, 130, 246, 1)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: false,
                        grid: {
                            drawBorder: false
                        },
                        ticks: {
                            callback: function(value) {
                                return '€' + value.toLocaleString();
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // AI Risk Assessment button functionality
        document.querySelectorAll('.ai-risk-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const sector = this.dataset.sector;
                const capital_min = this.dataset.capitalMin;
                const capital_max = this.dataset.capitalMax;
                const timeline = this.dataset.timeline;
                const resultSpan = this.nextElementSibling;
                resultSpan.textContent = '...';
                fetch('ai_risk_assess.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ sector, capital_min, capital_max, timeline })
                })
                .then(res => res.json())
                .then(data => {
                    resultSpan.textContent = data.risk;
                })
                .catch(() => {
                    resultSpan.textContent = 'Error';
                });
            });
        });

        // Dark mode toggle (example functionality)
        const darkModeToggle = document.createElement('button');
        darkModeToggle.innerHTML = '<i class="fas fa-moon"></i>';
        darkModeToggle.className = 'text-gray-600 focus:outline-none ml-4';
        darkModeToggle.addEventListener('click', function() {
            document.documentElement.classList.toggle('dark');
            this.innerHTML = document.documentElement.classList.contains('dark') 
                ? '<i class="fas fa-sun"></i>' 
                : '<i class="fas fa-moon"></i>';
        });
        document.querySelector('header .flex').appendChild(darkModeToggle);
    </script>
</body>
</html>