<?php
include_once 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$user_type = $_SESSION['user_type'] ?? 'investor';

// Fetch user info
$user_stmt = $pdo->prepare("SELECT full_name, profile_picture, total_value, total_invested, investments_made FROM users WHERE user_id = ?");
$user_stmt->execute([$user_id]);
$user = $user_stmt->fetch(PDO::FETCH_ASSOC);

$user_name = htmlspecialchars($user['full_name']);
$user_pic = !empty($user['profile_picture']) ? htmlspecialchars($user['profile_picture']) : 'https://randomuser.me/api/portraits/men/32.jpg';

// Portfolio stats
$portfolio_value = number_format($user['total_value'], 2);
$investments_made = (int) $user['investments_made'];
$total_value = $user['total_value'] ?? 0.0;
if($total_value==0):$total_invested=0;else:$total_invested=$_SESSION['total_invested'];endif;
$active_opportunities = $pdo->query("SELECT COUNT(*) FROM investment_opportunities")->fetchColumn();

// Dummy average return — replace with actual logic if available
$avg_return = 14.2;

// Fetch user's investments (assuming company_profiles or future user-investment mapping)
$investments = $pdo->query("
    SELECT io.title AS opportunity, s.name AS sector, io.capital_min AS amount,
           io.created_at AS date, io.risk_level, io.description, io.contact_email,
           'Active' AS status, '+10%' AS `return`, 'Prishtina' AS location,
           CONCAT('https://source.unsplash.com/600x400/?investment,', s.name) AS img
    FROM investment_opportunities io
    LEFT JOIN sectors s ON io.sector_id = s.sector_id
    ORDER BY io.created_at DESC
    LIMIT 4
")->fetchAll(PDO::FETCH_ASSOC);


// Market Reports
$market_reports = $pdo->query("
    SELECT title, published_at
    FROM cms_content
    WHERE type = 'report'
    ORDER BY published_at DESC
    LIMIT 6
")->fetchAll(PDO::FETCH_ASSOC);

// Sector Analysis (based on analytics_data)
$sector_stmt = $pdo->query("
    SELECT s.name AS sector, 
           CONCAT('+', ROUND(AVG(ad.value), 1), '%') AS growth,
           CONCAT('€', FORMAT(SUM(ad.value) * 1000000, 0)) AS market_size,
           COUNT(DISTINCT ad.region) AS players,
           s.sector_id
    FROM analytics_data ad
    JOIN sectors s ON ad.sector_id = s.sector_id
    GROUP BY ad.sector_id
    LIMIT 5
");

$sector_analysis = [];
$icon_map = ['Technology'=>'fa-laptop-code', 'Real Estate'=>'fa-building', 'Energy'=>'fa-bolt', 'Agriculture'=>'fa-leaf', 'Manufacturing'=>'fa-industry'];
$color_map = ['Technology'=>'blue', 'Real Estate'=>'purple', 'Energy'=>'yellow', 'Agriculture'=>'green', 'Manufacturing'=>'red'];
$sectors = $pdo->query("SELECT sector_id AS id, name FROM sectors ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);

foreach ($sector_stmt as $row) {
    $sector = $row['sector'];
    $sector_analysis[] = [
        'sector' => $sector,
        'growth' => $row['growth'],
        'market_size' => $row['market_size'],
        'players' => $row['players'],
        'icon' => $icon_map[$sector] ?? 'fa-chart-bar',
        'color' => $color_map[$sector] ?? 'gray',
        'report' => '#' // or a link to sector detail
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports - InvestKosovo</title>
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
        .report-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        .report-card {
            transition: all 0.3s ease;
        }
        .chart-container {
            width: 100%;
            /* Remove fixed height to allow full width */
            /* height: 300px; */
        }
        .tab-content {
            display: none;
        }
        .tab-content.active {
            display: block;
            animation: fadeIn 0.3s ease;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
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
    </style>
</head>
<body class="bg-gray-50">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div class="sidebar bg-blue-800 text-white w-64 fixed h-full">
            <div class="p-4 flex items-center">
                <div class="logo-icon hidden">
                    <i class="fas fa-landmark text-2xl"></i>
                </div>
                <div class="logo-text">
                    <h1 class="text-xl font-bold">InvestKosovo</h1>
                    <p class="text-xs text-blue-200">Investment Hub</p>
                </div>
                <button id="toggleSidebar" class="ml-auto text-white focus:outline-none">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
            <nav class="mt-6">
                <div class="px-4 py-2 hover:bg-blue-700">
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
                <div class="px-4 py-2 bg-blue-700">
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
                        <h1 class="text-xl font-semibold text-gray-800 ml-4">Reports & Analytics</h1>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <button class="text-gray-600 focus:outline-none">
                                <i class="fas fa-bell text-xl"></i>
                                <span class="absolute top-0 right-0 h-2 w-2 rounded-full bg-red-500"></span>
                            </button>
                        </div>
                        <div class="flex items-center">
                            <img src="<?php echo $user_pic?>" alt="User" class="h-8 w-8 rounded-full">
                            <span class="ml-2 text-gray-700"><?php echo $user_name; ?></span>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Reports Content -->
            <main class="p-6">
                <!-- Quick Stats -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                                <i class="fas fa-euro-sign text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Total Invested</p>
                                <h3 class="text-2xl font-semibold text-gray-800">€<?php echo $total_invested; ?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                                <i class="fas fa-chart-bar text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Avg. Return</p>
                                <h3 class="text-2xl font-semibold text-gray-800"><?php if($total_invested=0){echo round($total_value/$total_invested, 2);}else{echo 0;}?>%</h3>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-purple-100 text-purple-600 mr-4">
                                <i class="fas fa-project-diagram text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Active opportunities</p>
                                <h3 class="text-2xl font-semibold text-gray-800">6</h3>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 mr-4">
                                <i class="fas fa-star text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Portfolio Value</p>
                                <h3 class="text-2xl font-semibold text-gray-800">€<?php echo $total_value?></h3>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabs Navigation -->
                <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
                    <div class="border-b border-gray-200">
                        <nav class="flex -mb-px">
                            <button data-tab="portfolio" class="tab-button py-4 px-6 text-center border-b-2 font-medium text-sm border-blue-500 text-blue-600">
                                Portfolio
                            </button>
                            <button data-tab="market" class="tab-button py-4 px-6 text-center border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                                Market Reports
                            </button>
                            <button data-tab="sector" class="tab-button py-4 px-6 text-center border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                                Sector Analysis
                            </button>
                            <button data-tab="custom" class="tab-button py-4 px-6 text-center border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                                Custom Reports
                            </button>
                        </nav>
                    </div>
                </div>

                <!-- Tab Contents -->
                <div class="tab-content active" id="portfolio">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                        <!-- Portfolio Performance -->
                        <div class="lg:col-span-2 bg-white rounded-lg shadow p-6">
                            <div class="flex justify-between items-center mb-6">
                                <h2 class="text-lg font-semibold text-gray-800">Portfolio Performance</h2>
                                <div>
                                    <select class="block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                        <option>Last 6 Months</option>
                                        <option>Last Year</option>
                                        <option>Last 3 Years</option>
                                        <option>All Time</option>
                                    </select>
                                </div>
                            </div>
                            <div class="chart-container">
                                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                                <!-- This would be replaced with an actual chart library in production -->
                                <canvas class="w-full" style="background-color:gray;" id="trendChart"></canvas>
                                <script>
  const ctx = document.getElementById('trendChart').getContext('2d');

  const dataPoints = [<?php echo $total_value?>, <?php echo $total_invested ?>]; // Your values
  const labels = dataPoints.map((_, i) => `T${i+1}`);

  const chart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: labels,
      datasets: [{
        label: 'Growth Trend',
        data: dataPoints,
        borderColor: 'green',
        borderWidth: 3,
        pointRadius: 0,
        fill: false,
        tension: 0.3
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { display: false }
      },
      scales: {
        x: { display: false },
        y: { display: false }
      },
      animation: {
        onComplete: function () {
          const meta = chart.getDatasetMeta(0);
          const lastPoint = meta.data[meta.data.length - 1];
          const prevPoint = meta.data[meta.data.length - 2];

          const x = lastPoint.x;
          const y = lastPoint.y;
          const angle = Math.atan2(lastPoint.y - prevPoint.y, lastPoint.x - prevPoint.x);

          const arrowLength = 15;
          const ctx = chart.ctx;
          ctx.save();
          ctx.beginPath();
          ctx.translate(x, y);
          ctx.rotate(angle);
          ctx.moveTo(0, 0);
          ctx.lineTo(-arrowLength, -arrowLength / 2);
          ctx.lineTo(-arrowLength, arrowLength / 2);
          ctx.closePath();
          ctx.fillStyle = 'green';
          ctx.fill();
          ctx.restore();
        }
      }
    }
  });
</script>

                            </div>
                        </div>
                    </div>

                    <!-- Investment Breakdown -->
                    <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
                        <div class="p-6">
                            <h2 class="text-lg font-semibold text-gray-800 mb-4">Investment Breakdown</h2>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">opportunity</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sector</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Return</th>
                                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <?php foreach ($investments as $investment): ?>
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($investment['opportunity']) ?></td>
                                                <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($investment['sector']) ?></td>
                                                <td class="px-6 py-4 whitespace-nowrap">€<?= number_format($investment['amount'], 2) ?></td>
                                                <td class="px-6 py-4 whitespace-nowrap"><?= date('d/m/Y', strtotime($investment['date'])) ?></td>
                                                <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($investment['status']) ?></td>
                                                <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($investment['return']) ?></td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                                    <button class="text-blue-600 hover:text-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-md px-2 py-1">
                                                        View
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Market Reports Tab Content -->
                <div class="tab-content" id="market">
                    <div class="bg-white rounded-lg shadow p-6 mb-6">
                        <h2 class="text-lg font-semibold text-gray-800 mb-6">Kosovo Market Reports</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <!-- Report Card 1 -->
                            <div class="report-card bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                                <div class="p-5">
                                    <div class="flex items-center mb-4">
                                        <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                                            <i class="fas fa-building text-xl"></i>
                                        </div>
                                        <h3 class="text-lg font-semibold text-gray-800">Real Estate Market Q2 2023</h3>
                                    </div>
                                    <p class="text-gray-600 text-sm mb-4">Comprehensive analysis of Kosovo's real estate market trends, prices, and investment opportunities.</p>
                                    <div class="flex justify-between items-center">
                                        <span class="text-xs text-gray-500">Published: 15/07/2023</span>
                                        <button class="px-3 py-1 border border-blue-600 rounded-md text-sm font-medium text-blue-600 hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            Download
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Report Card 2 -->
                            <div class="report-card bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                                <div class="p-5">
                                    <div class="flex items-center mb-4">
                                        <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                                            <i class="fas fa-leaf text-xl"></i>
                                        </div>
                                        <h3 class="text-lg font-semibold text-gray-800">Agriculture Sector Report</h3>
                                    </div>
                                    <p class="text-gray-600 text-sm mb-4">Detailed overview of Kosovo's agricultural sector, including production, exports, and investment potential.</p>
                                    <div class="flex justify-between items-center">
                                        <span class="text-xs text-gray-500">Published: 30/06/2023</span>
                                        <button class="px-3 py-1 border border-blue-600 rounded-md text-sm font-medium text-blue-600 hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            Download
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Report Card 3 -->
                            <div class="report-card bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                                <div class="p-5">
                                    <div class="flex items-center mb-4">
                                        <div class="p-3 rounded-full bg-purple-100 text-purple-600 mr-4">
                                            <i class="fas fa-laptop-code text-xl"></i>
                                        </div>
                                        <h3 class="text-lg font-semibold text-gray-800">Tech Startup Ecosystem</h3>
                                    </div>
                                    <p class="text-gray-600 text-sm mb-4">Analysis of Kosovo's growing tech startup scene, including funding trends and success stories.</p>
                                    <div class="flex justify-between items-center">
                                        <span class="text-xs text-gray-500">Published: 15/06/2023</span>
                                        <button class="px-3 py-1 border border-blue-600 rounded-md text-sm font-medium text-blue-600 hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            Download
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Report Card 4 -->
                            <div class="report-card bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                                <div class="p-5">
                                    <div class="flex items-center mb-4">
                                        <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 mr-4">
                                            <i class="fas fa-bolt text-xl"></i>
                                        </div>
                                        <h3 class="text-lg font-semibold text-gray-800">Energy Sector Outlook</h3>
                                    </div>
                                    <p class="text-gray-600 text-sm mb-4">Comprehensive report on Kosovo's energy sector, including renewable energy investment opportunities.</p>
                                    <div class="flex justify-between items-center">
                                        <span class="text-xs text-gray-500">Published: 31/05/2023</span>
                                        <button class="px-3 py-1 border border-blue-600 rounded-md text-sm font-medium text-blue-600 hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            Download
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Report Card 5 -->
                            <div class="report-card bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                                <div class="p-5">
                                    <div class="flex items-center mb-4">
                                        <div class="p-3 rounded-full bg-red-100 text-red-600 mr-4">
                                            <i class="fas fa-industry text-xl"></i>
                                        </div>
                                        <h3 class="text-lg font-semibold text-gray-800">Manufacturing Sector</h3>
                                    </div>
                                    <p class="text-gray-600 text-sm mb-4">Detailed analysis of Kosovo's manufacturing sector, including key players and growth areas.</p>
                                    <div class="flex justify-between items-center">
                                        <span class="text-xs text-gray-500">Published: 15/05/2023</span>
                                        <button class="px-3 py-1 border border-blue-600 rounded-md text-sm font-medium text-blue-600 hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            Download
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Report Card 6 -->
                            <div class="report-card bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                                <div class="p-5">
                                    <div class="flex items-center mb-4">
                                        <div class="p-3 rounded-full bg-indigo-100 text-indigo-600 mr-4">
                                            <i class="fas fa-hand-holding-usd text-xl"></i>
                                        </div>
                                        <h3 class="text-lg font-semibold text-gray-800">Investment Climate</h3>
                                    </div>
                                    <p class="text-gray-600 text-sm mb-4">Annual report on Kosovo's investment climate, incentives, and regulatory framework.</p>
                                    <div class="flex justify-between items-center">
                                        <span class="text-xs text-gray-500">Published: 30/04/2023</span>
                                        <button class="px-3 py-1 border border-blue-600 rounded-md text-sm font-medium text-blue-600 hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            Download
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Pagination -->
                        <div class="mt-8 flex justify-center">
                            <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                                <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                    <span class="sr-only">Previous</span>
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                                <a href="#" aria-current="page" class="z-10 bg-blue-50 border-blue-500 text-blue-600 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                    1
                                </a>
                                <a href="#" class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                    2
                                </a>
                                <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                    <span class="sr-only">Next</span>
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            </nav>
                        </div>
                    </div>
                </div>

                <!-- Sector Analysis Tab Content -->
                <div class="tab-content" id="sector">
                    <div class="bg-white rounded-lg shadow p-6 mb-6">
                        <h2 class="text-lg font-semibold text-gray-800 mb-6">Sector Analysis</h2>
                        
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Sector Performance -->
                            <div class="bg-white rounded-lg shadow p-6">
                                <div class="flex justify-between items-center mb-6">
                                    <h3 class="text-md font-semibold text-gray-800">Sector Performance</h3>
                                    <div>
                                        <select class="block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                            <option>Last Year</option>
                                            <option>Last 3 Years</option>
                                            <option>Last 5 Years</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="chart-container">
                                    <!-- This would be replaced with an actual chart library in production -->
                                    <div class="bg-gray-100 rounded-lg h-full flex items-center justify-center">
                                        <div class="text-center p-4">
                                            <i class="fas fa-chart-bar text-4xl text-blue-500 mb-2"></i>
                                            <p class="text-gray-600">Sector performance comparison chart would display here</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Sector Risk Analysis -->
                            <div class="bg-white rounded-lg shadow p-6">
                                <h3 class="text-md font-semibold text-gray-800 mb-6">Sector Risk Analysis</h3>
                                <div class="space-y-4">
                                    <div>
                                        <div class="flex justify-between mb-1">
                                            <span class="text-sm font-medium text-gray-700">Technology</span>
                                            <span class="text-sm font-medium text-gray-700">Medium</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                                            <div class="bg-yellow-500 h-2.5 rounded-full" style="width: 55%"></div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="flex justify-between mb-1">
                                            <span class="text-sm font-medium text-gray-700">Real Estate</span>
                                            <span class="text-sm font-medium text-gray-700">Low</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                                            <div class="bg-green-500 h-2.5 rounded-full" style="width: 30%"></div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="flex justify-between mb-1">
                                            <span class="text-sm font-medium text-gray-700">Energy</span>
                                            <span class="text-sm font-medium text-gray-700">High</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                                            <div class="bg-red-500 h-2.5 rounded-full" style="width: 75%"></div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="flex justify-between mb-1">
                                            <span class="text-sm font-medium text-gray-700">Agriculture</span>
                                            <span class="text-sm font-medium text-gray-700">Medium</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                                            <div class="bg-yellow-500 h-2.5 rounded-full" style="width: 50%"></div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="flex justify-between mb-1">
                                            <span class="text-sm font-medium text-gray-700">Manufacturing</span>
                                            <span class="text-sm font-medium text-gray-700">Medium</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                                            <div class="bg-yellow-500 h-2.5 rounded-full" style="width: 60%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Sector Reports -->
                        <div class="mt-8">
                            <h3 class="text-md font-semibold text-gray-800 mb-4">Detailed Sector Reports</h3>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sector</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Growth Rate</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Market Size</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Key Players</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Report</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                                                        <i class="fas fa-laptop-code text-blue-600"></i>
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">Technology</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600 font-medium">+18.7%</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">€120M</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">42</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="#" class="text-blue-600 hover:text-blue-900">Download</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10 bg-purple-100 rounded-full flex items-center justify-center">
                                                        <i class="fas fa-building text-purple-600"></i>
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">Real Estate</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600 font-medium">+8.2%</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">€450M</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">78</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="#" class="text-blue-600 hover:text-blue-900">Download</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10 bg-yellow-100 rounded-full flex items-center justify-center">
                                                        <i class="fas fa-bolt text-yellow-600"></i>
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">Energy</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600 font-medium">+12.5%</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">€320M</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">15</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="#" class="text-blue-600 hover:text-blue-900">Download</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10 bg-green-100 rounded-full flex items-center justify-center">
                                                        <i class="fas fa-leaf text-green-600"></i>
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">Agriculture</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600 font-medium">+6.8%</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">€180M</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">210</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="#" class="text-blue-600 hover:text-blue-900">Download</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10 bg-red-100 rounded-full flex items-center justify-center">
                                                        <i class="fas fa-industry text-red-600"></i>
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">Manufacturing</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600 font-medium">+9.3%</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">€280M</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">65</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="#" class="text-blue-600 hover:text-blue-900">Download</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Custom Reports Tab Content -->
                <div class="tab-content" id="custom">
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-lg font-semibold text-gray-800 mb-6">Generate Custom Reports</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <!-- Report Configuration -->
                            <div>
                                <h3 class="text-md font-medium text-gray-800 mb-4">Report Parameters</h3>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Report Type</label>
                                        <select class="block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                            <option>Portfolio Performance</option>
                                            <option>Sector Analysis</option>
                                            <option>Investment History</option>
                                            <option>Risk Assessment</option>
                                            <option>Custom Analysis</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Time Period</label>
                                        <div class="grid grid-cols-2 gap-2">
                                            <input type="date" class="block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md" placeholder="Start Date">
                                            <input type="date" class="block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md" placeholder="End Date">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Sectors</label>
                                        <?php foreach ($sectors as $sector): ?>
    <input type="checkbox" class="mr-2 leading-tight"
           id="<?= htmlspecialchars($sector['id']) ?>"
           name="sectors[]"
           value="<?= htmlspecialchars($sector['name']) ?>">
    <label for="<?= htmlspecialchars($sector['id']) ?>"
           class="text-sm text-gray-700">
        <?= htmlspecialchars($sector['name']) ?>
    </label><br>
<?php endforeach; ?>

                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Format</label>
                                        <select class="block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                            <option>PDF</option>
                                            <option>Excel</option>
                                            <option>CSV</option>
                                            <option>HTML</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Preview Section -->
                            <div>
                                <h3 class="text-md font-medium text-gray-800 mb-4">Report Preview</h3>
                                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 h-full flex flex-col justify-center items-center">
                                    <i class="fas fa-file-alt text-5xl text-gray-400 mb-4"></i>
                                    <p class="text-gray-600 text-center">Configure your report parameters to see a preview of what your custom report will include.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex justify-end space-x-3">
                            <button class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                Reset
                            </button>
                            <button class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                Generate Report
                            </button>
                        </div>
                        
                        <!-- Previous Custom Reports -->
                        <div class="mt-12">
                            <h3 class="text-md font-medium text-gray-800 mb-4">Your Previous Custom Reports</h3>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Report Name</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Generated</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Period</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Format</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Portfolio Performance Q2 2023</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">15/07/2023</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Apr - Jun 2023</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">PDF</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="#" class="text-blue-600 hover:text-blue-900 mr-3">Download</a>
                                                <a href="#" class="text-blue-600 hover:text-blue-900">Regenerate</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Tech Sector Analysis</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">30/06/2023</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Jan - Jun 2023</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Excel</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="#" class="text-blue-600 hover:text-blue-900 mr-3">Download</a>
                                                <a href="#" class="text-blue-600 hover:text-blue-900">Regenerate</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Full Investment History</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">15/05/2023</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">All Time</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">CSV</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="#" class="text-blue-600 hover:text-blue-900 mr-3">Download</a>
                                                <a href="#" class="text-blue-600 hover:text-blue-900">Regenerate</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

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

        // Tab functionality
        document.querySelectorAll('.tab-button').forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons and add to clicked one
                document.querySelectorAll('.tab-button').forEach(btn => {
                    btn.classList.remove('border-blue-500', 'text-blue-600');
                    btn.classList.add('border-transparent', 'text-gray-500');
                });
                this.classList.remove('border-transparent', 'text-gray-500');
                this.classList.add('border-blue-500', 'text-blue-600');
                
                // Hide all tab contents and show the selected one
                const tabId = this.getAttribute('data-tab');
                document.querySelectorAll('.tab-content').forEach(tab => {
                    tab.classList.remove('active');
                });
                document.getElementById(tabId).classList.add('active');
            });
        });
    </script>
</body>
</html>