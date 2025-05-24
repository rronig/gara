<?php
session_start();
include_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    $errors = [];
    $success = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $full_name = trim($_POST['full_name']);
        $email = trim($_POST['email']);
        $password = $_POST['password'];

        if (empty($full_name) || empty($email) || empty($password)) {
            $errors[] = "All fields are required.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format.";
        } else {
            $stmt = $pdo->prepare("SELECT user_id FROM users WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->fetch()) {
                $errors[] = "Email is already registered.";
            }
        }

        if (empty($errors)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (full_name, email, password_hash) VALUES (?, ?, ?)");
            if ($stmt->execute([$full_name, $email, $hashed_password])) {
                $_SESSION['user_id'] = $pdo->lastInsertId();
                $_SESSION['full_name'] = $full_name;
                header("Location: dashboard.php");
                exit;
            } else {
                $errors[] = "Signup failed. Please try again.";
            }
        }
    }
    ?>

    <!DOCTYPE html>
    <html>
    <head>
        <title>Sign Up - InvestKosovo Hub</title>
        <style>
            body { font-family: Arial; margin: 40px; }
            .form-container { max-width: 400px; margin: auto; }
            input[type="text"], input[type="email"], input[type="password"] {
                width: 100%; padding: 10px; margin: 8px 0;
            }
            .message { color: red; }
            .success { color: green; }
            .dsa { color: rgb(95, 95, 186); }
        </style>
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- Tailwind CDN (for utility classes) -->
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body>
    <div class="container max-w-md mt-16 p-6 bg-white rounded-lg shadow-lg">
        <h2 class="text-3xl font-semibold mb-6 text-center text-primary">Create an Account</h2>

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
                <label class="form-label fw-semibold" for="full_name">Full Name</label>
                <input type="text" class="form-control" id="full_name" name="full_name" required value="<?= htmlspecialchars($_POST['full_name'] ?? '') ?>">
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold" for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
            </div>

            <div class="mb-2">
                <label class="form-label fw-semibold" for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <a class="d-block mb-2 text-center" href="login.php">
                <p class="dsa mb-0">Already have an account? Click here!</p>
            </a>

            <button type="submit" class="btn btn-primary w-full py-2 text-lg font-semibold hover:bg-blue-700 transition duration-200">Sign Up</button>
        </form>
    </div>

    </body>
    </html>

<?php
} else {
    // User already logged in, redirect
    header("Location: dashboard.php");
    exit;
}
?>
