<?php
include_once 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch opportunities for dropdown
$opps = $pdo->query("SELECT opportunity_id, title FROM investment_opportunities ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);

$success = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = floatval($_POST['amount'] ?? 0);
    $opp_id = intval($_POST['opportunity_id'] ?? 0);
    if ($amount > 0 && $opp_id > 0) {
        // Update user's total_invested
        $stmt = $pdo->prepare("UPDATE users SET total_invested = IFNULL(total_invested,0) + ? WHERE user_id = ?");
        if ($stmt->execute([$amount, $user_id])) {
            $success = true;
        } else {
            $error = 'Database error. Please try again.';
        }
    } else {
        $error = 'Please select an opportunity and enter a valid amount.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invest | InvestKosovo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="max-w-lg mx-auto mt-16 bg-white rounded-xl shadow-lg p-8">
        <h1 class="text-2xl font-bold mb-6 text-blue-700 flex items-center"><i class="fas fa-hand-holding-usd mr-3"></i> Make an Investment</h1>
        <?php if ($success): ?>
            <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-6">Investment successful! Your total invested amount has been updated.</div>
        <?php elseif ($error): ?>
            <div class="bg-red-100 text-red-800 px-4 py-3 rounded mb-6"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="post" class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Select Opportunity</label>
                <select name="opportunity_id" class="w-full px-4 py-2 rounded-md border border-gray-300" required>
                    <option value="">Choose an opportunity</option>
                    <?php foreach ($opps as $opp): ?>
                        <option value="<?= $opp['opportunity_id'] ?>"><?= htmlspecialchars($opp['title']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Investment Amount (€)</label>
                <input type="number" name="amount" min="1" step="0.01" class="w-full px-4 py-2 rounded-md border border-gray-300" required>
            </div>
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-bold transition">Invest Now</button>
        </form>
    </div>
</body>
</html>
