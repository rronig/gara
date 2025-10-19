<?php
require_once 'config.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    // User not logged in, redirect to login or handle error
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];


// Fetch user info (before POST, so JS preview works even on failed upload)
$stmt = $pdo->prepare("SELECT * FROM users WHERE user_id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch company profile
$stmt2 = $pdo->prepare("SELECT * FROM company_profiles WHERE user_id = ?");
$stmt2->execute([$user_id]);
$company = $stmt2->fetch(PDO::FETCH_ASSOC);

// Demo fallback if no company profile
if (!$company) {
    $company = [
        'name' => '',
        'size' => '',
        'investment_type' => '',
        'location' => ''
    ];
}

// Helper for profile picture
$profilePic = !empty($user['profile_picture']) ? htmlspecialchars($user['profile_picture']) : 'https://randomuser.me/api/portraits/men/32.jpg';

// Handle Personal Info form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['personal_info_submit'])) {
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $total_value = $_POST['total_value'] ?? 2;
    $total_invested = $_POST['total_invested'] ?? 2;
    $full_name = $first_name . ' ' . $last_name;
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $city = trim($_POST['city'] ?? '');
    $country = trim($_POST['country'] ?? '');

    // Handle profile picture upload
    $profile_picture = $user['profile_picture'];
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION);
        $target = 'uploads/profile_' . $user_id . '.' . $ext;
        if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target)) {
            $profile_picture = $target;
            // Update $profilePic immediately for this request
            $profilePic = htmlspecialchars($profile_picture);
        }
    }

    $stmt = $pdo->prepare("UPDATE users SET full_name=?, email=?, phone=?, address=?, city=?, country=?, profile_picture=? WHERE user_id=?");
    $stmt->execute([$full_name, $email, $phone, $address, $city, $country, $profile_picture, $user_id]);

    // Do NOT redirect, so the new picture is shown immediately after save
    // header("Location: profilei.php");
    // exit;

    // Refresh $user data after update
    $stmt = $pdo->prepare("SELECT * FROM users WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $profilePic = !empty($user['profile_picture']) ? htmlspecialchars($user['profile_picture']) : 'https://randomuser.me/api/portraits/men/32.jpg';
}

