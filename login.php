<?php
session_start();
include_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    $errors = [];
    $success = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = trim($_POST['email']);
        $password = $_POST['password'];

        if (empty($email) || empty($password)) {
            $errors[] = "Email and password are required.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format.";
        } else {
            $stmt = $pdo->prepare("SELECT user_id, full_name, password_hash FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password_hash'])) {
                $update = $pdo->prepare("UPDATE users SET last_login = NOW() WHERE user_id = ?");
                $update->execute([$user['user_id']]);

                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['full_name'] = $user['full_name'];

                header("Location: dashboard.php");
                exit;
            } else {
                $errors[] = "Invalid email or password.";
            }
        }
    }
    ?>
<!DOCTYPE html>
<html>
<head>
    <title>Login - InvestKosovo Hub</title>
    <style>
        body { font-family: Arial; margin: 40px; }
        .form-container { max-width: 400px; margin: auto; }
        input[type="email"], input[type="password"] {
            width: 100%; padding: 10px; margin: 8px 0;
        }
        .message { color: red; }
        .success { color: green; }
        .dsa{color:rgb(95, 95, 186);}
    </style>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Tailwind CDN (for utility classes) -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<div class="container max-w-md mt-16 p-6 bg-white rounded-lg shadow-lg">
    <h2 class="text-3xl font-semibold mb-6 text-center text-primary">Log In</h2>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger" role="alert">
            <?= implode('<br>', $errors) ?>
        </div>
    <?php elseif ($success): ?>
        <div class="alert alert-success" role="alert">
            <?= $success ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="mb-4">
            <label class="form-label fw-semibold" for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
        </div>

        <div>
            <label class="form-label fw-semibold" for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
            <a class="d-block mb-2 text-center" href="signin.php">
                <p class="dsa mb-0">Don't have an account? Click here!</p>
            </a>
        <button type="submit" class="btn btn-primary w-full py-2 text-lg font-semibold hover:bg-blue-700 transition duration-200">Log In</button>
    </form>
</div>

</body>
</html>
<?php
} else {
    // If user is already logged in, redirect to dashboard
    header("Location: dashboard.php");
    exit;
}
?>