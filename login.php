<?php
session_start();
include_once 'config.php';

if (isset($_SESSION['user_id'])) {
    header("Location: dashboardi.php");
    exit;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $errors[] = "Both fields are required.";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['user_type'] = $user['user_type'];
            $_SESSION['total_value'] = $user['total_value'];
            $_SESSION['country'] = $user['country'] ?? '';
            $_SESSION['total_invested'] = $user['total_invested'] ?? 0;
            header("Location: dashboardi.php");
            exit;
        } else {
            $errors[] = "Invalid email or password.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Log In - InvestKosovo</title>
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
        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 12px 14px;
            margin: 10px 0 18px 0;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background: #f3f4f6;
            font-size: 1rem;
            transition: border 0.2s;
        }
        input:focus {
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
        <h2>Log In</h2>
        <?php if (!empty($errors)): ?>
            <div class="alert-danger">
                <?= implode('<br>', array_map('htmlspecialchars', $errors)) ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" />

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required />

            <button type="submit">Log In</button>
        </form>
        <p class="text-center">
            Don't have an account? <a href="signin.php">Sign up here!</a>
        </p>
    </div>
</body>
</html>