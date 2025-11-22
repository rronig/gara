<?php
require_once 'config.php'; session_start(); if(isset($_SESSION['user_id'])){header("Location: account.php");exit;} 
$email = $password = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$password = test_input($_POST["password"]);
	$cpassword = test_input($_POST["confirm_password"]);
	$hashedpassword=password_hash($password, PASSWORD_BCRYPT);
	$email = test_input($_POST["email"]);
	$name=test_input($_POST['name']);
	$stmt=$pdo->prepare("SELECT COUNT(*) FROM users WHERE email=?");
	$stmt->execute([$email]);
	$count=$stmt->fetchColumn();
	if($count>0){
		$error="Email already exists!";
	}else{
		if((string) $cpassword===(string) $password){
			$instmt=$pdo->prepare('INSERT INTO users (name, email, pass) VALUES (?, ?, ?)');$instmt->execute([$name, $email, $hashedpassword]);$_SESSION['user_id']=$user['user_id'];header("Location: account.php");exit;
		}else{
			$error="Passwords do not match!";
			}
	}
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
  <title>CityCare – Sign Up</title>
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
			alertnesses:"#ff0000"
          }
        }
      }
    }
  </script>
</head>
<body class="bg-cream flex items-center justify-center min-h-screen">

  <div class="bg-beige shadow-lg rounded-xl w-full max-w-md p-8">
    <h2 class="text-3xl font-bold text-blueSoft text-center mb-6">Create an Account</h2>
	<h2 class="text-2xl text-center font-bold text-alertnesses mb-6"><?php if(isset($error)){echo $error;} ?></h2>
    <form method="POST" class="space-y-5">
      <div>
        <label for="name" class="block font-semibold mb-1">Full Name</label>
        <input type="text" id="name" name="name" required
               class="w-full p-3 rounded-lg border border-blueLight focus:ring-2 focus:ring-blueSoft outline-none bg-cream">
      </div>

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

      <div>
        <label for="confirm_password" class="block font-semibold mb-1">Confirm Password</label>
        <input type="password" id="confirm_password" name="confirm_password" required
               class="w-full p-3 rounded-lg border border-blueLight focus:ring-2 focus:ring-blueSoft outline-none bg-cream">
      </div>

      <button type="submit"
              class="w-full bg-blueSoft hover:bg-blueSoft/80 text-white font-bold py-3 rounded-xl shadow-lg transition">
        Sign Up
      </button>
    </form>

    <p class="text-center text-gray-700 mt-5">
      Already have an account? 
      <a href="login.php" class="text-blueSoft font-semibold hover:underline">Login</a>
    </p>
  </div>

</body>
</html>
