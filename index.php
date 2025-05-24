<?php include_once('config.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InvestKosovo Hub | Gateway to Investment Opportunities</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8fafc;
        }
        
        .hero-gradient {
            background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 50%, #3b82f6 100%);
        }
        
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        .sector-icon {
            transition: all 0.3s ease;
        }
        
        .sector-card:hover .sector-icon {
            transform: scale(1.1);
            color: #2563eb;
        }
        
        .map-container {
            height: 400px;
            background-color: #e2e8f0;
            border-radius: 1rem;
            overflow: hidden;
        }
        
        .animated-underline {
            position: relative;
            display: inline-block;
        }
        
        .animated-underline::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 2px;
            bottom: -2px;
            left: 0;
            background-color: #2563eb;
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }
        
        .animated-underline:hover::after {
            transform: scaleX(1);
        }
        
        .testimonial-card {
            transition: all 0.3s ease;
        }
        
        .testimonial-card:hover {
            border-color: #2563eb;
        }
        
        .stat-card {
            transition: all 0.3s ease;
        }
        
        .stat-card:hover {
            background-color: #eff6ff;
        }
    </style>
</head>
<body class="text-gray-800">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <img class="h-16 w-auto" src="kosova.png" alt="InvestKosovo Logo">
                        <span class="ml-2 text-xl font-bold text-blue-800">InvestKosovo Hub</span>
                    </div>
                </div>
                <div class="hidden md:ml-6 md:flex md:items-center md:space-x-8">
                    <a href="#opportunities" class="animated-underline text-gray-700 hover:text-blue-800 px-3 py-2 text-sm font-medium">Opportunities</a>
                    <a href="#sectors" class="animated-underline text-gray-700 hover:text-blue-800 px-3 py-2 text-sm font-medium">Key Sectors</a>
                    <a href="#benefits" class="animated-underline text-gray-700 hover:text-blue-800 px-3 py-2 text-sm font-medium">Benefits</a>
                    <a href="#testimonials" class="animated-underline text-gray-700 hover:text-blue-800 px-3 py-2 text-sm font-medium">Success Stories</a>
                    <a href="#contact" class="animated-underline text-gray-700 hover:text-blue-800 px-3 py-2 text-sm font-medium">Contact</a>
                    <a href="signin.php" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-300">
                        Investor Portal <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
                <div class="-mr-2 flex items-center md:hidden">
                    <button type="button" id="mobile-menu-button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none">
                        <span class="sr-only">Open main menu</span>
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Mobile menu -->
        <div id="mobile-menu" class="hidden md:hidden">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <a href="#opportunities" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-800 hover:bg-gray-50">Opportunities</a>
                <a href="#sectors" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-800 hover:bg-gray-50">Key Sectors</a>
                <a href="#benefits" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-800 hover:bg-gray-50">Benefits</a>
                <a href="#testimonials" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-800 hover:bg-gray-50">Success Stories</a>
                <a href="#contact" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-800 hover:bg-gray-50">Contact</a>
                <button class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-base font-medium mt-2 transition duration-300">
                    Investor Portal <i class="fas fa-arrow-right ml-1"></i>
                </button>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-gradient text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 md:py-32">
            <div class="md:flex md:items-center md:justify-between">
                <div class="md:w-1/2 mb-10 md:mb-0">
                    <h1 class="text-4xl md:text-5xl font-bold leading-tight mb-6">
                        Unlock Kosovo's <span class="text-blue-200">Investment Potential</span>
                    </h1>
                    <p class="text-xl text-blue-100 mb-8">
                        Your gateway to business opportunities, incentives, and growth in one of Europe's most dynamic emerging markets.
                    </p>
                    <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                        <button class="bg-white text-blue-800 hover:bg-blue-100 px-6 py-3 rounded-md font-medium transition duration-300">
                            Explore Opportunities <i class="fas fa-search ml-2"></i>
                        </button>
                        <button class="bg-transparent border-2 border-white hover:bg-white hover:text-blue-800 px-6 py-3 rounded-md font-medium transition duration-300">
                            Watch Overview <i class="fas fa-play-circle ml-2"></i>
                        </button>
                    </div>
                </div>
                <div class="md:w-1/2 relative">
                    <div class="bg-white bg-opacity-20 backdrop-filter backdrop-blur-lg rounded-xl p-6 shadow-xl">
                        <h3 class="text-xl font-semibold mb-4">Quick Investment Calculator</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium mb-1">Investment Sector</label>
                                <select class="w-full px-4 py-2 rounded-md bg-white bg-opacity-20 border border-white border-opacity-30 text-white">
                                    <option class="text-black">Manufacturing</option>
                                    <option class="text-black">Information Technology</option>
                                    <option class="text-black">Energy</option>
                                    <option class="text-black">Agriculture</option>
                                    <option class="text-black">Tourism</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1">Investment Amount (€)</label>
                                <input type="range" min="10000" max="1000000" step="10000" value="250000" class="w-full">
                                <div class="flex justify-between text-xs">
                                    <span>€10,000</span>
                                    <span>€1,000,000</span>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1">Expected Tax Benefits</label>
                                <div class="bg-white bg-opacity-30 px-4 py-2 rounded-md">
                                    <span class="font-bold">€15,000 - €45,000</span> annually
                                </div>
                            </div>
                            <button class="w-full bg-white text-blue-800 hover:bg-blue-100 px-4 py-2 rounded-md font-medium transition duration-300">
                                Calculate Full Benefits <i class="fas fa-calculator ml-2"></i>
                            </button>
                        </div>
                    </div>
                    <div class="absolute -bottom-6 -right-6 bg-yellow-400 text-blue-900 px-4 py-2 rounded-lg shadow-lg font-bold">
                        <i class="fas fa-bolt mr-2"></i> Fast-Track Available
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="bg-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="stat-card bg-gray-50 p-6 rounded-xl border border-gray-200">
                    <div class="text-blue-600 text-3xl mb-2">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900">6.2%</h3>
                    <p class="text-gray-600">Average GDP Growth (2015-2022)</p>
                </div>
                <div class="stat-card bg-gray-50 p-6 rounded-xl border border-gray-200">
                    <div class="text-blue-600 text-3xl mb-2">
                        <i class="fas fa-euro-sign"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900">€1.2B</h3>
                    <p class="text-gray-600">FDI Inflows in 2022</p>
                </div>
                <div class="stat-card bg-gray-50 p-6 rounded-xl border border-gray-200">
                    <div class="text-blue-600 text-3xl mb-2">
                        <i class="fas fa-building"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900">250+</h3>
                    <p class="text-gray-600">International Companies</p>
                </div>
                <div class="stat-card bg-gray-50 p-6 rounded-xl border border-gray-200">
                    <div class="text-blue-600 text-3xl mb-2">
                        <i class="fas fa-percentage"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900">10%</h3>
                    <p class="text-gray-600">Corporate Tax Rate</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Opportunities Section -->
    <section id="opportunities" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Investment Opportunities</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Discover curated investment projects with high growth potential across Kosovo's most promising sectors
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Opportunity Card 1 -->
                <div class="card-hover bg-white rounded-xl overflow-hidden shadow-md transition duration-300">
                    <div class="h-48 bg-blue-600 relative overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" 
                             alt="Renewable Energy" class="w-full h-full object-cover">
                        <div class="absolute top-4 right-4 bg-yellow-400 text-blue-900 px-3 py-1 rounded-full text-xs font-bold">
                            <i class="fas fa-bolt mr-1"></i> High Priority
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-xl font-bold text-gray-900">Solar Power Plant</h3>
                            <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">€25M</span>
                        </div>
                        <p class="text-gray-600 mb-4">50MW photovoltaic plant in Kosovo's sun-rich southern region</p>
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="text-sm text-gray-500"><i class="fas fa-map-marker-alt mr-1"></i> Prizren</span>
                            </div>
                            <button class="text-blue-600 hover:text-blue-800 font-medium">
                                View Details <i class="fas fa-arrow-right ml-1"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Opportunity Card 2 -->
                <div class="card-hover bg-white rounded-xl overflow-hidden shadow-md transition duration-300">
                    <div class="h-48 bg-blue-600 relative overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1532619675605-1ede56544831?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" 
                             alt="IT Park" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-xl font-bold text-gray-900">Tech Innovation Hub</h3>
                            <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">€15M</span>
                        </div>
                        <p class="text-gray-600 mb-4">State-of-the-art technology park with incentives for IT companies</p>
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="text-sm text-gray-500"><i class="fas fa-map-marker-alt mr-1"></i> Prishtina</span>
                            </div>
                            <button class="text-blue-600 hover:text-blue-800 font-medium">
                                View Details <i class="fas fa-arrow-right ml-1"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Opportunity Card 3 -->
                <div class="card-hover bg-white rounded-xl overflow-hidden shadow-md transition duration-300">
                    <div class="h-48 bg-blue-600 relative overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1449300079323-02e209d9d3a4?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" 
                             alt="Agro Processing" class="w-full h-full object-cover">
                        <div class="absolute top-4 right-4 bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-xs font-bold">
                            <i class="fas fa-star mr-1"></i> New
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-xl font-bold text-gray-900">Organic Food Processing</h3>
                            <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">€8M</span>
                        </div>
                        <p class="text-gray-600 mb-4">Modern facility for processing Kosovo's high-quality organic produce</p>
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="text-sm text-gray-500"><i class="fas fa-map-marker-alt mr-1"></i> Ferizaj</span>
                            </div>
                            <button class="text-blue-600 hover:text-blue-800 font-medium">
                                View Details <i class="fas fa-arrow-right ml-1"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-12">
                <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-md font-medium transition duration-300">
                    View All Opportunities <i class="fas fa-arrow-right ml-2"></i>
                </button>
            </div>
        </div>
    </section>

    <!-- Key Sectors Section -->
    <section id="sectors" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Key Investment Sectors</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Kosovo offers diverse opportunities across high-growth industries with competitive advantages
                </p>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Sector Card 1 -->
                <div class="sector-card bg-white rounded-xl p-6 border border-gray-200 hover:border-blue-300 transition duration-300 cursor-pointer">
                    <div class="sector-icon text-blue-600 text-4xl mb-4">
                        <i class="fas fa-laptop-code"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Information Technology</h3>
                    <p class="text-gray-600 mb-4">
                        Thriving tech ecosystem with skilled, English-speaking workforce and competitive costs
                    </p>
                    <div class="text-blue-600 font-medium">
                        Explore <i class="fas fa-arrow-right ml-1"></i>
                    </div>
                </div>
                
                <!-- Sector Card 2 -->
                <div class="sector-card bg-white rounded-xl p-6 border border-gray-200 hover:border-blue-300 transition duration-300 cursor-pointer">
                    <div class="sector-icon text-blue-600 text-4xl mb-4">
                        <i class="fas fa-solar-panel"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Renewable Energy</h3>
                    <p class="text-gray-600 mb-4">
                        Abundant solar, wind, and hydro resources with government incentives for green energy
                    </p>
                    <div class="text-blue-600 font-medium">
                        Explore <i class="fas fa-arrow-right ml-1"></i>
                    </div>
                </div>
                
                <!-- Sector Card 3 -->
                <div class="sector-card bg-white rounded-xl p-6 border border-gray-200 hover:border-blue-300 transition duration-300 cursor-pointer">
                    <div class="sector-icon text-blue-600 text-4xl mb-4">
                        <i class="fas fa-utensils"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Agribusiness</h3>
                    <p class="text-gray-600 mb-4">
                        Fertile land, organic potential, and growing demand for high-quality food products
                    </p>
                    <div class="text-blue-600 font-medium">
                        Explore <i class="fas fa-arrow-right ml-1"></i>
                    </div>
                </div>
                
                <!-- Sector Card 4 -->
                <div class="sector-card bg-white rounded-xl p-6 border border-gray-200 hover:border-blue-300 transition duration-300 cursor-pointer">
                    <div class="sector-icon text-blue-600 text-4xl mb-4">
                        <i class="fas fa-hotel"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Tourism</h3>
                    <p class="text-gray-600 mb-4">
                        Untapped potential in cultural, adventure, and mountain tourism with growing visitor numbers
                    </p>
                    <div class="text-blue-600 font-medium">
                        Explore <i class="fas fa-arrow-right ml-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section id="benefits" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Why Invest in Kosovo?</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Competitive advantages that make Kosovo an attractive investment destination
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <div class="bg-white rounded-xl p-8 shadow-md mb-8">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Strategic Location</h3>
                        <div class="map-container flex items-center justify-center">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1504723.988982643!2d19.582584950376067!3d42.55711810215074!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x13537af354bf7df1%3A0xbfffeedfabc31791!2sKosovo!5e0!3m2!1sen!2s!4v1748086164375!5m2!1sen!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-xl p-8 shadow-md">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Business-Friendly Environment</h3>
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <div class="bg-blue-100 p-2 rounded-full mr-4">
                                    <i class="fas fa-euro-sign text-blue-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-900">10% Corporate Tax Rate</h4>
                                    <p class="text-gray-600 text-sm">One of the lowest in Europe with additional sector incentives</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="bg-blue-100 p-2 rounded-full mr-4">
                                    <i class="fas fa-clock text-blue-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-900">Fast Business Registration</h4>
                                    <p class="text-gray-600 text-sm">Company setup in as little as 3 working days</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="bg-blue-100 p-2 rounded-full mr-4">
                                    <i class="fas fa-file-signature text-blue-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-900">Stable Legal Framework</h4>
                                    <p class="text-gray-600 text-sm">EU-compatible legislation with investment protection</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div>
                    <div class="bg-white rounded-xl p-8 shadow-md mb-8">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Cost Advantages</h3>
                        <div class="space-y-6">
                            <div>
                                <h4 class="font-medium text-gray-900 mb-2">Competitive Operational Costs</h4>
                                <div class="w-full bg-gray-200 rounded-full h-4">
                                    <div class="bg-blue-600 h-4 rounded-full" style="width: 70%"></div>
                                    <div class="text-xs mt-1 text-gray-600">70% lower than Western Europe</div>
                                </div>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900 mb-2">Affordable Skilled Labor</h4>
                                <div class="w-full bg-gray-200 rounded-full h-4">
                                    <div class="bg-blue-600 h-4 rounded-full" style="width: 60%"></div>
                                    <div class="text-xs mt-1 text-gray-600">60% lower IT salaries than EU average</div>
                                </div>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900 mb-2">Low Energy Costs</h4>
                                <div class="w-full bg-gray-200 rounded-full h-4">
                                    <div class="bg-blue-600 h-4 rounded-full" style="width: 40%"></div>
                                    <div class="text-xs mt-1 text-gray-600">40% lower industrial electricity rates</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-xl p-8 shadow-md">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Workforce Advantages</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-blue-50 p-4 rounded-lg">
                                <div class="text-blue-600 text-2xl mb-2">
                                    <i class="fas fa-graduation-cap"></i>
                                </div>
                                <h4 class="font-medium text-gray-900">Young Population</h4>
                                <p class="text-gray-600 text-sm">Median age of 29 with strong technical education</p>
                            </div>
                            <div class="bg-blue-50 p-4 rounded-lg">
                                <div class="text-blue-600 text-2xl mb-2">
                                    <i class="fas fa-language"></i>
                                </div>
                                <h4 class="font-medium text-gray-900">Multilingual</h4>
                                <p class="text-gray-600 text-sm">High English proficiency + German/Italian speakers</p>
                            </div>
                            <div class="bg-blue-50 p-4 rounded-lg">
                                <div class="text-blue-600 text-2xl mb-2">
                                    <i class="fas fa-users"></i>
                                </div>
                                <h4 class="font-medium text-gray-900">Tech-Savvy</h4>
                                <p class="text-gray-600 text-sm">5,000+ IT graduates annually</p>
                            </div>
                            <div class="bg-blue-50 p-4 rounded-lg">
                                <div class="text-blue-600 text-2xl mb-2">
                                    <i class="fas fa-brain"></i>
                                </div>
                                <h4 class="font-medium text-gray-900">Innovative</h4>
                                <p class="text-gray-600 text-sm">Growing startup ecosystem</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Success Stories</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Hear from international investors who have successfully established businesses in Kosovo
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="testimonial-card bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition duration-300">
                    <div class="flex items-center mb-4">
                        <img class="w-12 h-12 rounded-full mr-4" src="https://randomuser.me/api/portraits/women/43.jpg" alt="Sarah Johnson">
                        <div>
                            <h4 class="font-bold text-gray-900">Sarah Johnson</h4>
                            <p class="text-gray-600 text-sm">CEO, TechSolutions Europe</p>
                        </div>
                    </div>
                    <p class="text-gray-700 mb-4 italic">
                        "Setting up our regional IT hub in Prishtina was the best decision we made. The talent pool exceeded our expectations, and the cost savings allowed us to scale rapidly."
                    </p>
                    <div class="flex items-center text-yellow-400">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <span class="text-gray-600 ml-2 text-sm">5/5</span>
                    </div>
                </div>
                
                <!-- Testimonial 2 -->
                <div class="testimonial-card bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition duration-300">
                    <div class="flex items-center mb-4">
                        <img class="w-12 h-12 rounded-full mr-4" src="https://randomuser.me/api/portraits/men/32.jpg" alt="Michael Bauer">
                        <div>
                            <h4 class="font-bold text-gray-900">Michael Bauer</h4>
                            <p class="text-gray-600 text-sm">Managing Director, GreenEnergy AG</p>
                        </div>
                    </div>
                    <p class="text-gray-700 mb-4 italic">
                        "The solar energy potential in Kosovo is outstanding. With government support and excellent solar irradiation levels, our 20MW plant is performing above projections."
                    </p>
                    <div class="flex items-center text-yellow-400">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                        <span class="text-gray-600 ml-2 text-sm">4.5/5</span>
                    </div>
                </div>
                
                <!-- Testimonial 3 -->
                <div class="testimonial-card bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition duration-300">
                    <div class="flex items-center mb-4">
                        <img class="w-12 h-12 rounded-full mr-4" src="https://randomuser.me/api/portraits/women/65.jpg" alt="Elena Ricci">
                        <div>
                            <h4 class="font-bold text-gray-900">Elena Ricci</h4>
                            <p class="text-gray-600 text-sm">Founder, Organic Delights</p>
                        </div>
                    </div>
                    <p class="text-gray-700 mb-4 italic">
                        "Kosovo's organic agriculture sector is a hidden gem. We've been able to source premium raw materials at competitive prices for our European markets."
                    </p>
                    <div class="flex items-center text-yellow-400">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <span class="text-gray-600 ml-2 text-sm">5/5</span>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-12">
                <button class="bg-white border border-blue-600 text-blue-600 hover:bg-blue-50 px-6 py-3 rounded-md font-medium transition duration-300">
                    View More Success Stories <i class="fas fa-arrow-right ml-2"></i>
                </button>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-blue-800 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold mb-6">Ready to Explore Kosovo's Opportunities?</h2>
            <p class="text-xl text-blue-200 mb-8 max-w-3xl mx-auto">
                Our dedicated investment team is ready to assist you with personalized guidance and support
            </p>
            <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                <button class="bg-white text-blue-800 hover:bg-blue-100 px-8 py-3 rounded-md font-medium transition duration-300">
                    Contact Our Team <i class="fas fa-envelope ml-2"></i>
                </button>
                <button class="bg-transparent border-2 border-white hover:bg-white hover:text-blue-800 px-8 py-3 rounded-md font-medium transition duration-300">
                    Schedule Consultation <i class="fas fa-calendar-alt ml-2"></i>
                </button>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Get In Touch</h2>
                    <p class="text-gray-600 mb-8">
                        Have questions about investing in Kosovo? Our team of experts is here to help you navigate the investment process and connect you with the right opportunities.
                    </p>
                    
                    <div class="space-y-6">
                        <div class="flex items-start">
                            <div class="bg-blue-100 p-3 rounded-full mr-4">
                                <i class="fas fa-map-marker-alt text-blue-600"></i>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900">Headquarters</h4>
                                <p class="text-gray-600">Blvd. Mother Teresa 1, Prishtina 10000, Kosovo</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="bg-blue-100 p-3 rounded-full mr-4">
                                <i class="fas fa-phone-alt text-blue-600"></i>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900">Contact</h4>
                                <p class="text-gray-600">+383 38 200 34 000</p>
                                <p class="text-gray-600">invest@kosovo.gov</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="bg-blue-100 p-3 rounded-full mr-4">
                                <i class="fas fa-clock text-blue-600"></i>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900">Working Hours</h4>
                                <p class="text-gray-600">Monday - Friday: 8:00 - 17:00</p>
                                <p class="text-gray-600">Saturday - Sunday: Closed</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div>
                    <div class="bg-white rounded-xl p-8 shadow-md">
                        <h3 class="text-xl font-bold text-gray-900 mb-6">Send Us a Message</h3>
                        <form>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                                    <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                                    <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <input type="email" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                                <input type="tel" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Investment Interest</label>
                                <select class="text-black w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                    <option class="text-black">Select sector</option>
                                    <option class="text-black">Information Technology</option>
                                    <option class="text-black">Renewable Energy</option>
                                    <option class="text-black">Manufacturing</option>
                                    <option class="text-black">Agribusiness</option>
                                    <option class="text-black">Tourism</option>
                                    <option class="text-black">Other</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                                <textarea rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"></textarea>
                            </div>
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-medium transition duration-300">
                                Send Message <i class="fas fa-paper-plane ml-2"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-lg font-bold mb-4">InvestKosovo Hub</h3>
                    <p class="text-gray-400">
                        Your comprehensive gateway to investment opportunities in Kosovo, supported by the Government of Kosovo.
                    </p>
                    <div class="flex space-x-4 mt-4">
                        <a href="#" class="text-gray-400 hover:text-white">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <i class="fab fa-linkedin"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <i class="fab fa-facebook"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>
                <div>
                    <h3 class="text-lg font-bold mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white">Investment Guide</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Legal Framework</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Sector Reports</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Tax Incentives</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">FAQs</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-bold mb-4">Resources</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white">Market Research</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Investment Maps</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Business Registration</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Visa Information</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">News & Updates</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-bold mb-4">Newsletter</h3>
                    <p class="text-gray-400 mb-4">
                        Subscribe to receive the latest investment opportunities and updates from Kosovo.
                    </p>
                    <form class="flex">
                        <input type="email" placeholder="Your email" class="px-4 py-2 rounded-l-md text-gray-900 w-full">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-r-md">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400 text-sm">
                    © 2023 InvestKosovo Hub. All rights reserved.
                </p>
                <div class="flex space-x-6 mt-4 md:mt-0">
                    <a href="#" class="text-gray-400 hover:text-white text-sm">Privacy Policy</a>
                    <a href="#" class="text-gray-400 hover:text-white text-sm">Terms of Service</a>
                    <a href="#" class="text-gray-400 hover:text-white text-sm">Cookies</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                
                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);
                
                if (targetElement) {
                    targetElement.scrollIntoView({
                        behavior: 'smooth'
                    });
                    
                    // Close mobile menu if open
                    const mobileMenu = document.getElementById('mobile-menu');
                    if (!mobileMenu.classList.contains('hidden')) {
                        mobileMenu.classList.add('hidden');
                    }
                }
            });
        });

        // Animate elements when they come into view
        const observerOptions = {
            threshold: 0.1
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate__animated', 'animate__fadeInUp');
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        document.querySelectorAll('.card-hover, .sector-card, .testimonial-card, .stat-card').forEach(card => {
            observer.observe(card);
        });
    </script>
</body>
</html>