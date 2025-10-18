<?php
include_once 'config.php';
session_start();

if (!isset($_SESSION['user_id']) || ($_SESSION['user_type'] ?? 'investor') !== 'admin') {
    header('Location: login.php');
    exit;
}

$success = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    if ($name && $description) {
        $stmt = $pdo->prepare("INSERT INTO sectors (name, description) VALUES (?, ?)");
        if ($stmt->execute([$name, $description])) {
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
    <title>Create Sector | InvestKosovo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="max-w-xl mx-auto mt-16 bg-white rounded-xl shadow-lg p-8">
        <h1 class="text-2xl font-bold mb-6 text-blue-700 flex items-center"><i class="fas fa-industry mr-3"></i> Create New Sector</h1>
        <?php if ($success): ?>
            <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-6">Sector created successfully!</div>
        <?php elseif ($error): ?>
            <div class="bg-red-100 text-red-800 px-4 py-3 rounded mb-6"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="post" class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Sector Name</label>
                <input type="text" name="name" class="w-full px-4 py-2 rounded-md border border-gray-300" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" rows="4" class="w-full px-4 py-2 rounded-md border border-gray-300" required></textarea>
            </div>
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-bold transition">Create Sector</button>
        </form>
    </div>
</body>
</html>
