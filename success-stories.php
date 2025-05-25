<?php
include_once 'config.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
$user_id = $_SESSION['user_id'];
// Fetch opportunities for dropdown
$oppo = $pdo->query("SELECT opportunity_id, title FROM investment_opportunities ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
$sector = $pdo->query("SELECT sector_id, name FROM sectors ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);
// Fetch success stories
$stories = $pdo->query("SELECT * FROM success_stories ORDER BY user_id")->fetchAll(PDO::FETCH_ASSOC);
$users = $pdo->query("SELECT * FROM users ORDER BY user_id")->fetchAll(PDO::FETCH_ASSOC);
// Build user_id => full_name and user_id => profile_picture maps
$userNameMap = [];
$userPicMap = [];
$userTypeMap = [];
foreach ($users as $u) {
    $userNameMap[$u['user_id']] = $u['full_name'];
    $userPicMap[$u['user_id']] = $u['profile_picture'];
    $userTypeMap[$u['user_id']] = $u['user_type'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Success Stories | InvestKosovo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Poppins', sans-serif; background: #f7f8fa; }
        .story-card { transition: all 0.3s ease; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border-left: 4px solid transparent; }
        .story-card:hover { transform: translateY(-5px); box-shadow: 0 10px 15px rgba(0,0,0,0.1); border-left-color: #2563eb; }
        .fade-in { animation: fadeIn 0.6s ease-in; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body class="min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg py-4 px-6 flex justify-between items-center">
        <div class="flex items-center">
            <a href="index.php" class="flex items-center text-gray-800 hover:text-blue-600 transition-colors">
                <img class="h-16 w-auto" src="kosova.png" alt="InvestKosovo Logo">
                <span class="text-xl font-bold bg-gradient-to-r from-blue-600 to-blue-400 bg-clip-text text-transparent ml-2">InvestKosovo Hub</span>
            </a>
        </div>
        <div class="flex items-center space-x-6">
            <a href="index.php" class="text-gray-600 hover:text-blue-600 transition-colors"><i class="fas fa-home mr-1"></i> Home</a>
            <a href="opportunity-detail.php" class="text-gray-600 hover:text-blue-600 transition-colors"><i class="fas fa-briefcase mr-1"></i> Opportunities</a>
            <a href="sector-detail.php" class="text-gray-600 hover:text-blue-600 transition-colors"><i class="fas fa-industry mr-1"></i> Sectors</a>
        </div>
    </nav>

    <!-- Header -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-400 text-white py-16 px-8 md:px-16 mb-12 fade-in rounded-b-3xl">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-3">Success Stories</h1>
            <p class="text-xl text-blue-100 max-w-3xl mx-auto">Discover how international investors and local entrepreneurs have found success in Kosovo's dynamic market.</p>
        </div>
    </div>

    <!-- Success Stories List -->
    <div class="max-w-5xl mx-auto px-6 pb-16">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <?php foreach ($stories as $story): ?>
            <div class="bg-white rounded-2xl p-8 story-card fade-in">
                <div class="flex items-center mb-4">
                    <img class="w-16 h-16 rounded-full mr-4" src="<?php echo htmlspecialchars($userPicMap[$story['user_id']] ?? 'uploads/profile_1.png'); ?>" alt="Profile Picture">
                    <div>
                        <h4 class="font-bold text-gray-900"><?php echo htmlspecialchars($userNameMap[$story['user_id']] ?? 'Unknown User'); ?></h4>
                        <p class="text-gray-600 text-sm"><?php echo htmlspecialchars($userTypeMap[$story['user_id']]); ?></p>
                    </div>
                </div>
                <p class="text-gray-700 mb-4 italic"><?php echo htmlspecialchars($story['description']); ?></p>
                <div class="flex items-center text-yellow-400 mb-2">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    <span class="text-gray-600 ml-2 text-sm"><?php echo htmlspecialchars($story['rating']); ?>/5</span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12 px-6 mt-12">
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
                    <?php foreach($oppo as $o):?>
                        <li><a href="opportunity-detail.php?id=<?= $o['opportunity_id'] ?>" class="hover:text-white transition-colors"><?= htmlspecialchars($o['title']) ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold mb-4">Sectors</h4>
                <ul class="space-y-2 text-gray-400">
                    <?php foreach($sector as $s): ?>
                        <li><a href="sector-detail.php?id=<?= $s['sector_id'] ?>" class="hover:text-white transition-colors"><?= htmlspecialchars($s['name']) ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold mb-4">Contact</h4>
                <ul class="space-y-2 text-gray-400">
                    <li class="flex items-center"><i class="fas fa-map-marker-alt mr-2 text-indigo-400"></i> Prishtina, Kosovo</li>
                    <li class="flex items-center"><i class="fas fa-phone-alt mr-2 text-indigo-400"></i> +383 49 123 456</li>
                    <li class="flex items-center"><i class="fas fa-envelope mr-2 text-indigo-400"></i> info@investkosovo.com</li>
                </ul>
            </div>
        </div>
        <div class="max-w-6xl mx-auto pt-8 mt-8 border-t border-gray-800 text-center text-gray-500 text-sm">
            <p>© 2025 InvestKosovo. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
