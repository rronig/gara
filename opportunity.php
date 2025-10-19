<?php
require_once 'config.php';

// Fetch logged-in user (for demo, user_id=1)
$user_id = 1;
$user = $pdo->prepare("SELECT full_name, profile_picture FROM users WHERE user_id = ?");
$user->execute([$user_id]);
$user = $user->fetch(PDO::FETCH_ASSOC);
$user_name = $user ? htmlspecialchars($user['full_name']) : 'User';
$user_pic = (!empty($user['profile_picture'])) ? htmlspecialchars($user['profile_picture']) : 'https://randomuser.me/api/portraits/men/32.jpg';

// Handle filters
$where = [];
$params = [];

// Sector filter
if (!empty($_GET['sector']) && $_GET['sector'] !== 'All Sectors') {
    $where[] = 's.name = ?';
    $params[] = $_GET['sector'];
}

// Region filter (assuming region is stored in description or add a region column if needed)
if (!empty($_GET['region']) && $_GET['region'] !== 'All Regions') {
    $where[] = 'io.description LIKE ?';
    $params[] = '%' . $_GET['region'] . '%';
}

// Investment type filter (assuming investment type is stored in description or add a column if needed)
if (!empty($_GET['investment_type']) && $_GET['investment_type'] !== 'All Investment Types') {
    $where[] = 'io.description LIKE ?';
    $params[] = '%' . $_GET['investment_type'] . '%';
}

// Search filter
if (!empty($_GET['search'])) {
    $where[] = '(io.title LIKE ? OR io.description LIKE ?)';

    $params[] = '%' . $_GET['search'] . '%';
    $params[] = '%' . $_GET['search'] . '%';
}

$whereSql = $where ? 'WHERE ' . implode(' AND ', $where) : '';
$stmt = $pdo->prepare("SELECT io.*, s.name AS sector_name FROM investment_opportunities io LEFT JOIN sectors s ON io.sector_id = s.sector_id $whereSql ORDER BY io.created_at DESC");
$stmt->execute($params);
$opportunities = $stmt->fetchAll(PDO::FETCH_ASSOC);

