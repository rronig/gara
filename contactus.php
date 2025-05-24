<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us | KosovaOne</title>
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
        .contact-map {
            height: 100%;
            min-height: 300px;
            border-radius: 0.75rem;
        }
        @media (min-width: 1024px) {
            .contact-map {
                height: 400px;
            }
        }
    </style>
</head>
<body class="font-sans scroll-container">
    <!-- Header with Navigation -->
    <header class="gradient-bg text-white sticky top-0 z-50 shadow-lg">
        <div class="container mx-auto px-4 py-3">
            <div class="flex justify-between items-center">
                <a href="index.php">
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-landmark text-2xl"></i>
                        <h1 class="text-2xl font-bold">Kosova<span class="text-blue-200">One</span></h1>
                    </div>
                </a>
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

    <!-- Contact Hero Section -->
    <section class="gradient-bg text-white py-16">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto text-center">
                <h1 class="text-4xl md:text-5xl font-bold leading-tight mb-6">Contact KosovaOne</h1>
                <p class="text-xl text-blue-100 mb-8">
                    We're here to help you with any questions, feedback, or support needs regarding our public services platform.
                </p>
                <div class="flex flex-wrap justify-center gap-4">
                    <div class="flex items-center bg-blue-700 bg-opacity-50 px-4 py-2 rounded-full">
                        <i class="fas fa-phone-alt mr-2"></i>
                        <span>+383 44 192 753</span>
                    </div>
                    <div class="flex items-center bg-blue-700 bg-opacity-50 px-4 py-2 rounded-full">
                        <i class="fas fa-envelope mr-2"></i>
                        <span>support@KosovaOne.gov</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Content Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Contact Form -->
                <div class="bg-gray-50 rounded-xl p-8 shadow-sm">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Send Us a Message</h2>
                    <form id="contact-form" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="first-name" class="block text-sm font-medium text-gray-700 mb-1">First Name*</label>
                                <input type="text" id="first-name" required class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 feedback-input">
                            </div>
                            <div>
                                <label for="last-name" class="block text-sm font-medium text-gray-700 mb-1">Last Name*</label>
                                <input type="text" id="last-name" required class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 feedback-input">
                            </div>
                        </div>
                        
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address*</label>
                            <input type="email" id="email" required class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 feedback-input">
                        </div>
                        
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                            <input type="tel" id="phone" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 feedback-input">
                        </div>
                        
                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Subject*</label>
                            <select id="subject" required class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 feedback-input">
                                <option value="" disabled selected>Select a topic</option>
                                <option>General Inquiry</option>
                                <option>Technical Support</option>
                                <option>Service Feedback</option>
                                <option>Bug Report</option>
                                <option>Feature Request</option>
                                <option>Partnership Inquiry</option>
                                <option>Media Inquiry</option>
                                <option>Other</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message*</label>
                            <textarea id="message" rows="5" required class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 feedback-input"></textarea>
                        </div>
                        
                        <div class="flex items-center">
                            <input id="privacy-policy" type="checkbox" required class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="privacy-policy" class="ml-2 block text-sm text-gray-700">
                                I agree to the <a href="#" class="text-blue-600 hover:underline">Privacy Policy</a> and <a href="#" class="text-blue-600 hover:underline">Terms of Service</a>
                            </label>
                        </div>
                        
                        <button type="submit" class="w-full bg-blue-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-700 transition flex items-center justify-center">
                            <i class="fas fa-paper-plane mr-2"></i> Send Message
                        </button>
                    </form>
                </div>
                
                <!-- Contact Information -->
                <div class="space-y-8">
                    <!-- Office Locations -->
                    <div class="bg-gray-50 rounded-xl p-6 shadow-sm">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Our Offices</h3>
                        
                        <div class="space-y-6">
                            <!-- Office 1 -->
                            <div class="flex items-start">
                                <div class="bg-blue-100 p-3 rounded-full mr-4">
                                    <i class="fas fa-building text-blue-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-800">Headquarters</h4>
                                    <p class="text-gray-600">123 Government Plaza<br>Suite 500<br>Capital City, CC 10001</p>
                                    <div class="mt-2">
                                        <a href="#" class="text-blue-600 text-sm font-medium flex items-center">
                                            <i class="fas fa-directions mr-1"></i> Get Directions
                                        </a>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Office 2 -->
                            <div class="flex items-start">
                                <div class="bg-green-100 p-3 rounded-full mr-4">
                                    <i class="fas fa-city text-green-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-800">Regional Office</h4>
                                    <p class="text-gray-600">456 Civic Center Drive<br>Floor 3<br>Metro City, MC 20002</p>
                                    <div class="mt-2">
                                        <a href="#" class="text-blue-600 text-sm font-medium flex items-center">
                                            <i class="fas fa-directions mr-1"></i> Get Directions
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Map -->
                    <div class="bg-gray-200 rounded-xl overflow-hidden contact-map">
                        <!-- Embedded Google Map (placeholder) -->
                        <div class="w-full h-full flex items-center justify-center bg-gray-300">
                            <div class="text-center p-6">
                                <i class="fas fa-map-marked-alt text-4xl text-gray-500 mb-3"></i>
                                <p class="text-gray-600">Interactive map would display here</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Additional Contact Options -->
                    <div class="bg-gray-50 rounded-xl p-6 shadow-sm">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Other Ways to Reach Us</h3>
                        
                        <div class="space-y-4">
                            <!-- Social Media -->
                            <div class="flex items-start">
                                <div class="bg-purple-100 p-3 rounded-full mr-4">
                                    <i class="fas fa-hashtag text-purple-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-800 mb-1">Social Media</h4>
                                    <div class="flex space-x-4 mt-2">
                                        <a href="#" class="text-blue-600 hover:text-blue-800">
                                            <i class="fab fa-twitter text-xl"></i>
                                        </a>
                                        <a href="#" class="text-blue-700 hover:text-blue-900">
                                            <i class="fab fa-facebook text-xl"></i>
                                        </a>
                                        <a href="#" class="text-pink-600 hover:text-pink-800">
                                            <i class="fab fa-instagram text-xl"></i>
                                        </a>
                                        <a href="#" class="text-gray-800 hover:text-gray-900">
                                            <i class="fab fa-github text-xl"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Help Center -->
                            <div class="flex items-start">
                                <div class="bg-yellow-100 p-3 rounded-full mr-4">
                                    <i class="fas fa-question-circle text-yellow-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-800">Help Center</h4>
                                    <p class="text-gray-600 mb-2">Find answers to common questions in our comprehensive help center.</p>
                                    <a href="#" class="text-blue-600 text-sm font-medium flex items-center">
                                        <i class="fas fa-external-link-alt mr-1"></i> Visit Help Center
                                    </a>
                                </div>
                            </div>
                            
                            <!-- Emergency -->
                            <div class="flex items-start">
                                <div class="bg-red-100 p-3 rounded-full mr-4">
                                    <i class="fas fa-exclamation-triangle text-red-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-800">Emergency Contacts</h4>
                                    <p class="text-gray-600 mb-2">For urgent matters requiring immediate government response.</p>
                                    <a href="#" class="text-blue-600 text-sm font-medium flex items-center">
                                        <i class="fas fa-phone mr-1"></i> View Emergency Contacts
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Preview Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Frequently Asked Questions</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Quick answers to common questions about KosovaOne services and support.
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl mx-auto">
                <!-- FAQ Item 1 -->
                <div class="bg-white rounded-xl shadow-sm p-6 card-hover">
                    <h3 class="font-bold text-gray-800 mb-2">How do I reset my password?</h3>
                    <p class="text-gray-600 text-sm">
                        Click "Forgot Password" on the login page and follow the instructions sent to your registered email address.
                    </p>
                </div>
                
                <!-- FAQ Item 2 -->
                <div class="bg-white rounded-xl shadow-sm p-6 card-hover">
                    <h3 class="font-bold text-gray-800 mb-2">What are your support hours?</h3>
                    <p class="text-gray-600 text-sm">
                        Our support team is available Monday-Friday, 8am-8pm EST. Emergency services are available 24/7.
                    </p>
                </div>
                
                <!-- FAQ Item 3 -->
                <div class="bg-white rounded-xl shadow-sm p-6 card-hover">
                    <h3 class="font-bold text-gray-800 mb-2">Can I schedule an in-person appointment?</h3>
                    <p class="text-gray-600 text-sm">
                        Yes, many services offer in-person appointments at our offices. Check the specific service page for details.
                    </p>
                </div>
                
                <!-- FAQ Item 4 -->
                <div class="bg-white rounded-xl shadow-sm p-6 card-hover">
                    <h3 class="font-bold text-gray-800 mb-2">How long does it take to get a response?</h3>
                    <p class="text-gray-600 text-sm">
                        We typically respond within 1-2 business days. Urgent matters may be escalated for faster response.
                    </p>
                </div>
            </div>
            
            <div class="text-center mt-10">
                <a href="#" class="inline-flex items-center text-blue-600 font-medium hover:text-blue-800">
                    View all FAQs <i class="fas fa-chevron-right ml-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Feedback Section -->
    <section class="py-16 bg-blue-600 text-white">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <i class="fas fa-comment-dots text-4xl mb-4"></i>
                <h2 class="text-3xl font-bold mb-4">Help Us Improve</h2>
                <p class="text-blue-100 mb-8 max-w-2xl mx-auto">
                    Your feedback helps us make KosovaOne better for everyone. Share your thoughts about your experience with our platform.
                </p>
                <a href="#" class="inline-flex items-center bg-white text-blue-600 px-6 py-3 rounded-full font-medium hover:bg-blue-50 transition">
                    <i class="fas fa-bullhorn mr-2"></i> Give Feedback
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
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
        
        // Form submission handling
        const contactForm = document.getElementById('contact-form');
        contactForm.addEventListener('submit', (e) => {
            e.preventDefault();
            
            // Here you would typically send the form data to a server
            // For this example, we'll just show a success message
            alert('Thank you for your message! We will respond to your inquiry as soon as possible.');
            contactForm.reset();
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
                    if (!mobileMenu.classList.contains('hidden')) {
                        mobileMenu.classList.add('hidden');
                    }
                }
            });
        });
    </script>
</body>
</html>