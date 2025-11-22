<?php session_start();require_once 'config.php'; $stmt=$pdo->prepare("SELECT r.*, u.name as usname FROM reports r JOIN users u on u.user_id=r.user_id ORDER BY time LIMIT 3");$stmt->execute();$recent=$stmt->fetchAll(PDO::FETCH_ASSOC);
if ($_SERVER["REQUEST_METHOD"] == "POST") {if(!isset($_SESSION['user_id'])){header("Location: login.php");}else{$title=trim($_POST['title']);$category=trim($_POST['category']);$description=trim($_POST['description']);$location=trim($_POST['location']);$anonymous = isset($_POST['anonymous']) ? 1 : 0;$insetmt=$pdo->prepare("INSERT INTO reports (user_id, name, description, category, location, anonymous) VALUES (?, ?, ?, ?, ?, ?)");if($insetmt->execute([$_SESSION['user_id'], $title, $description, $category, $location, $anonymous])) {
    echo '<script>alert("Successfully Submitted");</script>';
	header("Location: " . $_SERVER['PHP_SELF']);
    exit;
};}}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>CityCare – Report City Issues</title>

  <!-- Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Custom tailwind config for your theme -->
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            cream: "#F5EFE6",
            beige: "#E8DFCA",
            blueSoft: "#6D94C5",
            blueLight: "#CBDCEB"
          }
        }
      }
    }
  </script>
</head>

<body class="bg-cream text-gray-800">

  <!-- NAVBAR -->
  <header class="w-full bg-blueSoft text-white shadow-md sticky top-0 z-20">
    <div class="max-w-6xl mx-auto px-6 py-4 flex justify-between items-center">
      <h1 class="text-2xl font-bold tracking-wide">CityCare</h1>
      <nav class="space-x-6 hidden sm:flex">
        <a href="#report" class="hover:opacity-80 font-semibold">Report Issue</a>
        <a href="reports.php" class="hover:opacity-80 font-semibold">Issues</a>
      </nav>
    </div>
  </header>

  <!-- HERO -->
  <section class="relative bg-blueLight py-24 px-6 text-center overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-blueSoft/20 to-cream/20"></div>

    <div class="relative z-10 max-w-3xl mx-auto">
      <h2 class="text-4xl md:text-5xl font-extrabold text-blueSoft drop-shadow">
        Make Your City a Better Place
      </h2>

      <p class="text-lg text-gray-700 mt-4">
        Report pollution, broken infrastructure, safety issues and help improve your community.
      </p>

      <button 
        onclick="document.getElementById('report').scrollIntoView({behavior:'smooth'})"
        class="mt-8 bg-blueSoft hover:bg-blueSoft/80 transition text-white font-semibold py-3 px-8 rounded-xl shadow-lg">
        Report an Issue
      </button>
    </div>
  </section>

  <!-- REPORT FORM -->
  <section id="report" class="max-w-5xl mx-auto px-6 py-16">
    <h3 class="text-3xl font-bold text-blueSoft mb-8">Submit a Report</h3>

    <form method="POST" class="bg-beige p-8 rounded-xl shadow-lg space-y-6 border border-blueLight/40">
      <div>
        <label class="font-semibold">Issue Title</label>
        <input type="text" id="title" required name="title"
               class="w-full mt-2 p-3 rounded-lg border border-blueLight bg-cream focus:ring-2 focus:ring-blueSoft outline-none">
      </div>

      <div>
        <label class="font-semibold">Category</label>
        <select id="category" required name="category"
                class="w-full mt-2 p-3 rounded-lg border border-blueLight bg-cream focus:ring-2 focus:ring-blueSoft outline-none">
          <option>Pollution</option>
          <option>Broken Infrastructure</option>
          <option>Waste Management</option>
          <option>Public Safety</option>
          <option>Other</option>
        </select>
      </div>

      <div>
        <label class="font-semibold">Description</label>
        <textarea id="description" rows="4" required name="description"
                  class="w-full mt-2 p-3 rounded-lg border border-blueLight bg-cream resize-none focus:ring-2 focus:ring-blueSoft outline-none"></textarea>
      </div>

      <div>
        <label class="font-semibold">Location</label>
        <input type="text" id="location" required name="location"
               class="w-full mt-2 p-3 rounded-lg border border-blueLight bg-cream focus:ring-2 focus:ring-blueSoft outline-none">
      </div>
	  
		<div class="flex items-center gap-4">
			<span class="font-semibold">Anonymous report</span>
		
			<label class="relative inline-flex items-center cursor-pointer">
			<input type="checkbox" name="anonymous" class="sr-only peer">
			<div class="w-11 h-6 bg-blueLight peer-focus:outline-none rounded-full peer peer-checked:bg-blueSoft transition-all"></div>
			<div class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition-all peer-checked:translate-x-5"></div>
			</label>
		</div>
      <button type="submit"
              class="w-full bg-blueSoft hover:bg-blueSoft/80 text-white font-bold py-3 rounded-xl shadow-lg transition">
        Submit Issue
      </button>
    </form>
  </section>

  <!-- ISSUE LIST -->
	<section id="issues" class="max-w-5xl mx-auto px-6 pb-20">
		<h3 class="text-3xl font-bold text-blueSoft mb-8">Recently Reported Issues</h3>
		<div class="space-y-6">
			<?php foreach($recent as $r){ ?>
			<div class="bg-white/70 backdrop-blur-sm border border-blueLight/40 shadow-md p-6 rounded-xl">
				<h4 class="text-xl font-bold text-blueSoft"><?= htmlspecialchars($r['name']) ?></h4>
				<p class="mt-2"><?= htmlspecialchars($r['description']) ?></p>
				<p><span class="font-semibold">Category:</span> <?= htmlspecialchars($r['category']) ?></p>
				<p><span class="font-semibold">Location:</span> <?= htmlspecialchars($r['location']) ?></p>
				<p><?php if((int) $r['anonymous']===1){echo 'Anonymous';}else{echo $r['usname'];} ?></p>
			</div>
			<?php } ?>
		</div>
	</section>

  <!-- FOOTER -->
  <footer class="bg-blueSoft text-white text-center py-6 mt-10 shadow-inner">
    CityCare © 2025 — Making cities cleaner and safer
  </footer>
</body>
</html>