// Handle Security (Password Change) form submission
$passwordChangeMsg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password_submit'])) {
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Fetch current password hash (column is password_hash, not password)
    $stmt = $pdo->prepare("SELECT password_hash FROM users WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row && password_verify($current_password, $row['password_hash'])) {
        if (strlen($new_password) < 8) {
            $passwordChangeMsg = '<span class="text-red-600">New password must be at least 8 characters.</span>';
        } elseif ($new_password !== $confirm_password) {
            $passwordChangeMsg = '<span class="text-red-600">New passwords do not match.</span>';
        } else {
            $new_hash = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE users SET password_hash = ? WHERE user_id = ?");
            $stmt->execute([$new_hash, $user_id]);
            $passwordChangeMsg = '<span class="text-green-600">Password updated successfully.</span>';
        }
    } else {
        $passwordChangeMsg = '<span class="text-red-600">Current password is incorrect.</span>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - InvestKosovo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .sidebar {
            transition: all 0.3s ease;
        }
        .sidebar.collapsed {
            width: 70px;
        }
        .sidebar.collapsed .nav-text {
            display: none;
        }
        .sidebar.collapsed .logo-text {
            display: none;
        }
        .sidebar.collapsed .logo-icon {
            display: block;
        }
        .sidebar:not(.collapsed) .logo-icon {
            display: none;
        }
        .main-content {
            transition: margin-left 0.3s ease;
        }
        .profile-pic-upload {
            position: relative;
            display: inline-block;
        }
        .profile-pic-upload:hover .profile-overlay {
            opacity: 1;
        }
        .profile-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
            cursor: pointer;
        }
        .tab-content {
            display: none;
        }
        .tab-content.active {
            display: block;
            animation: fadeIn 0.3s ease;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @media (max-width: 768px) {
            .sidebar {
                position: absolute;
                z-index: 100;
                left: -250px;
            }
            .sidebar.active {
                left: 0;
            }
            .main-content {
                margin-left: 0 !important;
            }
        }
        .fafaroni{background-color: #2563eb; /* blue-700 */}
        .sasd{display:none;}
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div class="sidebar bg-blue-800 text-white w-64 fixed h-full">
            <div class="p-4 flex items-center">
                <div class="logo-icon hidden">
                    <i class="fas fa-landmark text-2xl"></i>
                </div>
                <div class="logo-text">
                    <h1 class="text-xl font-bold">InvestKosovo</h1>
                    <p class="text-xs text-blue-200">Investment Hub</p>
                </div>
                <button id="toggleSidebar" class="ml-auto text-white focus:outline-none">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
            <nav class="mt-6">
                <div class="px-4 py-2 hover:bg-blue-700">
                    <a href="dashboardi.php" class="flex items-center text-white">
                        <i class="fas fa-tachometer-alt mr-3"></i>
                        <span class="nav-text">Dashboard</span>
                    </a>
                </div>
                <div class="px-4 py-2 fafaroni">
                    <a href="profilei.php" class="flex items-center text-white">
                        <i class="fas fa-user mr-3"></i>
                        <span class="nav-text">Profile</span>
                    </a>
                </div>
                <div class="px-4 py-2 hover:bg-blue-700">
                    <a href="opportunity.php" class="flex items-center text-white">
                        <i class="fas fa-chart-line mr-3"></i>
                        <span class="nav-text">Opportunities</span>
                    </a>
                </div>
                <div class="px-4 py-2 hover:bg-blue-700">
                    <a href="reports.php" class="flex items-center text-white">
                        <i class="fas fa-file-alt mr-3"></i>
                        <span class="nav-text">Reports</span>
                    </a>
                </div>
                <div class="px-4 py-2 hover:bg-blue-700">
                    <a href="logout.php" class="flex items-center text-white">
                        <i class="fas fa-sign-out-alt mr-3"></i>
                        <span class="nav-text">Logout</span>
                    </a>
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="main-content flex-1 ml-64 overflow-auto">
            <!-- Top Navigation -->
            <header class="bg-white shadow-sm">
                <div class="flex justify-between items-center p-4">
                    <div class="flex items-center">
                        <button id="mobileMenuButton" class="md:hidden text-gray-600 focus:outline-none">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        <h1 class="text-xl font-semibold text-gray-800 ml-4">Profile Settings</h1>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <button class="text-gray-600 focus:outline-none">
                                <i class="fas fa-bell text-xl"></i>
                                <span class="absolute top-0 right-0 h-2 w-2 rounded-full bg-red-500"></span>
                            </button>
                        </div>
                        <div class="flex items-center">
                            <img src="<?php echo $profilePic; ?>" alt="User" class="h-8 w-8 rounded-full">
                            <span class="ml-2 text-gray-700"><?php echo htmlspecialchars($user['full_name']); ?></span>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Profile Content -->
            <main class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Left Column - Profile Card -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex flex-col items-center">
                            <div class="profile-pic-upload mb-4">
                                <img src="<?php echo $profilePic; ?>" alt="Profile" class="h-32 w-32 rounded-full object-cover border-4 border-blue-100">
                                <div class="profile-overlay">
                                    <i class="fas fa-camera text-white text-2xl"></i>
                                    <input type="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/*">
                                </div>
                            </div>
                            <h2 class="text-xl font-bold text-gray-800"><?php echo htmlspecialchars($user['full_name']); ?></h2>
                            <p class="text-blue-600 mb-2"><?php echo ucfirst(htmlspecialchars($user['user_type'])); ?></p>
                            <div class="flex space-x-2 mb-4"></div>
                            <div class="w-full border-t border-gray-200 pt-4">
                                <div class="flex justify-between mb-2">
                                    <span class="text-gray-500">Member Since</span>
                                    <span class="font-medium"><?php echo date('M Y', strtotime($user['created_at'])); ?></span>
                                </div>
                                <div class="flex justify-between mb-2">
                                    <span class="text-gray-500">Total Invested</span>
                                    <span class="font-medium"><?php echo isset($user['total_invested']) && $user['total_invested'] !== null ? '€' . number_format($user['total_invested'], 2) : 'N/A'; ?></span>
                                </div>
                                <div class="flex justify-between mb-2">
                                    <span class="text-gray-500">Total Value</span>
                                    <span class="font-medium">
                                        <?php echo isset($user['total_value']) && $user['total_value'] !== null ? '€' . number_format($user['total_value'], 2) : 'N/A'; ?>
                                    </span>
                                </div>
                                <div class="flex justify-between mb-2">
                                    <span class="text-gray-500">Investments Made</span>
                                    <span class="font-medium">
                                        <?php echo isset($user['investments_made']) ? (int)$user['investments_made'] : '0'; ?>
                                    </span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Risk Profile</span>
                                    <span class="font-medium"><?php echo !empty($user['risk_profile']) ? htmlspecialchars($user['risk_profile']) : 'N/A'; ?></span>
                                </div>
                            </div>
                            <span class="px-2 py-1 bg-green-100 text-green-600 text-xs rounded-full">Active</span>
                            <div class="w-full mt-6">
                                <h3 class="text-lg font-semibold text-gray-800 mb-3">Contact Information</h3>
                                <div class="space-y-2">
                                    <div class="flex items-center">
                                        <i class="fas fa-envelope text-gray-400 mr-2"></i>
                                        <span><?php echo htmlspecialchars($user['email']); ?></span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-phone text-gray-400 mr-2"></i>
                                        <span><?php echo !empty($user['phone']) ? htmlspecialchars($user['phone']) : 'N/A'; ?></span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-map-marker-alt text-gray-400 mr-2"></i>
                                        <span>
                                            <?php
                                                $city = !empty($user['city']) ? htmlspecialchars($user['city']) : '';
                                                $country = !empty($user['country']) ? htmlspecialchars($user['country']) : '';
                                                echo trim($city . ($city && $country ? ', ' : '') . $country) ?: 'N/A';
                                            ?>
                                        </span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-home text-gray-400 mr-2"></i>
                                        <span><?php echo !empty($user['address']) ? htmlspecialchars($user['address']) : 'N/A'; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Right Column - Tabs Content -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-lg shadow overflow-hidden">
                            <!-- Tabs Navigation -->
                            <div class="border-b border-gray-200">
                                <nav class="flex -mb-px">
                                    <button data-tab="personal" class="tab-button py-4 px-6 text-center border-b-2 font-medium text-sm border-blue-500 text-blue-600">
                                        Personal Info
                                    </button>
                                    <button data-tab="company" class="tab-button py-4 px-6 text-center border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                                        Company Profile
                                    </button>
                                    <button data-tab="security" class="tab-button py-4 px-6 text-center border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                                        Security
                                    </button>
                                    <button data-tab="preferences" class="tab-button py-4 px-6 text-center border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                                        Preferences
                                    </button>
                                </nav>
                            </div>
                            
                            <!-- Tab Contents -->
                            <div class="p-6">
                                <!-- Personal Info Tab -->
                                <div id="personal" class="tab-content active">
                                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Personal Information</h3>
                                    <form method="post" enctype="multipart/form-data">
                                        <div class="flex flex-col items-center mb-4">
                                            <div class="profile-pic-upload mb-2">
                                                <img src="<?php echo $profilePic; ?>" alt="Profile" class="h-24 w-24 rounded-full object-cover border-2 border-blue-100">
                                                <div class="profile-overlay">
                                                    <i class="fas fa-camera text-white text-2xl"></i>
                                                    <input type="file" name="profile_picture" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/*">
                                                </div>
                                            </div>
                                            <span class="text-xs text-gray-500">Click to change profile picture</span>
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                                                <input type="text" name="first_name" value="<?php echo htmlspecialchars(explode(' ', $user['full_name'])[0]); ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                                                <input type="text" name="last_name" value="<?php echo htmlspecialchars(explode(' ', $user['full_name'])[1] ?? ''); ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                            <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        </div>
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                                            <input type="tel" name="phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        </div>
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                                            <input type="text" name="address" value="<?php echo htmlspecialchars($user['address'] ?? ''); ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">City</label>
                                                <input type="text" name="city" value="<?php echo htmlspecialchars($user['city'] ?? ''); ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Country</label>
                                                <select name="country" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                    <?php
                                                        $countries = ['Kosovo', 'Albania', 'North Macedonia', 'Montenegro', 'Serbia'];
                                                        foreach ($countries as $country) {
                                                            $selected = (isset($user['country']) && $user['country'] == $country) ? 'selected' : '';
                                                            echo "<option $selected>$country</option>";
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="flex justify-end mt-6">
                                            <button type="button" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                Cancel
                                            </button>
                                            <button type="submit" name="personal_info_submit" class="ml-3 px-4 py-2 border border-transparent rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                Save Changes
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                
                                <!-- Company Profile Tab -->
                                <div id="company" class="tab-content">
                                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Company Information</h3>
                                    <?php
                                    $companyMsg = '';
                                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['company_profile_submit'])) {
                                        $company_name = trim($_POST['company_name'] ?? '');
                                        $company_desc = trim($_POST['company_desc'] ?? '');
                                        $company_website = trim($_POST['company_website'] ?? '');
                                        $company_size = $_POST['company_size'] ?? '';
                                        $company_industry = $_POST['company_industry'] ?? '';
                                        // For demo, use investment_type for industry and location for website
                                        if ($company_name && $company_size && $company_industry) {
                                            // Check if company profile exists
                                            $stmt = $pdo->prepare("SELECT company_id FROM company_profiles WHERE user_id = ?");
                                            $stmt->execute([$user_id]);
                                            if ($stmt->fetch()) {
                                                // Update
                                                $stmt = $pdo->prepare("UPDATE company_profiles SET name=?, size=?, investment_type=?, location=? WHERE user_id=?");
                                                $stmt->execute([$company_name, $company_size, $company_industry, $company_website, $user_id]);
                                                $companyMsg = '<span class="text-green-600">Company profile updated.</span>';
                                            } else {
                                                // Insert
                                                $stmt = $pdo->prepare("INSERT INTO company_profiles (user_id, name, size, investment_type, location) VALUES (?, ?, ?, ?, ?)");
                                                $stmt->execute([$user_id, $company_name, $company_size, $company_industry, $company_website]);
                                                $companyMsg = '<span class="text-green-600">Company profile created.</span>';
                                            }
                                            // Refresh $company
                                            $stmt = $pdo->prepare("SELECT * FROM company_profiles WHERE user_id = ?");
                                            $stmt->execute([$user_id]);
                                            $company = $stmt->fetch(PDO::FETCH_ASSOC);
                                        } else {
                                            $companyMsg = '<span class="text-red-600">Please fill in all required fields.</span>';
                                        }
                                    }
                                    ?>
                                    <?php if (!empty($companyMsg)) { echo '<div class="mb-4">' . $companyMsg . '</div>'; } ?>
                                    <form method="post">
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Company Name</label>
                                            <input type="text" name="company_name" value="<?php echo htmlspecialchars($company['name'] ?? ''); ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        </div>
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Company Description</label>
                                            <textarea rows="3" name="company_desc" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"><?php echo htmlspecialchars($company['investment_type'] ?? ''); ?></textarea>
                                        </div>
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Company Website</label>
                                            <input type="url" name="company_website" value="<?php echo htmlspecialchars($company['location'] ?? ''); ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Company Size</label>
                                                <select name="company_size" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                    <option value="micro"<?php echo ($company['size']=='micro')?' selected':''; ?>>Small (1-10 employees)</option>
                                                    <option value="small"<?php echo ($company['size']=='small')?' selected':''; ?>>Medium (11-50 employees)</option>
                                                    <option value="medium"<?php echo ($company['size']=='medium')?' selected':''; ?>>Large (51-200 employees)</option>
                                                    <option value="large"<?php echo ($company['size']=='large')?' selected':''; ?>>Enterprise (200+ employees)</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Industry</label>
                                                <select name="company_industry" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                    <option value="Investment Management"<?php echo ($company['investment_type']=='Investment Management')?' selected':''; ?>>Investment Management</option>
                                                    <option value="Venture Capital"<?php echo ($company['investment_type']=='Venture Capital')?' selected':''; ?>>Venture Capital</option>
                                                    <option value="Private Equity"<?php echo ($company['investment_type']=='Private Equity')?' selected':''; ?>>Private Equity</option>
                                                    <option value="Angel Investing"<?php echo ($company['investment_type']=='Angel Investing')?' selected':''; ?>>Angel Investing</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Company Logo</label>
                                            <div class="mt-1 flex items-center">
                                                <span class="inline-block h-12 w-12 rounded-full overflow-hidden bg-gray-100">
                                                    <img src="https://via.placeholder.com/48" alt="Company Logo" class="h-full w-full">
                                                </span>
                                                <button type="button" class="ml-5 bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                    Change
                                                </button>
                                            </div>
                                        </div>
                                        <div class="flex justify-end mt-6">
                                            <button type="button" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                Cancel
                                            </button>
                                            <button type="submit" name="company_profile_submit" class="ml-3 px-4 py-2 border border-transparent rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                Save Changes
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                
                                <!-- Security Tab -->
                                <div id="security" class="tab-content">
                                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Security Settings</h3>
                                    <?php if (!empty($passwordChangeMsg)) { echo '<div class="mb-4">' . $passwordChangeMsg . '</div>'; } ?>
                                    <form method="post" onsubmit="return validatePasswordChange();">
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                                            <input type="password" name="current_password" placeholder="Enter current password" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        </div>
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                                            <input type="password" id="new_password" name="new_password" placeholder="Enter new password" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <p class="mt-1 text-xs text-gray-500">Password must be at least 8 characters long</p>
                                            <span id="password-length-error" class="text-red-600 text-xs hidden">Password must be at least 8 characters.</span>
                                        </div>
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                                            <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm new password" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <span id="password-match-error" class="text-red-600 text-xs hidden">Passwords do not match.</span>
                                        </div>
                                        <div class="mb-6">
                                            <label class="flex items-center">
                                                <input type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                                <span class="ml-2 text-sm text-gray-700">Enable Two-Factor Authentication</span>
                                            </label>
                                        </div>
                                        <div class="flex justify-end mt-6">
                                            <button type="button" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                Cancel
                                            </button>
                                            <button type="submit" name="change_password_submit" class="ml-3 px-4 py-2 border border-transparent rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                Update Password
                                            </button>
                                        </div>
                                    </form>
                                    <script>
                                    function validatePasswordChange() {
                                        var newPass = document.getElementById('new_password').value;
                                        var confirmPass = document.getElementById('confirm_password').value;
                                        var valid = true;
                                        document.getElementById('password-length-error').classList.add('hidden');
                                        document.getElementById('password-match-error').classList.add('hidden');
                                        if (newPass.length < 8) {
                                            document.getElementById('password-length-error').classList.remove('hidden');
                                            valid = false;
                                        }
                                        if (newPass !== confirmPass) {
                                            document.getElementById('password-match-error').classList.remove('hidden');
                                            valid = false;
                                        }
                                        return valid;
                                    }
                                    </script>
                                </div>
                                
                                <!-- Preferences Tab -->
                                <div id="preferences" class="tab-content">
                                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Notification Preferences</h3>
                                    <form>
                                        <div class="mb-6">
                                            <h4 class="text-md font-medium text-gray-700 mb-3">Email Notifications</h4>
                                            <div class="space-y-3">
                                                <label class="flex items-center">
                                                    <input type="checkbox" checked class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                                    <span class="ml-2 text-sm text-gray-700">Investment opportunities</span>
                                                </label>
                                                <label class="flex items-center">
                                                    <input type="checkbox" checked class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                                    <span class="ml-2 text-sm text-gray-700">Market updates</span>
                                                </label>
                                                <label class="flex items-center">
                                                    <input type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                                    <span class="ml-2 text-sm text-gray-700">Newsletters</span>
                                                </label>
                                                <label class="flex items-center">
                                                    <input type="checkbox" checked class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                                    <span class="ml-2 text-sm text-gray-700">Account activity</span>
                                                </label>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-6">
                                            <h4 class="text-md font-medium text-gray-700 mb-3">Push Notifications</h4>
                                            <div class="space-y-3">
                                                <label class="flex items-center">
                                                    <input type="checkbox" checked class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                                    <span class="ml-2 text-sm text-gray-700">Investment alerts</span>
                                                </label>
                                                <label class="flex items-center">
                                                    <input type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                                    <span class="ml-2 text-sm text-gray-700">Price changes</span>
                                                </label>
                                                <label class="flex items-center">
                                                    <input type="checkbox" checked class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                                    <span class="ml-2 text-sm text-gray-700">Transaction confirmations</span>
                                                </label>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-6">
                                            <h4 class="text-md font-medium text-gray-700 mb-3">Investment Preferences</h4>
                                            <div class="space-y-3">
                                                <label class="flex items-center">
                                                    <input type="checkbox" checked class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                                    <span class="ml-2 text-sm text-gray-700">Technology sector</span>
                                                </label>
                                                <label class="flex items-center">
                                                    <input type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                                    <span class="ml-2 text-sm text-gray-700">Real estate</span>
                                                </label>
                                                <label class="flex items-center">
                                                    <input type="checkbox" checked class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                                    <span class="ml-2 text-sm text-gray-700">Renewable energy</span>
                                                </label>
                                                <label class="flex items-center">
                                                    <input type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                                    <span class="ml-2 text-sm text-gray-700">Agriculture</span>
                                                </label>
                                            </div>
                                        </div>
                                        
                                        <div class="flex justify-end mt-6">
                                            <button type="button" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                Reset to Defaults
                                            </button>
                                            <button type="submit" class="ml-3 px-4 py-2 border border-transparent rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                Save Preferences
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Verification Status -->
                        <div class="bg-white rounded-lg sasd shadow mt-6 p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Verification Status</h3>
                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center mr-3">
                                            <i class="fas fa-check text-green-600"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-medium">Email Verification</h4>
                                            <p class="text-sm text-gray-500">Verified on Jan 15, 2022</p>
                                        </div>
                                    </div>
                                    <span class="px-3 py-1 bg-green-100 text-green-800 text-xs rounded-full">Completed</span>
                                </div>
                                
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center mr-3">
                                            <i class="fas fa-check text-green-600"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-medium">Phone Verification</h4>
                                            <p class="text-sm text-gray-500">Verified on Jan 16, 2022</p>
                                        </div>
                                    </div>
                                    <span class="px-3 py-1 bg-green-100 text-green-800 text-xs rounded-full">Completed</span>
                                </div>
                                
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 rounded-full bg-yellow-100 flex items-center justify-center mr-3">
                                            <i class="fas fa-exclamation text-yellow-600"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-medium">Identity Verification</h4>
                                            <p class="text-sm text-gray-500">Pending review</p>
                                        </div>
                                    </div>
                                    <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">In Progress</span>
                                </div>
                                
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 rounded-full bg-gray-100 flex items-center justify-center mr-3">
                                            <i class="fas fa-times text-gray-500"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-medium">Proof of Address</h4>
                                            <p class="text-sm text-gray-500">Not submitted</p>
                                        </div>
                                    </div>
                                    <span class="px-3 py-1 bg-gray-100 text-gray-800 text-xs rounded-full">Not Started</span>
                                </div>
                            </div>
                            
                            <div class="mt-6">
                                <button class="w-full px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    Complete Verification
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        // Toggle sidebar
        document.getElementById('toggleSidebar').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('collapsed');
            document.querySelector('.main-content').classList.toggle('ml-64');
            document.querySelector('.main-content').classList.toggle('ml-20');
        });

        // Mobile menu toggle
        document.getElementById('mobileMenuButton').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('active');
        });

        // Tab functionality
        document.querySelectorAll('.tab-button').forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons and add to clicked one
                document.querySelectorAll('.tab-button').forEach(btn => {
                    btn.classList.remove('border-blue-500', 'text-blue-600');
                    btn.classList.add('border-transparent', 'text-gray-500');
                });
                this.classList.remove('border-transparent', 'text-gray-500');
                this.classList.add('border-blue-500', 'text-blue-600');
                
                // Hide all tab contents and show the selected one
                const tabId = this.getAttribute('data-tab');
                document.querySelectorAll('.tab-content').forEach(tab => {
                    tab.classList.remove('active');
                });
                document.getElementById(tabId).classList.add('active');
            });
        });

        // Profile picture upload preview (instant update)
        const profilePicInput = document.querySelector('.profile-pic-upload input[type="file"]');
        const profilePicImg = document.querySelector('.profile-pic-upload img');
        profilePicInput.addEventListener('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    profilePicImg.src = event.target.result;
                }
                reader.readAsDataURL(e.target.files[0]);
            }
        });
    </script>
</body>
</html>