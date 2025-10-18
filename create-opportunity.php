<?php
include_once 'config.php';
session_start();

if (!isset($_SESSION['user_id']) || ($_SESSION['user_type'] ?? 'investor') !== 'admin') {
    header('Location: login.php');
    exit;
}

// Fetch sectors for dropdown
$sectors = $pdo->query("SELECT sector_id, name FROM sectors ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);

$success = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $sector_id = intval($_POST['sector_id'] ?? 0);
    $capital_min = floatval($_POST['capital_min'] ?? 0);
    $capital_max = floatval($_POST['capital_max'] ?? 0);
    $risk_level = $_POST['risk_level'] ?? '';
    $timeline_months = intval($_POST['timeline_months'] ?? 0);
    $contact_email = trim($_POST['contact_email'] ?? '');
    $active = isset($_POST['active']) ? 1 : 0;

    if ($title && $description && $sector_id && $capital_min > 0 && $capital_max > 0 && $risk_level && $timeline_months > 0 && $contact_email) {
        $stmt = $pdo->prepare("INSERT INTO investment_opportunities (title, sector_id, capital_min, capital_max, risk_level, timeline_months, description, contact_email, active) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if ($stmt->execute([$title, $sector_id, $capital_min, $capital_max, $risk_level, $timeline_months, $description, $contact_email, $active])) {
            $success = true;
        } else {
            $error = 'Database error. Please try again.';
        }
    } else {
        $error = 'Please fill in all required fields.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Opportunity | InvestKosovo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="max-w-2xl mx-auto mt-16 bg-white rounded-xl shadow-lg p-8">
        <h1 class="text-2xl font-bold mb-6 text-blue-700 flex items-center"><i class="fas fa-plus-circle mr-3"></i> Create New Opportunity</h1>
        <?php if ($success): ?>
            <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-6">Opportunity created successfully!</div>
        <?php elseif ($error): ?>
            <div class="bg-red-100 text-red-800 px-4 py-3 rounded mb-6"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="post" class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                <input type="text" name="title" class="w-full px-4 py-2 rounded-md border border-gray-300" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" rows="4" class="w-full px-4 py-2 rounded-md border border-gray-300" required></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Sector</label>
                <select name="sector_id" class="w-full px-4 py-2 rounded-md border border-gray-300" required>
                    <option value="">Choose a sector</option>
                    <?php foreach ($sectors as $sector): ?>
                        <option value="<?= $sector['sector_id'] ?>"><?= htmlspecialchars($sector['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Minimum Capital (€)</label>
                    <input type="number" name="capital_min" min="1" step="0.01" class="w-full px-4 py-2 rounded-md border border-gray-300" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Maximum Capital (€)</label>
                    <input type="number" name="capital_max" min="1" step="0.01" class="w-full px-4 py-2 rounded-md border border-gray-300" required>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Risk Level</label>
                <select name="risk_level" class="w-full px-4 py-2 rounded-md border border-gray-300" required>
                    <option value="">Select risk level</option>
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="high">High</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Timeline (months)</label>
                <input type="number" name="timeline_months" min="1" class="w-full px-4 py-2 rounded-md border border-gray-300" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Contact Email</label>
                <input type="email" name="contact_email" class="w-full px-4 py-2 rounded-md border border-gray-300" required>
            </div>
            <div class="flex items-center">
                <input type="checkbox" name="active" id="active" class="mr-2" checked>
                <label for="active" class="text-sm text-gray-700">Active</label>
            </div>
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-bold transition">Create Opportunity</button>
        </form>
    </div>
</body>
</html>
