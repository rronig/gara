<?php session_start();require_once 'config.php'; if(!isset($_SESSION['user_id'])){header("Location: login.php");exit;} $stmtms=$pdo->prepare("Select * FROM users where user_id=?");$stmtms->execute([$_SESSION['user_id']]);$userdata=$stmtms->fetch(PDO::FETCH_ASSOC); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CityCare – Account</title>
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
<body class="bg-cream min-h-screen flex flex-col">

  <!-- NAVBAR -->
  <header class="w-full bg-blueSoft text-white shadow-md sticky top-0 z-20">
    <div class="max-w-6xl mx-auto px-6 py-4 flex justify-between items-center">
      <h1 class="text-2xl font-bold tracking-wide">CityCare</h1>
      <nav class="space-x-6 hidden sm:flex">
        <a href="index.html" class="hover:opacity-80 font-semibold">Home</a>
        <a href="issues.html" class="hover:opacity-80 font-semibold">Issues</a>
        <a href="account.html" class="hover:opacity-80 font-semibold">Account</a>
      </nav>
    </div>
  </header>

  <!-- ACCOUNT HERO -->
  <section class="bg-blueLight py-12 px-6 text-center">
    <h2 class="text-4xl font-bold text-blueSoft drop-shadow-lg">Your Account</h2>
    <p class="text-gray-700 mt-3 max-w-2xl mx-auto">Manage your profile, update password, and control your settings.</p>
  </section>

  <!-- PROFILE SECTION -->
  <section class="max-w-4xl mx-auto px-6 py-12 space-y-10">

    <!-- Profile Info -->
    <div class="bg-beige shadow-lg rounded-xl p-8 border border-blueLight/40">
      <h3 class="text-2xl font-bold text-blueSoft mb-6">Profile Information</h3>
      <form class="space-y-4" method="POST" action="editprofile.php">
        <div>
          <label class="block font-semibold">Full Name</label>
          <input type="text" value="<?= htmlspecialchars($userdata['name']) ?>" name="name"
                 class="w-full p-3 rounded-lg border border-blueLight bg-cream focus:ring-2 focus:ring-blueSoft outline-none">
        </div>

        <div>
          <label class="block font-semibold">Email</label>
          <input type="email" value="<?= htmlspecialchars($userdata['email']) ?>" name="email"
                 class="w-full p-3 rounded-lg border border-blueLight bg-cream focus:ring-2 focus:ring-blueSoft outline-none">
        </div>

        <button class="mt-4 bg-blueSoft hover:bg-blueSoft/80 text-white font-bold py-3 px-6 rounded-xl shadow-lg transition">
          Edit Profile
        </button>
      </form>
    </div>

    <!-- Change Password -->
    <div class="bg-beige shadow-lg rounded-xl p-8 border border-blueLight/40">
      <h3 class="text-2xl font-bold text-blueSoft mb-6">Change Password</h3>
      <form class="space-y-4" method="POST">
        <div>
          <label class="block font-semibold">Current Password</label>
          <input type="password" placeholder="••••••••" 
                 class="w-full p-3 rounded-lg border border-blueLight bg-cream focus:ring-2 focus:ring-blueSoft outline-none">
        </div>
        <div>
          <label class="block font-semibold">New Password</label>
          <input type="password" placeholder="••••••••"
                 class="w-full p-3 rounded-lg border border-blueLight bg-cream focus:ring-2 focus:ring-blueSoft outline-none">
        </div>
        <div>
          <label class="block font-semibold">Confirm New Password</label>
          <input type="password" placeholder="••••••••"
                 class="w-full p-3 rounded-lg border border-blueLight bg-cream focus:ring-2 focus:ring-blueSoft outline-none">
        </div>
        <button type="submit"
                class="mt-2 bg-blueSoft hover:bg-blueSoft/80 text-white font-bold py-3 px-6 rounded-xl shadow-lg transition">
          Update Password
        </button>
      </form>
    </div>

    <!-- Settings -->
    <div class="bg-beige shadow-lg rounded-xl p-8 border border-blueLight/40">
      <h3 class="text-2xl font-bold text-blueSoft mb-6">Settings</h3>
      <div class="flex items-center gap-4">
        <span class="font-semibold">Receive email notifications</span>
        <label class="relative inline-flex items-center cursor-pointer">
          <input type="checkbox" class="sr-only peer" checked>
          <div class="w-11 h-6 bg-blueLight peer-focus:outline-none rounded-full peer peer-checked:bg-blueSoft transition-all"></div>
          <div class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition-all peer-checked:translate-x-5"></div>
        </label>
      </div>

      <div class="flex items-center gap-4 mt-4">
        <span class="font-semibold">Submit reports anonymously</span>
        <label class="relative inline-flex items-center cursor-pointer">
          <input type="checkbox" class="sr-only peer">
          <div class="w-11 h-6 bg-blueLight peer-focus:outline-none rounded-full peer peer-checked:bg-blueSoft transition-all"></div>
          <div class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition-all peer-checked:translate-x-5"></div>
        </label>
      </div>
    </div>

  </section>

  <!-- FOOTER -->
  <footer class="bg-blueSoft text-white text-center py-6 mt-auto shadow-inner">
    CityCare © 2025 — Making cities cleaner and safer
  </footer>

</body>
</html>
