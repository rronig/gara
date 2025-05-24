<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KosovaOne | Unified Public Services Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 50%, #3b82f6 100%);
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .service-icon {
            transition: all 0.3s ease;
        }
        .service-card:hover .service-icon {
            transform: scale(1.1);
        }
        .data-visualization {
            height: 300px;
            background: linear-gradient(to right, #f0f9ff, #e0f2fe);
        }
        .animated-underline {
            position: relative;
            display: inline-block;
        }
        .animated-underline::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -2px;
            left: 0;
            background-color: #3b82f6;
            transition: width 0.3s ease;
        }
        .animated-underline:hover::after {
            width: 100%;
        }
        .feedback-input:focus {
            outline: none;
            box-shadow: 0 0 0 2px #3b82f6;
        }
        .scroll-container {
            scroll-behavior: smooth;
        }
    </style>
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
    <section class="gradient-bg text-white py-16 md:py-24">
        <div class="container mx-auto px-4 flex flex-col md:flex-row items-center">
            <div class="md:w-1/2 mb-10 md:mb-0">
                <h1 class="text-4xl md:text-5xl font-bold leading-tight mb-6">
                    One Portal for All <span class="text-blue-200">Public Services</span>
                </h1>
                <p class="text-xl text-blue-100 mb-8">
                    Access government services, business support, public data, and civic engagement tools - all in one transparent, user-friendly platform.
                </p>
                <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4">
                    <button class="bg-white text-blue-600 px-6 py-3 rounded-full font-medium hover:bg-blue-50 transition flex items-center justify-center">
                        <i class="fas fa-rocket mr-2"></i> Explore Services
                    </button>
                    <button class="bg-transparent border-2 border-white text-white px-6 py-3 rounded-full font-medium hover:bg-blue-700 transition flex items-center justify-center">
                        <i class="fas fa-play-circle mr-2"></i> Watch Demo
                    </button>
                </div>
            </div>
            <div class="md:w-1/2 flex justify-center">
                <div class="relative w-full max-w-md">
                    <div class="absolute -top-10 -left-10 w-32 h-32 bg-blue-400 rounded-full opacity-20"></div>
                    <div class="absolute -bottom-10 -right-10 w-32 h-32 bg-blue-400 rounded-full opacity-20"></div>
                    <div class="relative bg-white rounded-xl shadow-2xl overflow-hidden">
                        <div class="bg-gray-100 p-3 flex space-x-2">
                            <div class="w-3 h-3 rounded-full bg-red-500"></div>
                            <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                            <div class="w-3 h-3 rounded-full bg-green-500"></div>
                        </div>
                        <div class="p-6">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-gray-800 font-bold">Service Dashboard</h3>
                                <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded">New</span>
                            </div>
                            <div class="grid grid-cols-3 gap-4 mb-6">
                                <div class="bg-blue-50 p-3 rounded-lg text-center">
                                    <i class="fas fa-id-card text-blue-600 text-2xl mb-2"></i>
                                    <p class="text-xs font-medium text-gray-700">ID Services</p>
                                </div>
                                <div class="bg-blue-50 p-3 rounded-lg text-center">
                                    <i class="fas fa-home text-blue-600 text-2xl mb-2"></i>
                                    <p class="text-xs font-medium text-gray-700">Housing</p>
                                </div>
                                <div class="bg-blue-50 p-3 rounded-lg text-center">
                                    <i class="fas fa-heartbeat text-blue-600 text-2xl mb-2"></i>
                                    <p class="text-xs font-medium text-gray-700">Health</p>
                                </div>
                            </div>
                            <div class="bg-blue-600 text-white p-4 rounded-lg">
                                <div class="flex justify-between items-center mb-2">
                                    <p class="text-sm">Application Status</p>
                                    <span class="text-xs bg-blue-800 px-2 py-1 rounded">Pending</span>
                                </div>
                                <div class="w-full bg-blue-700 rounded-full h-2">
                                    <div class="bg-blue-300 h-2 rounded-full" style="width: 60%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Government Services Made Simple</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Access hundreds of government services from federal to local levels, all streamlined through our unified platform.
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Service Card 1 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden service-card transition-all duration-300 card-hover">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div class="bg-blue-100 p-3 rounded-full mr-4">
                                <i class="fas fa-passport text-blue-600 text-xl service-icon"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800">ID & Documentation</h3>
                        </div>
                        <p class="text-gray-600 mb-6">
                            Apply for passports, national IDs, driver's licenses, and other essential documents with our streamlined process.
                        </p>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-blue-600 font-medium">5 services available</span>
                            <button class="text-blue-600 hover:text-blue-800">
                                <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Service Card 2 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden service-card transition-all duration-300 card-hover">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div class="bg-green-100 p-3 rounded-full mr-4">
                                <i class="fas fa-home text-green-600 text-xl service-icon"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800">Housing & Property</h3>
                        </div>
                        <p class="text-gray-600 mb-6">
                            Property registration, housing permits, social housing applications, and urban planning services.
                        </p>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-green-600 font-medium">8 services available</span>
                            <button class="text-green-600 hover:text-green-800">
                                <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Service Card 3 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden service-card transition-all duration-300 card-hover">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div class="bg-purple-100 p-3 rounded-full mr-4">
                                <i class="fas fa-heartbeat text-purple-600 text-xl service-icon"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800">Health & Social Care</h3>
                        </div>
                        <p class="text-gray-600 mb-6">
                            Health insurance, medical services, social benefits, and support for vulnerable populations.
                        </p>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-purple-600 font-medium">12 services available</span>
                            <button class="text-purple-600 hover:text-purple-800">
                                <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Service Card 4 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden service-card transition-all duration-300 card-hover">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div class="bg-yellow-100 p-3 rounded-full mr-4">
                                <i class="fas fa-graduation-cap text-yellow-600 text-xl service-icon"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800">Education</h3>
                        </div>
                        <p class="text-gray-600 mb-6">
                            School enrollment, scholarship applications, student loans, and educational resources.
                        </p>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-yellow-600 font-medium">6 services available</span>
                            <button class="text-yellow-600 hover:text-yellow-800">
                                <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Service Card 5 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden service-card transition-all duration-300 card-hover">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div class="bg-red-100 p-3 rounded-full mr-4">
                                <i class="fas fa-car text-red-600 text-xl service-icon"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800">Transportation</h3>
                        </div>
                        <p class="text-gray-600 mb-6">
                            Vehicle registration, public transit passes, road tax payments, and infrastructure projects.
                        </p>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-red-600 font-medium">7 services available</span>
                            <button class="text-red-600 hover:text-red-800">
                                <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Service Card 6 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden service-card transition-all duration-300 card-hover">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div class="bg-indigo-100 p-3 rounded-full mr-4">
                                <i class="fas fa-search-dollar text-indigo-600 text-xl service-icon"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800">Tax & Finance</h3>
                        </div>
                        <p class="text-gray-600 mb-6">
                            File taxes, pay bills, apply for financial assistance, and access economic support programs.
                        </p>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-indigo-600 font-medium">9 services available</span>
                            <button class="text-indigo-600 hover:text-indigo-800">
                                <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-12">
                <button class="bg-blue-600 text-white px-6 py-3 rounded-full font-medium hover:bg-blue-700 transition flex items-center mx-auto">
                    <i class="fas fa-list-ul mr-2"></i> View All Services
                </button>
            </div>
        </div>
    </section>

    <!-- Business Support Section -->
    <section id="business" class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="flex flex-col lg:flex-row items-center">
                <div class="lg:w-1/2 mb-10 lg:mb-0 lg:pr-10">
                    <h2 class="text-3xl font-bold text-gray-800 mb-6">Business Support & Resources</h2>
                    <p class="text-gray-600 mb-6">
                        Our platform provides comprehensive support for businesses of all sizes, from startups to established enterprises. 
                        Access licensing, permits, funding opportunities, and market data in one place.
                    </p>
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="bg-green-100 p-2 rounded-full mr-4">
                                <i class="fas fa-check-circle text-green-600"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800">Simplified Registration</h4>
                                <p class="text-gray-600">Register your business in minutes with our guided process.</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="bg-blue-100 p-2 rounded-full mr-4">
                                <i class="fas fa-chart-line text-blue-600"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800">Market Insights</h4>
                                <p class="text-gray-600">Access real-time economic data and industry trends.</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="bg-purple-100 p-2 rounded-full mr-4">
                                <i class="fas fa-hand-holding-usd text-purple-600"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800">Funding Opportunities</h4>
                                <p class="text-gray-600">Discover grants, loans, and investment programs.</p>
                            </div>
                        </div>
                    </div>
                    <button class="mt-8 bg-green-600 text-white px-6 py-3 rounded-full font-medium hover:bg-green-700 transition flex items-center">
                        <i class="fas fa-briefcase mr-2"></i> Explore Business Services
                    </button>
                </div>
                <div class="lg:w-1/2">
                    <div class="bg-gray-50 border border-gray-200 rounded-xl p-6 shadow-sm">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-xl font-bold text-gray-800">Business Services Dashboard</h3>
                            <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded">Interactive</span>
                        </div>
                        
                        <div class="mb-6">
                            <div class="flex justify-between mb-2">
                                <span class="text-sm font-medium text-gray-600">Business Registration</span>
                                <span class="text-sm font-medium text-blue-600">85% complete</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-blue-600 h-2.5 rounded-full" style="width: 85%"></div>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div class="bg-white p-4 rounded-lg border border-gray-200">
                                <div class="text-blue-600 text-2xl mb-2">
                                    <i class="fas fa-file-invoice-dollar"></i>
                                </div>
                                <h4 class="font-bold text-gray-800 mb-1">Tax Filing</h4>
                                <p class="text-xs text-gray-600">Deadline: May 15</p>
                            </div>
                            <div class="bg-white p-4 rounded-lg border border-gray-200">
                                <div class="text-green-600 text-2xl mb-2">
                                    <i class="fas fa-clipboard-check"></i>
                                </div>
                                <h4 class="font-bold text-gray-800 mb-1">Permits</h4>
                                <p class="text-xs text-gray-600">2 renewals needed</p>
                            </div>
                        </div>
                        
                        <div class="bg-blue-50 rounded-lg p-4">
                            <div class="flex items-start">
                                <div class="bg-blue-100 p-2 rounded-full mr-3">
                                    <i class="fas fa-lightbulb text-blue-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-800 mb-1">New Funding Opportunity</h4>
                                    <p class="text-sm text-gray-600">Green Business Initiative grants now available. Applications open until June 30.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Open Data Section -->
    <section id="data" class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Transparent Public Data</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Access comprehensive government datasets, budgets, and performance metrics. Our open data platform promotes transparency and enables data-driven decision making.
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                <div class="bg-white rounded-xl shadow-md overflow-hidden p-6 card-hover">
                    <div class="bg-blue-100 p-3 rounded-full w-12 h-12 flex items-center justify-center mb-4">
                        <i class="fas fa-chart-pie text-blue-600 text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Budget Visualization</h3>
                    <p class="text-gray-600 mb-4">
                        Interactive tools to explore government spending at national and local levels.
                    </p>
                    <button class="text-blue-600 font-medium flex items-center">
                        Explore Budgets <i class="fas fa-chevron-right ml-2 text-sm"></i>
                    </button>
                </div>
                
                <div class="bg-white rounded-xl shadow-md overflow-hidden p-6 card-hover">
                    <div class="bg-green-100 p-3 rounded-full w-12 h-12 flex items-center justify-center mb-4">
                        <i class="fas fa-map-marked-alt text-green-600 text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Geospatial Data</h3>
                    <p class="text-gray-600 mb-4">
                        Maps and location-based datasets for infrastructure, environment, and urban planning.
                    </p>
                    <button class="text-green-600 font-medium flex items-center">
                        View Maps <i class="fas fa-chevron-right ml-2 text-sm"></i>
                    </button>
                </div>
                
                <div class="bg-white rounded-xl shadow-md overflow-hidden p-6 card-hover">
                    <div class="bg-purple-100 p-3 rounded-full w-12 h-12 flex items-center justify-center mb-4">
                        <i class="fas fa-chart-bar text-purple-600 text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Performance Metrics</h3>
                    <p class="text-gray-600 mb-4">
                        Track government agency performance and service delivery statistics.
                    </p>
                    <button class="text-purple-600 font-medium flex items-center">
                        See Metrics <i class="fas fa-chevron-right ml-2 text-sm"></i>
                    </button>
                </div>
            </div>
            
            <!-- Data Visualization Demo -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-xl font-bold text-gray-800">Public Spending Analysis</h3>
                    <p class="text-gray-600">Explore how taxpayer money is allocated across different sectors</p>
                </div>
                <div class="p-6 data-visualization flex items-center justify-center">
                    <div class="text-center">
                        <div class="inline-block relative w-64 h-64 mb-4">
                            <!-- Pie Chart Sectors -->
                            <div class="absolute inset-0 rounded-full border-4 border-blue-100"></div>
                            <div class="absolute inset-0 rounded-full" style="clip-path: polygon(50% 50%, 50% 0%, 100% 0%, 100% 50%); background-color: #3b82f6;"></div>
                            <div class="absolute inset-0 rounded-full" style="clip-path: polygon(50% 50%, 100% 50%, 100% 100%, 50% 100%); background-color: #10b981;"></div>
                            <div class="absolute inset-0 rounded-full" style="clip-path: polygon(50% 50%, 50% 100%, 0% 100%, 0% 50%); background-color: #8b5cf6;"></div>
                            <div class="absolute inset-0 rounded-full" style="clip-path: polygon(50% 50%, 0% 50%, 0% 0%, 50% 0%); background-color: #ef4444;"></div>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="bg-white rounded-full w-20 h-20 flex items-center justify-center shadow-inner">
                                    <span class="font-bold text-gray-700">$4.2B</span>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-blue-500 rounded-full mr-2"></div>
                                <span class="text-sm">Healthcare</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-green-500 rounded-full mr-2"></div>
                                <span class="text-sm">Education</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-purple-500 rounded-full mr-2"></div>
                                <span class="text-sm">Infrastructure</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-red-500 rounded-full mr-2"></div>
                                <span class="text-sm">Defense</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-4 bg-gray-50 border-t border-gray-200 flex justify-between items-center">
                    <div class="flex space-x-2">
                        <button class="px-3 py-1 bg-white border border-gray-300 rounded-md text-sm font-medium">1Y</button>
                        <button class="px-3 py-1 bg-blue-600 text-white rounded-md text-sm font-medium">5Y</button>
                        <button class="px-3 py-1 bg-white border border-gray-300 rounded-md text-sm font-medium">10Y</button>
                    </div>
                    <button class="text-blue-600 font-medium flex items-center text-sm">
                        Download Dataset <i class="fas fa-download ml-2"></i>
                    </button>
                </div>
            </div>
            
            <div class="text-center">
                <button class="bg-indigo-600 text-white px-6 py-3 rounded-full font-medium hover:bg-indigo-700 transition flex items-center mx-auto">
                    <i class="fas fa-database mr-2"></i> Explore Full Data Catalog
                </button>
            </div>
        </div>
    </section>

    <!-- Civic Engagement Section -->
    <section id="engagement" class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Your Voice Matters</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Participate in public consultations, vote on local initiatives, and connect with your representatives through our civic engagement platform.
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
                <div class="bg-gray-50 rounded-xl p-8">
                    <h3 class="text-xl font-bold text-gray-800 mb-6">Active Consultations</h3>
                    
                    <div class="space-y-4">
                        <!-- Consultation Item 1 -->
                        <div class="bg-white rounded-lg shadow-sm p-4 border border-gray-200">
                            <div class="flex justify-between items-start mb-2">
                                <h4 class="font-bold text-gray-800">Urban Green Spaces Plan</h4>
                                <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded">Open</span>
                            </div>
                            <p class="text-sm text-gray-600 mb-3">
                                Share your input on the proposed expansion of parks and recreational areas in your district.
                            </p>
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-gray-500">Closes in 12 days</span>
                                <button class="text-blue-600 text-sm font-medium flex items-center">
                                    Participate <i class="fas fa-chevron-right ml-1 text-xs"></i>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Consultation Item 2 -->
                        <div class="bg-white rounded-lg shadow-sm p-4 border border-gray-200">
                            <div class="flex justify-between items-start mb-2">
                                <h4 class="font-bold text-gray-800">School Curriculum Review</h4>
                                <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded">Open</span>
                            </div>
                            <p class="text-sm text-gray-600 mb-3">
                                Provide feedback on proposed changes to the national education curriculum.
                            </p>
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-gray-500">Closes in 5 days</span>
                                <button class="text-blue-600 text-sm font-medium flex items-center">
                                    Participate <i class="fas fa-chevron-right ml-1 text-xs"></i>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Consultation Item 3 -->
                        <div class="bg-white rounded-lg shadow-sm p-4 border border-gray-200">
                            <div class="flex justify-between items-start mb-2">
                                <h4 class="font-bold text-gray-800">Public Transport Fares</h4>
                                <span class="text-xs bg-yellow-100 text-yellow-800 px-2 py-1 rounded">Upcoming</span>
                            </div>
                            <p class="text-sm text-gray-600 mb-3">
                                Consultation on proposed changes to bus and train fares begins next week.
                            </p>
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-gray-500">Starts June 1</span>
                                <button class="text-gray-500 text-sm font-medium flex items-center" disabled>
                                    Notify Me <i class="fas fa-bell ml-1 text-xs"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <button class="mt-6 w-full bg-blue-600 text-white py-2 rounded-lg font-medium hover:bg-blue-700 transition">
                        View All Consultations
                    </button>
                </div>
                
                <div class="bg-gray-50 rounded-xl p-8">
                    <h3 class="text-xl font-bold text-gray-800 mb-6">Connect With Representatives</h3>
                    
                    <div class="bg-white rounded-lg shadow-sm p-4 border border-gray-200 mb-6">
                        <div class="flex items-center mb-4">
                            <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Representative" class="w-12 h-12 rounded-full object-cover mr-4">
                            <div>
                                <h4 class="font-bold text-gray-800">Sarah Johnson</h4>
                                <p class="text-sm text-gray-600">District 7 Council Member</p>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600 mb-4">
                            "I'm committed to making our district more livable for all residents. Share your concerns and ideas with me directly through this platform."
                        </p>
                        <div class="flex space-x-3">
                            <button class="flex-1 bg-blue-600 text-white py-2 rounded-lg font-medium hover:bg-blue-700 transition text-sm">
                                <i class="fas fa-envelope mr-1"></i> Message
                            </button>
                            <button class="flex-1 bg-gray-200 text-gray-800 py-2 rounded-lg font-medium hover:bg-gray-300 transition text-sm">
                                <i class="fas fa-calendar-alt mr-1"></i> Schedule
                            </button>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-lg shadow-sm p-4 border border-gray-200">
                        <h4 class="font-bold text-gray-800 mb-3">Upcoming Town Hall</h4>
                        <div class="flex items-center text-sm text-gray-600 mb-3">
                            <i class="fas fa-calendar-day mr-2 text-blue-600"></i>
                            <span>June 15, 2023 | 6:30 PM - 8:30 PM</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-600 mb-4">
                            <i class="fas fa-map-marker-alt mr-2 text-blue-600"></i>
                            <span>Virtual & District Community Center</span>
                        </div>
                        <p class="text-sm text-gray-600 mb-4">
                            Join Council Member Johnson and other district officials to discuss the upcoming budget and infrastructure projects.
                        </p>
                        <button class="w-full bg-green-600 text-white py-2 rounded-lg font-medium hover:bg-green-700 transition">
                            <i class="fas fa-user-plus mr-1"></i> RSVP Now
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="bg-blue-50 rounded-xl p-8">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Help Improve Our Services</h3>
                <p class="text-gray-600 mb-6 max-w-3xl">
                    We're constantly working to make KosovaOne more useful and user-friendly. Share your feedback, report issues, or suggest new features.
                </p>
                
                <form class="space-y-4">
                    <div>
                        <label for="feedback-type" class="block text-sm font-medium text-gray-700 mb-1">Feedback Type</label>
                        <select id="feedback-type" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 feedback-input">
                            <option>General Feedback</option>
                            <option>Bug Report</option>
                            <option>Feature Request</option>
                            <option>Service Complaint</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="feedback-message" class="block text-sm font-medium text-gray-700 mb-1">Your Feedback</label>
                        <textarea id="feedback-message" rows="4" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 feedback-input" placeholder="Share your thoughts..."></textarea>
                    </div>
                    
                    <div class="flex items-center">
                        <input id="contact-permission" type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="contact-permission" class="ml-2 block text-sm text-gray-700">
                            I agree to be contacted about my feedback if needed
                        </label>
                    </div>
                    
                    <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-700 transition">
                        Submit Feedback
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">About KosovaOne</h2>
                <p class="text-gray-600 max-w-3xl mx-auto">
                    KosovaOne is a government initiative to create a unified, transparent, and user-friendly platform for all public services and civic engagement.
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                <div class="bg-white rounded-xl shadow-md overflow-hidden p-6 card-hover">
                    <div class="bg-blue-100 p-3 rounded-full w-12 h-12 flex items-center justify-center mb-4">
                        <i class="fas fa-bullseye text-blue-600 text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Our Mission</h3>
                    <p class="text-gray-600">
                        To simplify access to government services, promote transparency, and empower citizens through technology and open data.
                    </p>
                </div>
                
                <div class="bg-white rounded-xl shadow-md overflow-hidden p-6 card-hover">
                    <div class="bg-green-100 p-3 rounded-full w-12 h-12 flex items-center justify-center mb-4">
                        <i class="fas fa-lock text-green-600 text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Security & Privacy</h3>
                    <p class="text-gray-600">
                        We use state-of-the-art encryption and follow strict data protection regulations to keep your information safe.
                    </p>
                </div>
                
                <div class="bg-white rounded-xl shadow-md overflow-hidden p-6 card-hover">
                    <div class="bg-purple-100 p-3 rounded-full w-12 h-12 flex items-center justify-center mb-4">
                        <i class="fas fa-code-branch text-purple-600 text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Open Source</h3>
                    <p class="text-gray-600">
                        KosovaOne is built on open-source technologies, and we welcome contributions from developers worldwide.
                    </p>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="p-6 md:p-8">
                    <h3 class="text-xl font-bold text-gray-800 mb-6">Frequently Asked Questions</h3>
                    
                    <div class="space-y-4">
                        <!-- FAQ Item 1 -->
                        <div class="border-b border-gray-200 pb-4">
                            <button class="flex justify-between items-center w-full text-left group" onclick="toggleFAQ(1)">
                                <span class="font-medium text-gray-800 group-hover:text-blue-600">How do I create an account?</span>
                                <i class="fas fa-chevron-down text-gray-500 transition-transform duration-300" id="faq-icon-1"></i>
                            </button>
                            <div class="hidden mt-2 text-gray-600" id="faq-content-1">
                                <p>
                                    You can create an account by clicking the "Sign In" button in the top right corner and selecting "Create Account." 
                                    You'll need to provide some basic information and verify your email address. Alternatively, you can use your existing 
                                    government services login if you have one.
                                </p>
                            </div>
                        </div>
                        
                        <!-- FAQ Item 2 -->
                        <div class="border-b border-gray-200 pb-4">
                            <button class="flex justify-between items-center w-full text-left group" onclick="toggleFAQ(2)">
                                <span class="font-medium text-gray-800 group-hover:text-blue-600">Is there a mobile app available?</span>
                                <i class="fas fa-chevron-down text-gray-500 transition-transform duration-300" id="faq-icon-2"></i>
                            </button>
                            <div class="hidden mt-2 text-gray-600" id="faq-content-2">
                                <p>
                                    Yes! KosovaOne is available as a mobile app for both iOS and Android devices. You can download it from the App Store 
                                    or Google Play. The app offers all the same features as the web platform with additional mobile-friendly functionalities 
                                    like document scanning and location-based services.
                                </p>
                            </div>
                        </div>
                        
                        <!-- FAQ Item 3 -->
                        <div class="border-b border-gray-200 pb-4">
                            <button class="flex justify-between items-center w-full text-left group" onclick="toggleFAQ(3)">
                                <span class="font-medium text-gray-800 group-hover:text-blue-600">How can I track my service requests?</span>
                                <i class="fas fa-chevron-down text-gray-500 transition-transform duration-300" id="faq-icon-3"></i>
                            </button>
                            <div class="hidden mt-2 text-gray-600" id="faq-content-3">
                                <p>
                                    Once logged in, navigate to "My Services" in your dashboard. Here you'll see all your active and completed service requests 
                                    with their current status. You can also opt to receive email or SMS notifications when there are updates to your requests.
                                </p>
                            </div>
                        </div>
                        
                        <!-- FAQ Item 4 -->
                        <div class="border-b border-gray-200 pb-4">
                            <button class="flex justify-between items-center w-full text-left group" onclick="toggleFAQ(4)">
                                <span class="font-medium text-gray-800 group-hover:text-blue-600">Are all government services available through KosovaOne?</span>
                                <i class="fas fa-chevron-down text-gray-500 transition-transform duration-300" id="faq-icon-4"></i>
                            </button>
                            <div class="hidden mt-2 text-gray-600" id="faq-content-4">
                                <p>
                                    We're continuously adding more services to the platform. Currently, about 85% of common government services are available 
                                    through KosovaOne, with more being added each month. If you can't find a particular service, you can request it through 
                                    our feedback form, and we'll prioritize adding it based on demand.
                                </p>
                            </div>
                        </div>
                        
                        <!-- FAQ Item 5 -->
                        <div class="pb-4">
                            <button class="flex justify-between items-center w-full text-left group" onclick="toggleFAQ(5)">
                                <span class="font-medium text-gray-800 group-hover:text-blue-600">How is my personal data protected?</span>
                                <i class="fas fa-chevron-down text-gray-500 transition-transform duration-300" id="faq-icon-5"></i>
                            </button>
                            <div class="hidden mt-2 text-gray-600" id="faq-content-5">
                                <p>
                                    KosovaOne adheres to strict data protection regulations. We use bank-grade encryption for all data transmission and storage. 
                                    Your information is only shared with the specific government agencies required to process your service requests, and we never sell 
                                    or share your data with third parties. You can review our complete Privacy Policy for more details.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="py-12 bg-blue-600 text-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-2xl font-bold mb-4">Stay Informed</h2>
            <p class="max-w-2xl mx-auto mb-8 text-blue-100">
                Subscribe to our newsletter for updates on new services, platform improvements, and civic engagement opportunities.
            </p>
            
            <form class="max-w-md mx-auto flex">
                <input type="email" placeholder="Your email address" class="flex-1 px-4 py-3 rounded-l-lg focus:outline-none text-gray-800">
                <button type="submit" class="bg-blue-800 px-6 py-3 rounded-r-lg font-medium hover:bg-blue-900 transition">
                    Subscribe
                </button>
            </form>
            
            <p class="text-xs text-blue-200 mt-4">
                We respect your privacy. Unsubscribe at any time.
            </p>
        </div>
    </section>
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
    <script>
        // Mobile menu toggle
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        
        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
        
        // FAQ toggle functionality
        function toggleFAQ(number) {
            const content = document.getElementById(`faq-content-${number}`);
            const icon = document.getElementById(`faq-icon-${number}`);
            
            content.classList.toggle('hidden');
            icon.classList.toggle('rotate-180');
        }
        
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
                    if (!mobileMenu.classList.contains('hidden')) {
                        mobileMenu.classList.add('hidden');
                    }
                }
            });
        });
        
        // Simple animation on scroll
        const observerOptions = {
            threshold: 0.1
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-fadeIn');
                }
            });
        }, observerOptions);
        
        document.querySelectorAll('.service-card, .card-hover').forEach(card => {
            observer.observe(card);
        });
    </script>
</body>
</html>