// For filter dropdowns
$sectorList = $pdo->query("SELECT name FROM sectors ORDER BY name")->fetchAll(PDO::FETCH_COLUMN);
$regions = ['Prishtina', 'Prizren', 'Gjakova', 'Peja', 'Mitrovica'];
$investmentTypes = ['Equity', 'Debt', 'Crowdfunding', 'Government Grants'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Opportunities - InvestKosovo</title>
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
        .opportunity-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        .opportunity-card {
            transition: all 0.3s ease;
        }
        .progress-bar {
            height: 6px;
            border-radius: 3px;
        }
        .progress-bar-fill {
            height: 100%;
            border-radius: 3px;
            transition: width 0.6s ease;
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
                <div class="px-4 py-2 fafaroni">
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
                        <h1 class="text-xl font-semibold text-gray-800 ml-4">Investment Opportunities</h1>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <button class="text-gray-600 focus:outline-none">
                                <i class="fas fa-bell text-xl"></i>
                                <span class="absolute top-0 right-0 h-2 w-2 rounded-full bg-red-500"></span>
                            </button>
                        </div>
                        <div class="flex items-center">
                            <img src="<?php echo $user_pic; ?>" alt="User" class="h-8 w-8 rounded-full">
                            <span class="ml-2 text-gray-700"><?php echo $user_name; ?></span>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Opportunities Content -->
            <main class="p-6">
                <!-- Filters and Search -->
                <form method="get" class="bg-white rounded-lg shadow p-4 mb-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                        <div class="mb-4 md:mb-0">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                                <input type="text" name="search" value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Search opportunities...">
                            </div>
                        </div>
                        <div class="flex flex-wrap gap-3">
                            <div>
                                <select name="sector" class="block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                    <option>All Sectors</option>
                                    <?php foreach ($sectorList as $sector): ?>
                                        <option<?php if (isset($_GET['sector']) && $_GET['sector'] === $sector) echo ' selected'; ?>><?php echo htmlspecialchars($sector); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div>
                                <select name="region" class="block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                    <option>All Regions</option>
                                    <?php foreach ($regions as $region): ?>
                                        <option<?php if (isset($_GET['region']) && $_GET['region'] === $region) echo ' selected'; ?>><?php echo htmlspecialchars($region); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div>
                                <select name="investment_type" class="block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                    <option>All Investment Types</option>
                                    <?php foreach ($investmentTypes as $type): ?>
                                        <option<?php if (isset($_GET['investment_type']) && $_GET['investment_type'] === $type) echo ' selected'; ?>><?php echo htmlspecialchars($type); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <i class="fas fa-filter mr-1"></i> Apply Filters
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Tabs Navigation -->
                <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
                    <div class="border-b border-gray-200">
                        <nav class="flex -mb-px">
                            <button data-tab="all" class="tab-button py-4 px-6 text-center border-b-2 font-medium text-sm border-blue-500 text-blue-600">
                                All Opportunities
                            </button>
                            <button data-tab="featured" class="tab-button py-4 px-6 text-center border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                                Featured
                            </button>
                            <button data-tab="trending" class="tab-button py-4 px-6 text-center border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                                Trending
                            </button>
                            <button data-tab="my-investments" class="tab-button py-4 px-6 text-center border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                                My Investments
                            </button>
                            <button data-tab="saved" class="tab-button py-4 px-6 text-center border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                                Saved
                            </button>
                        </nav>
                    </div>
                </div>

                <!-- Tab Contents -->
                <div class="tab-content active" id="all">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <?php if (!empty($opportunities)): ?>
                            <?php foreach ($opportunities as $opp): ?>
                            <div class="opportunity-card bg-white rounded-lg shadow overflow-hidden">
                                <div class="relative">
                                    <img src="https://source.unsplash.com/600x300/?business,investment,<?php echo urlencode($opp['sector_name'] ?? 'kosovo'); ?>" alt="<?php echo htmlspecialchars($opp['title']); ?>" class="w-full h-48 object-cover">
                                    <div class="absolute top-2 right-2">
                                        <button class="p-2 bg-white rounded-full shadow-md text-gray-500 hover:text-red-500">
                                            <i class="far fa-heart"></i>
                                        </button>
                                    </div>
                                    <?php if ($opp['risk_level'] == 'low'): ?>
                                        <div class="absolute bottom-2 left-2">
                                            <span class="px-2 py-1 bg-green-600 text-white text-xs rounded-full">Low Risk</span>
                                        </div>
                                    <?php elseif ($opp['risk_level'] == 'medium'): ?>
                                        <div class="absolute bottom-2 left-2">
                                            <span class="px-2 py-1 bg-yellow-600 text-white text-xs rounded-full">Medium Risk</span>
                                        </div>
                                    <?php elseif ($opp['risk_level'] == 'high'): ?>
                                        <div class="absolute bottom-2 left-2">
                                            <span class="px-2 py-1 bg-red-600 text-white text-xs rounded-full">High Risk</span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="p-4 flex flex-col h-full">
                                    <div class="flex justify-between items-start mb-2">
                                        <h3 class="text-lg font-semibold text-gray-800 break-words"><?php echo htmlspecialchars($opp['title']); ?></h3>
                                        <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full"><?php echo htmlspecialchars($opp['sector_name']); ?></span>
                                    </div>
                                    <p class="text-gray-600 text-sm mb-4 break-words line-clamp-3 overflow-hidden" style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical;">
                                        <?php
                                            $desc = isset($opp['description']) ? strip_tags($opp['description']) : '';
                                            if (mb_strlen($desc) > 120) {
                                                echo htmlspecialchars(mb_substr($desc, 0, 120)) . '...';
                                            } else {
                                                echo htmlspecialchars($desc);
                                            }
                                        ?>
                                    </p>
                                    <div class="mb-4 mt-auto">
                                        <div class="flex justify-between text-sm text-gray-600 mb-1">
                                            <span>€<?php echo number_format($opp['capital_min'], 0); ?> min</span>
                                            <span>€<?php echo number_format($opp['capital_max'], 0); ?> max</span>
                                        </div>
                                        <div class="progress-bar bg-gray-200 w-full">
                                            <div class="progress-bar-fill bg-blue-600" style="width: 0%"></div>
                                        </div>
                                    </div>
                                    <div class="flex justify-between text-sm mb-4">
                                        <div>
                                            <p class="text-gray-500">Risk</p>
                                            <p class="font-medium"><?php echo ucfirst($opp['risk_level']); ?></p>
                                        </div>
                                        <div>
                                            <p class="text-gray-500">Timeline</p>
                                            <p class="font-medium"><?php echo (int)$opp['timeline_months']; ?> months</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-500">Contact</p>
                                            <p class="font-medium break-all"><?php echo htmlspecialchars($opp['contact_email']); ?></p>
                                        </div>
                                    </div>
                                    <div class="flex justify-between">
                                        <button class="px-4 py-2 border border-blue-600 rounded-md text-sm font-medium text-blue-600 hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            Details
                                        </button>
                                        <button class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            Invest Now
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="col-span-3 text-center text-gray-500 py-12">
                                No investment opportunities found.
                            </div>
                        <?php endif; ?>
                    </div>
                    <!-- Pagination (optional, not functional) -->
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
                            <a href="#" class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                3
                            </a>
                            <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">
                                ...
                            </span>
                            <a href="#" class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                8
                            </a>
                            <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                <span class="sr-only">Next</span>
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </nav>
                    </div>
                </div>
                
                <!-- Featured Tab Content -->
                <div class="tab-content" id="featured">
                    <div class="bg-white rounded-lg shadow p-6 text-center">
                        <i class="fas fa-star text-yellow-400 text-4xl mb-4"></i>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Featured Opportunities</h3>
                        <p class="text-gray-600 mb-6">Our team of experts curates the most promising investment opportunities in Kosovo. Check back soon for featured listings.</p>
                        <button class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            Notify Me When Available
                        </button>
                    </div>
                </div>
                
                <!-- Trending Tab Content -->
                <div class="tab-content" id="trending">
                    <div class="bg-white rounded-lg shadow p-6 text-center">
                        <i class="fas fa-chart-line text-blue-500 text-4xl mb-4"></i>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Trending Investments</h3>
                        <p class="text-gray-600 mb-6">See what other investors are putting their money into. Trending opportunities will appear here based on market activity.</p>
                        <button class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            View Market Trends
                        </button>
                    </div>
                </div>
                
                <!-- My Investments Tab Content -->
                <div class="tab-content" id="my-investments">
                    <div class="bg-white rounded-lg shadow p-6 text-center">
                        <i class="fas fa-wallet text-green-500 text-4xl mb-4"></i>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Your Investment Portfolio</h3>
                        <p class="text-gray-600 mb-6">Track all your investments in one place. You currently don't have any active investments.</p>
                        <button class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            Browse Opportunities
                        </button>
                    </div>
                </div>
                
                <!-- Saved Tab Content -->
                <div class="tab-content" id="saved">
                    <div class="bg-white rounded-lg shadow p-6 text-center">
                        <i class="fas fa-bookmark text-red-500 text-4xl mb-4"></i>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Your Saved Opportunities</h3>
                        <p class="text-gray-600 mb-6">Save interesting opportunities to review later. You haven't saved any opportunities yet.</p>
                        <button class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            Start Exploring
                        </button>
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

        // Toggle save button
        document.querySelectorAll('.opportunity-card .fa-heart').forEach(heart => {
            heart.addEventListener('click', function(e) {
                e.stopPropagation();
                if (this.classList.contains('far')) {
                    this.classList.remove('far', 'text-gray-500');
                    this.classList.add('fas', 'text-red-500');
                } else {
                    this.classList.remove('fas', 'text-red-500');
                    this.classList.add('far', 'text-gray-500');
                }
            });
        });
    </script>
</body>
</html>