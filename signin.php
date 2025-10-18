<?php
session_start();
include_once 'config.php';

// Redirect logged-in users to dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: dashboardi.php");
    exit;
}

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $country = trim($_POST['country'] ?? '');
    $password = $_POST['password'] ?? '';

    // Basic validations
    if (empty($full_name) || empty($email) || empty($password) || empty($country)) {
        $errors[] = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    } elseif (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters long.";
    } else {
        // Check if email already exists
        $stmt = $pdo->prepare("SELECT user_id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $errors[] = "Email is already registered.";
        }
    }

    // If no errors, insert new user
    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $user_type = $_POST['user_type'] ?? 'investor'; // get from form, default to investor
        $total_value = 0.0;             // default total value

        $stmt = $pdo->prepare("INSERT INTO users (full_name, email, password_hash, user_type, total_value, country) VALUES (?, ?, ?, ?, ?, ?)");
        if ($stmt->execute([$full_name, $email, $hashed_password, $user_type, $total_value, $country])) {
            $_SESSION['user_id'] = (int) $pdo->lastInsertId();
            $_SESSION['full_name'] = $full_name;
            $_SESSION['user_type'] = $user_type;
            $_SESSION['total_value'] = $total_value;
            $_SESSION['total_invested'] = $total_invested;
            $_SESSION['country'] = $country;

            header("Location: dashboardi.php");
            exit;
        } else {
            $errors[] = "Signup failed. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Sign Up - InvestKosovo</title>
    <style>
        body {
            font-family: 'Poppins', Arial, sans-serif;
            margin: 0;
            background: linear-gradient(135deg, #e0e7ff 0%, #f9fafb 100%);
            min-height: 100vh;
        }
        .container {
            max-width: 420px;
            margin: 48px auto;
            background: white;
            padding: 2.5rem 2rem 2rem 2rem;
            border-radius: 1.25rem;
            box-shadow: 0 8px 32px rgba(59,130,246,0.10), 0 1.5px 4px rgba(0,0,0,0.04);
            position: relative;
        }
        .container:before {
            content: '';
            position: absolute;
            top: -32px; left: 50%;
            transform: translateX(-50%);
            width: 72px; height: 72px;
            background: linear-gradient(135deg, #2563eb 0%, #60a5fa 100%);
            border-radius: 50%;
            box-shadow: 0 4px 16px rgba(59,130,246,0.15);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container h2 {
            text-align: center;
            margin-bottom: 2rem;
            font-size: 2rem;
            font-weight: 700;
            color: #2563eb;
            letter-spacing: -1px;
        }
        input[type="text"], input[type="email"], input[type="password"], select {
            width: 100%;
            padding: 12px 14px;
            margin: 10px 0 18px 0;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background: #f3f4f6;
            font-size: 1rem;
            transition: border 0.2s;
        }
        input:focus, select:focus {
            border-color: #2563eb;
            outline: none;
            background: #fff;
        }
        .alert-danger {
            background-color: #fee2e2;
            color: #b91c1c;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 1.2rem;
            font-size: 0.98rem;
        }
        .alert-success {
            background-color: #d1fae5;
            color: #047857;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 1.2rem;
            font-size: 0.98rem;
        }
        label {
            font-weight: 600;
            display: block;
            margin-bottom: 4px;
            color: #374151;
        }
        button {
            width: 100%;
            padding: 14px;
            background: linear-gradient(90deg, #2563eb 0%, #60a5fa 100%);
            border: none;
            color: white;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(59,130,246,0.08);
            margin-top: 10px;
            transition: background 0.2s;
        }
        button:hover {
            background: linear-gradient(90deg, #1d4ed8 0%, #2563eb 100%);
        }
        .text-center {
            text-align: center;
            margin-top: 1.5rem;
            color: #6b7280;
        }
        a {
            color: #2563eb;
            text-decoration: none;
            font-weight: 500;
        }
        a:hover {
            text-decoration: underline;
        }
        @media (max-width: 500px) {
            .container { padding: 1.2rem 0.5rem; }
            .container:before { width: 56px; height: 56px; top: -24px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 style="text-align:center; margin-bottom: 1.5rem;">Create an Account</h2>

        <?php if (!empty($errors)): ?>
            <div class="alert-danger">
                <?= implode('<br>', array_map('htmlspecialchars', $errors)) ?>
            </div>
        <?php elseif ($success): ?>
            <div class="alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <label for="full_name">Full Name</label>
            <input type="text" id="full_name" name="full_name" required value="<?= htmlspecialchars($_POST['full_name'] ?? '') ?>" />

            <label for="email">Email</label>
            <input type="email" id="email" name="email" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" />

            <label for="country">Country</label>
            <select id="country" name="country" required class="w-full px-4 py-2 rounded-md border border-gray-300 mb-4">
                <option value="">Select your country</option>
                <option value="Kosovo" <?= (($_POST['country'] ?? '') == 'Kosovo') ? 'selected' : '' ?>>Kosovo</option>
                <option value="Albania" <?= (($_POST['country'] ?? '') == 'Albania') ? 'selected' : '' ?>>Albania</option>
                <option value="Germany" <?= (($_POST['country'] ?? '') == 'Germany') ? 'selected' : '' ?>>Germany</option>
                <option value="Switzerland" <?= (($_POST['country'] ?? '') == 'Switzerland') ? 'selected' : '' ?>>Switzerland</option>
                <option value="USA" <?= (($_POST['country'] ?? '') == 'USA') ? 'selected' : '' ?>>USA</option>
                <option value="Austria" <?= (($_POST['country'] ?? '') == 'Austria') ? 'selected' : '' ?>>Austria</option>
                <option value="UK" <?= (($_POST['country'] ?? '') == 'UK') ? 'selected' : '' ?>>UK</option>
                <option value="Other" <?= (($_POST['country'] ?? '') == 'Other') ? 'selected' : '' ?>>Other</option>
            </select>

            <label for="user_type">Account Type</label>
            <select id="user_type" name="user_type" required class="w-full px-4 py-2 rounded-md border border-gray-300 mb-4">
                <option value="investor" <?= (($_POST['user_type'] ?? '') == 'investor') ? 'selected' : '' ?>>Investor</option>
                <option value="expert" <?= (($_POST['user_type'] ?? '') == 'expert') ? 'selected' : '' ?>>Expert</option>
            </select>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required />

            <button type="submit">Sign Up</button>
        </form>

        <p class="text-center">
            Already have an account? <a href="login.php">Log in here!</a>
        </p>
    </div>
</body>
</html>
