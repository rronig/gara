<?php
include_once('config.php');
// Fetch all sectors for dropdown
$sectors = [];
$sectors_q = $pdo->query("SELECT sector_id, name FROM sectors ORDER BY name ASC");
while ($row = $sectors_q->fetch(PDO::FETCH_ASSOC)) {
    $sectors[] = $row;
}

// Get selected sector ID
$selected_id = isset($_GET['id']) ? intval($_GET['id']) : (count($sectors) ? $sectors[0]['sector_id'] : 0);

// Fetch selected sector details
$sector = null;
if ($selected_id) {
    $sector_q = $pdo->prepare("SELECT * FROM sectors WHERE sector_id=?");
    $sector_q->bindParam(1, $selected_id, PDO::PARAM_INT);
    $sector_q->execute();
    $sector = $sector_q->fetch(PDO::FETCH_ASSOC);
}

// Fallback if not found
if (!$sector && count($sectors)) {
    $sector = $sectors[0];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sector Details | InvestKosovo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Poppins', sans-serif; background: #f7f8fa; }
        .sector-header {
            background: linear-gradient(135deg, #43cea2 0%, #185a9d 100%);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        .detail-card {
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            border-left: 4px solid transparent;
        }
        .detail-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
            border-left-color: #43cea2;
        }
        .fade-in {
            animation: fadeIn 0.6s ease-in;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg py-4 px-6 flex justify-between items-center">
        <div class="flex items-center">
            <a href="index.php" class="flex items-center text-gray-800 hover:text-green-600 transition-colors">
                <img class="h-16 w-auto" src="kosova.png" alt="InvestKosovo Logo">
                <span class="text-xl font-bold bg-gradient-to-r from-green-600 to-blue-600 bg-clip-text text-transparent ml-2">InvestKosovo</span>
            </a>
            <!-- Sector Selector Dropdown -->
            <form method="get" class="ml-6">
                <select id="sector-select" name="id" class="rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-green-400" onchange="this.form.submit()">
                    <?php foreach ($sectors as $s): ?>
                        <option value="<?= $s['sector_id'] ?>" <?= $selected_id == $s['sector_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($s['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </form>
        </div>
        <div class="flex items-center space-x-6">
            <a href="index.php" class="text-gray-600 hover:text-green-600 transition-colors">
                <i class="fas fa-home mr-1"></i> Home
            </a>
            <a href="opportunity.php" class="text-gray-600 hover:text-green-600 transition-colors">
                <i class="fas fa-briefcase mr-1"></i> Opportunities
            </a>
            <a href="#" class="text-gray-600 hover:text-green-600 transition-colors">
                <i class="fas fa-user mr-1"></i> Account
            </a>
        </div>
    </nav>

    <!-- Sector Header -->
    <div class="sector-header rounded-b-3xl text-white py-12 px-8 md:px-16 mb-12 fade-in">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-4xl md:text-5xl font-bold mb-3">
                <?= htmlspecialchars($sector['name'] ?? 'Sector') ?>
            </h1>
            <p class="text-xl text-green-100 max-w-3xl">
                <?= htmlspecialchars($sector['description'] ?? 'No description available.') ?>
            </p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-4xl mx-auto px-6 pb-16">
        <div class="grid grid-cols-1 gap-8">
            <!-- Sector Details -->
            <div class="bg-white rounded-2xl shadow-md p-8 detail-card fade-in">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                    <i class="fas fa-industry text-green-500 mr-3"></i> Sector Information
                </h2>
                <div class="prose max-w-none text-gray-600">
                    <ul class="space-y-3">
                        <li><strong>Sector ID:</strong> <?= htmlspecialchars($sector['sector_id'] ?? 'N/A') ?></li>
                        <li><strong>Name:</strong> <?= htmlspecialchars($sector['name'] ?? 'N/A') ?></li>
                        <li><strong>Description:</strong> <?= nl2br(htmlspecialchars($sector['description'] ?? 'N/A')) ?></li>
                    </ul>
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
</body>
</html>
