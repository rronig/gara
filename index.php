<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KosovaOne | Unified Public Services Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<header class="gradient-bg text-white sticky top-0 z-50 shadow-lg">
        <div class="container mx-auto px-4 py-3">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-landmark text-2xl"></i>
                    <h1 class="text-2xl font-bold">Kosova<span class="text-blue-200">One</span></h1>
                </div>
                <nav class="hidden md:flex space-x-8">
                    <a href="#services" class="animated-underline hover:text-blue-200">Services</a>
                    <a href="#business" class="animated-underline hover:text-blue-200">Business</a>
                    <a href="#data" class="animated-underline hover:text-blue-200">Open Data</a>
                    <a href="#engagement" class="animated-underline hover:text-blue-200">Engagement</a>
                    <a href="#about" class="animated-underline hover:text-blue-200">About</a>
                </nav>
                <div class="flex items-center space-x-4">
                    <button class="bg-white text-blue-600 px-4 py-2 rounded-full font-medium hover:bg-blue-50 transition">
                        Sign In
                    </button>
                    <button class="md:hidden text-2xl" id="mobile-menu-button">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Mobile Menu -->
        <div class="md:hidden hidden bg-blue-900" id="mobile-menu">
            <div class="container mx-auto px-4 py-3 flex flex-col space-y-3">
                <a href="#services" class="py-2 border-b border-blue-800">Services</a>
                <a href="#business" class="py-2 border-b border-blue-800">Business</a>
                <a href="#data" class="py-2 border-b border-blue-800">Open Data</a>
                <a href="#engagement" class="py-2 border-b border-blue-800">Engagement</a>
                <a href="#about" class="py-2">About</a>
            </div>
        </div>
    </header>
    <footer class="bg-gray-900 text-white pt-12 pb-6">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <i class="fas fa-landmark text-2xl"></i>
                        <h3 class="text-xl font-bold">Kosova<span class="text-blue-400">One</span></h3>
                    </div>
                    <p class="text-gray-400 mb-4">
                        The unified platform for government services, business support, open data, and civic engagement.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <i class="fab fa-github"></i>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h4 class="text-lg font-bold mb-4">Services</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition">All Services</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">ID & Documentation</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Health & Social Care</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Education</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Housing & Property</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-lg font-bold mb-4">Resources</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Help Center</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">API Documentation</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Developer Portal</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Open Data Catalog</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Accessibility</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-lg font-bold mb-4">Legal</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Privacy Policy</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Terms of Service</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Cookie Policy</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Data Protection</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Transparency Report</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="pt-6 border-t border-gray-800 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400 text-sm mb-4 md:mb-0">
                    &copy; 2023 KosovaOne. A government digital initiative.
                </p>
                <div class="flex space-x-6">
                    <a href="#" class="text-gray-400 hover:text-white transition text-sm">Contact Us</a>
                    <a href="#" class="text-gray-400 hover:text-white transition text-sm">Feedback</a>
                    <a href="#" class="text-gray-400 hover:text-white transition text-sm">Sitemap</a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>