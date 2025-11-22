<?php require_once 'config.php'; session_start(); if(isset($_SESSION['user_id'])){header("Location: account.php");exit;} 
$email = $password = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$password = test_input($_POST["password"]);
	$email = test_input($_POST["email"]);
	$stmt=$pdo->prepare("SELECT * FROM users WHERE email=?");
	$stmt->execute([$email]);
	$user=$stmt->fetch(PDO::FETCH_ASSOC);
	if (!$user) {
        $error='Incorrect Password or Email';
    }
	if(password_verify($password, $user['pass'])){$_SESSION['user_id']=$user['user_id'];header("Location: account.php");exit;}else{$error='Incorrect Password or Email';}
}

function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>CityCare – Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            cream: "#F5EFE6",
            beige: "#E8DFCA",
            blueSoft: "#6D94C5",
            blueLight: "#CBDCEB",
          }
        }
      }
    }
  </script>
</head>
<body class="bg-cream flex items-center justify-center min-h-screen">

  <div class="bg-beige shadow-lg rounded-xl w-full max-w-md p-8">
    <h2 class="text-3xl font-bold text-blueSoft text-center mb-6">Login to CityCare</h2>

    <form method="POST" class="space-y-5">
      <div>
        <label for="email" class="block font-semibold mb-1">Email</label>
        <input type="email" id="email" name="email" required
               class="w-full p-3 rounded-lg border border-blueLight focus:ring-2 focus:ring-blueSoft outline-none bg-cream">
      </div>

      <div>
        <label for="password" class="block font-semibold mb-1">Password</label>
        <input type="password" id="password" name="password" required
               class="w-full p-3 rounded-lg border border-blueLight focus:ring-2 focus:ring-blueSoft outline-none bg-cream">
      </div>

      <button type="submit"
              class="w-full bg-blueSoft hover:bg-blueSoft/80 text-white font-bold py-3 rounded-xl shadow-lg transition">
        Login
      </button>
    </form>

    <p class="text-center text-gray-700 mt-5">
      Don’t have an account? 
      <a href="signup.php" class="text-blueSoft font-semibold hover:underline">Sign Up</a>
    </p>
  </div>

</body>
</html>
