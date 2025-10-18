<?php
include_once('config.php');
session_start();
// Fetch all opportunities for dropdown
$opps = [];
$opps_q = $pdo->query("SELECT opportunity_id, title FROM investment_opportunities ORDER BY created_at DESC");
while ($row = $opps_q->fetch(PDO::FETCH_ASSOC)) {
    $opps[] = $row;
}

// Get selected opportunity ID
$selected_id = isset($_GET['id']) ? intval($_GET['id']) : (count($opps) ? $opps[0]['opportunity_id'] : 0);

// Fetch selected opportunity details
$opp = null;
if ($selected_id) {
    $opp_q = $pdo->prepare("SELECT io.*, s.name as sector_name, s.description as sector_desc FROM investment_opportunities io LEFT JOIN sectors s ON io.sector_id = s.sector_id WHERE io.opportunity_id=?");
    $opp_q->bindParam(1, $selected_id, PDO::PARAM_INT);
    $opp_q->execute();
    $opp = $opp_q->fetch(PDO::FETCH_ASSOC);
}

// Fallback if not found
if (!$opp && count($opps)) {
    $opp = $opps[0];
}

// Example: You can fetch more related data here (e.g., team, images, etc.)

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Opportunity Details | InvestKosovo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
        }
        
        .opportunity-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            transform: translateY(0);
            transition: all 0.3s ease;
        }
        
        .opportunity-header:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }
        
        .detail-card {
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            border-left: 4px solid transparent;
        }
        
        .detail-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
            border-left-color: #667eea;
        }
        
        .progress-bar {
            height: 8px;
            border-radius: 4px;
            background: linear-gradient(90deg, #4fd1c5 0%, #319795 100%);
            animation: progressAnimation 2s ease-in-out;
        }
        
        @keyframes progressAnimation {
            0% { width: 0%; }
            100% { width: var(--progress-width); }
        }
        
        .tag {
            transition: all 0.2s ease;
        }
        
        .tag:hover {
            transform: scale(1.05);
        }
        
        .invest-button {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            box-shadow: 0 4px 6px rgba(16, 185, 129, 0.3);
            transition: all 0.3s ease;
        }
        
        .invest-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px rgba(16, 185, 129, 0.4);
        }
        
        .gallery-image {
            transition: all 0.3s ease;
            filter: brightness(0.95);
        }
        
        .gallery-image:hover {
            transform: scale(1.03);
            filter: brightness(1);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }
        
        .fade-in {
            animation: fadeIn 0.6s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .pulse {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(102, 126, 234, 0.7); }
            70% { box-shadow: 0 0 0 10px rgba(102, 126, 234, 0); }
            100% { box-shadow: 0 0 0 0 rgba(102, 126, 234, 0); }
        }
        
        .floating {
            animation: floating 3s ease-in-out infinite;
        }
        
        @keyframes floating {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
    </style>
</head>
<body class="min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg py-4 px-6 flex justify-between items-center">
        <div class="flex items-center">
            <a href="index.php" class="flex items-center text-gray-800 hover:text-indigo-600 transition-colors">
                <img class="h-16 w-auto" src="kosova.png" alt="InvestKosovo Logo">            
                <span class="text-xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">InvestKosovo</span>
            </a>
            <!-- Opportunity Selector Dropdown (between logo and Home) -->
            <form method="get" class="ml-6">
                <select id="opp-select" name="id" class="rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-indigo-400" onchange="this.form.submit()">
                    <?php foreach ($opps as $o): ?>
                        <option value="<?= $o['opportunity_id'] ?>" <?= $selected_id == $o['opportunity_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($o['title']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </form>
        </div>
        <div class="flex items-center space-x-6">
            <a href="index.php" class="text-gray-600 hover:text-indigo-600 transition-colors">
                <i class="fas fa-home mr-1"></i> Home
            </a>
            <a href="index.php#opportunities" class="text-gray-600 hover:text-indigo-600 transition-colors">
                <i class="fas fa-briefcase mr-1"></i> Opportunities
            </a>
            <a href="profilei.php" class="text-gray-600 hover:text-indigo-600 transition-colors">
                <i class="fas fa-user mr-1"></i> Account
            </a>
            <?php if (!isset($_SESSION['user'])){ ?>
                <a href="login.php" class="bg-indigo-600 text-white px-4 py-2 rounded-full hover:bg-indigo-700 transition-colors">
                    <i class="fas fa-sign-in-alt mr-2"></i> Login
                </a>
            <?php }else{} ?>
        </div>
    </nav>

    <!-- Opportunity Header -->
    <div class="opportunity-header rounded-b-3xl text-white py-12 px-8 md:px-16 mb-12 fade-in">
        <div class="max-w-6xl mx-auto">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                <div class="mb-6 md:mb-0">
                    <div class="flex items-center mb-4">
                        <span class="bg-white bg-opacity-20 px-3 py-1 rounded-full text-sm mr-3"><?= htmlspecialchars($opp['sector_name'] ?? 'N/A') ?></span>
                        <span class="bg-yellow-400 bg-opacity-90 text-yellow-900 px-3 py-1 rounded-full text-sm font-medium">
                            <i class="fas fa-bolt mr-1"></i> <?= ucfirst($opp['risk_level'] ?? 'N/A') ?> Risk
                        </span>
                    </div>
                    <h1 class="text-4xl md:text-5xl font-bold mb-3"><?= htmlspecialchars($opp['title'] ?? 'Opportunity') ?></h1>
                    <p class="text-xl text-indigo-100 max-w-3xl"><?= htmlspecialchars($opp['description'] ?? '') ?></p>
                </div>
                <div class="bg-white bg-opacity-10 backdrop-blur-md rounded-xl p-6 shadow-lg floating">
                    <div class="flex items-center mb-4">
                        <div class="bg-green-100 text-green-800 p-3 rounded-full mr-4">
                            <i class="fas fa-euro-sign text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-indigo-100">Funding Goal</p>
                            <p class="text-2xl font-bold">€
                                <?= number_format($opp['capital_max'] ?? 0, 0, '.', ',') ?>
                            </p>
                        </div>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2 mb-2">
                        <?php
                        // For demo, fake 72% funded. In real, calculate from investments table.
                        $percent = 72;
                        $raised = ($opp['capital_max'] ?? 0) * $percent / 100;
                        ?>
                        <div class="progress-bar rounded-full h-2" style="--progress-width: <?= $percent ?>%; width: <?= $percent ?>%;"></div>
                    </div>
                    <p class="text-sm text-indigo-100 text-right"><?= $percent ?>% funded (€<?= number_format($raised, 0, '.', ',') ?> raised)</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-6xl mx-auto px-6 pb-16">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Description -->
                <div class="bg-white rounded-2xl shadow-md p-8 detail-card fade-in" style="animation-delay: 0.4s;">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-align-left text-indigo-500 mr-3"></i> Project Description
                    </h2>
                    <div class="prose max-w-none text-gray-600">
                        <p><?= nl2br(htmlspecialchars($opp['description'] ?? '')) ?></p>
                        <!-- Optionally, add more fields from DB here -->
                    </div>
                </div>

                <!-- Financials -->
                <div class="bg-white rounded-2xl shadow-md p-8 detail-card fade-in" style="animation-delay: 0.6s;">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-chart-pie text-purple-500 mr-3"></i> Financial Overview
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-indigo-50 rounded-xl p-6">
                            <h3 class="font-semibold text-indigo-800 mb-3">Investment Terms</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Minimum Investment</span>
                                    <span class="font-medium">€
                                        <?= number_format($opp['capital_min'] ?? 0, 0, '.', ',') ?>
                                    </span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Equity Offered</span>
                                    <span class="font-medium">N/A</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Risk Level</span>
                                    <span class="font-medium text-green-600"><?= ucfirst($opp['risk_level'] ?? 'N/A') ?></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Investment Period</span>
                                    <span class="font-medium"><?= $opp['timeline_months'] ?? 'N/A' ?> months</span>
                                </div>
                            </div>
                        </div>
                        <div class="bg-purple-50 rounded-xl p-6">
                            <h3 class="font-semibold text-purple-800 mb-3">Use of Funds</h3>
                            <div class="space-y-4">
                                <!-- You can fetch and display use of funds from DB if available -->
                                <div>
                                    <div class="flex justify-between mb-1">
                                        <span class="text-sm text-gray-600">Construction</span>
                                        <span class="text-sm font-medium">45%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-indigo-600 h-2 rounded-full" style="width: 45%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between mb-1">
                                        <span class="text-sm text-gray-600">Equipment</span>
                                        <span class="text-sm font-medium">30%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-purple-600 h-2 rounded-full" style="width: 30%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between mb-1">
                                        <span class="text-sm text-gray-600">Operations</span>
                                        <span class="text-sm font-medium">15%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-pink-600 h-2 rounded-full" style="width: 15%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between mb-1">
                                        <span class="text-sm text-gray-600">Marketing</span>
                                        <span class="text-sm font-medium">10%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-blue-600 h-2 rounded-full" style="width: 10%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-8">
                <!-- Quick Facts -->
                <div class="bg-white rounded-2xl shadow-md p-8 detail-card fade-in" style="animation-delay: 0.3s;">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-info-circle text-blue-500 mr-3"></i> Quick Facts
                    </h2>
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="bg-blue-100 text-blue-600 p-2 rounded-lg mr-4">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-700">Sector</h4>
                                <p class="text-gray-600"><?= htmlspecialchars($opp['sector_name'] ?? 'N/A') ?></p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="bg-green-100 text-green-600 p-2 rounded-lg mr-4">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-700">Created At</h4>
                                <p class="text-gray-600"><?= htmlspecialchars($opp['created_at'] ?? 'N/A') ?></p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="bg-purple-100 text-purple-600 p-2 rounded-lg mr-4">
                                <i class="fas fa-bullseye"></i>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-700">Risk Level</h4>
                                <p class="text-gray-600"><?= ucfirst($opp['risk_level'] ?? 'N/A') ?></p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="bg-yellow-100 text-yellow-600 p-2 rounded-lg mr-4">
                                <i class="fas fa-users"></i>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-700">Timeline</h4>
                                <p class="text-gray-600"><?= $opp['timeline_months'] ?? 'N/A' ?> months</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="bg-red-100 text-red-600 p-2 rounded-lg mr-4">
                                <i class="fas fa-trophy"></i>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-700">Contact</h4>
                                <p class="text-gray-600"><?= htmlspecialchars($opp['contact_email'] ?? 'N/A') ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tags -->
                <div class="bg-white rounded-2xl shadow-md p-8 detail-card fade-in" style="animation-delay: 0.5s;">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-tags text-pink-500 mr-3"></i> Key Features
                    </h2>
                    <div class="flex flex-wrap gap-3">
                        <span class="tag bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm"><?= htmlspecialchars($opp['sector_name'] ?? 'N/A') ?></span>
                        <span class="tag bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm"><?= ucfirst($opp['risk_level'] ?? 'N/A') ?> Risk</span>
                        <span class="tag bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm"><?= $opp['timeline_months'] ?? 'N/A' ?> Months</span>
                        <!-- Add more tags as needed from DB -->
                    </div>
                </div>

                <!-- Team -->
                <!-- You can fetch and display team from DB if you have such a table, else keep static or show a placeholder -->
                <!-- ...existing code for team... -->
            </div>
        </div>
        <!-- Investment CTA: Stretch to both sides with same side spacing as grid (px-6) -->
        <div class="mt-8 px-6">
            <div class="bg-gradient-to-br from-green-500 to-teal-500 rounded-2xl shadow-xl p-8 text-white fade-in pulse w-full"
                 style="max-width:100%;">
                <h2 class="text-2xl font-bold mb-3">Ready to Invest?</h2>
                <p class="mb-6 opacity-90">Contact <?= htmlspecialchars($opp['contact_email'] ?? 'N/A') ?> to invest in this opportunity.</p>
                
                <div class="bg-white bg-opacity-20 rounded-lg p-4 mb-6">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm">Minimum Investment</span>
                        <span class="font-bold">€
                            <?= number_format($opp['capital_min'] ?? 0, 0, '.', ',') ?>
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm">Available Until</span>
                        <span class="font-bold">N/A</span>
                    </div>
                </div>
                
                <a href="invest.php" class="invest-button w-full py-4 rounded-xl font-bold text-lg flex items-center justify-center">
                    <i class="fas fa-hand-holding-usd mr-3"></i> Invest Now
                </a>
                <div class="mt-4 flex justify-center space-x-2 text-sm">
                    <a href="#" class="text-white opacity-80 hover:opacity-100 underline">Learn More</a>
                    <span>•</span>
                    <a href="#" class="text-white opacity-80 hover:opacity-100 underline">Schedule Call</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12 px-6">
        <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-8">
            <div>
                <h3 class="text-xl font-bold mb-4 flex items-center">
                    <img class="h-12 w-auto" src="kosova1.png" alt="InvestKosovo Logo">InvestKosovo
                </h3>
                <p class="text-gray-400">Connecting investors with Kosovo's most promising opportunities since 2018.</p>
            </div>
            <div>
                <h4 class="font-semibold mb-4">Opportunities</h4>
                <ul class="space-y-2 text-gray-400">
                    <?php
                        // Fetch opportunities with sector name
                        try {
                            $stmtOpp = $pdo->query("SELECT io.*, s.name as sector_name FROM investment_opportunities io LEFT JOIN sectors s ON io.sector_id = s.sector_id ORDER BY io.created_at DESC LIMIT 6");
                            $opportunities = $stmtOpp->fetchAll(PDO::FETCH_ASSOC);
                        } catch (PDOException $e) {
                            $opportunities = [];
                        }
                        foreach ($opportunities as $o):
                    ?>
                        <li>
                            <a href="opportunity-detail.php?id=<?= $o['opportunity_id'] ?>" class="hover:text-white transition-colors">
                                <?= htmlspecialchars($o['title']) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold mb-4">Sectors</h4>
                <ul class="space-y-2 text-gray-400">
                    <?php
                        try {
                            $stmt = $pdo->query("SELECT * FROM sectors");
                            $sectors = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        } catch (PDOException $e) {
                            echo "Error: " . $e->getMessage();
                        }
                    ?>
                    <?php foreach ($sectors as $s): ?>
                    <li>
                        <a href="sector-detail.php?id=<?= $s['sector_id'] ?>" class="hover:text-white transition-colors">
                            <?= htmlspecialchars($s['name']) ?>
                        </a>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold mb-4">Contact</h4>
                <ul class="space-y-2 text-gray-400">
                    <li class="flex items-center">
                        <i class="fas fa-map-marker-alt mr-2 text-indigo-400"></i> Prishtina, Kosovo
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-phone-alt mr-2 text-indigo-400"></i> +383 49 123 456
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-envelope mr-2 text-indigo-400"></i> info@investkosovo.com
                    </li>
                </ul>
            </div>
        </div>
        <div class="max-w-6xl mx-auto pt-8 mt-8 border-t border-gray-800 text-center text-gray-500 text-sm">
            <p>© 2025 InvestKosovo. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // Simple animation trigger
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.fade-in');
            
            cards.forEach((card, index) => {
                // Apply delay based on index
                card.style.animationDelay = `${index * 0.1}s`;
            });
            
            // Gallery image click handler (would open modal in production)
            const galleryImages = document.querySelectorAll('.gallery-image');
            galleryImages.forEach(image => {
                image.addEventListener('click', function() {
                    alert('In a real implementation, this would open a larger version of the image in a modal or lightbox.');
                });
            });
            
            // Invest button hover effect
            const investBtn = document.querySelector('.invest-button');
            investBtn.addEventListener('mouseenter', function() {
                this.style.background = 'linear-gradient(135deg, #059669 0%, #047857 100%)';
            });
            investBtn.addEventListener('mouseleave', function() {
                this.style.background = 'linear-gradient(135deg, #10b981 0%, #059669 100%)';
            });
        });
    </script>
</body>
</html>