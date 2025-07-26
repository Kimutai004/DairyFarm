<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dairy Farm Management System</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-green: #2d8a4f;
            --secondary-green: #4caf50;
            --accent-blue: #3498db;
            --warm-brown: #8b4513;
            --cream: #f8f6f0;
            --light-green: #e8f5e8;
            --dark-green: #1e5d35;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: #2c3e50;
            overflow-x: hidden;
        }

        .hero-section {
            background: linear-gradient(135deg, 
                rgba(45, 138, 79, 0.9) 0%, 
                rgba(76, 175, 80, 0.8) 50%, 
                rgba(52, 152, 219, 0.9) 100%),
                url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><defs><pattern id="farm" x="0" y="0" width="100" height="100" patternUnits="userSpaceOnUse"><rect fill="%23f0f8f0" width="100" height="100"/><circle fill="%23e8f5e8" cx="50" cy="50" r="30" opacity="0.3"/></pattern></defs><rect fill="url(%23farm)" width="1000" height="1000"/></svg>');
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            background-size: cover;
            background-position: center;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><rect fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="0.5" width="20" height="20" x="40" y="40"/></svg>');
            background-size: 50px 50px;
            opacity: 0.3;
        }

        .navbar {
            position: absolute;
            top: 0;
            width: 100%;
            z-index: 1000;
            padding: 1rem 0;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .navbar-brand {
            font-size: 1.8rem;
            font-weight: 700;
            color: white !important;
            text-decoration: none;
        }

        .navbar-brand i {
            color: var(--cream);
            margin-right: 0.5rem;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .nav-link {
            color: white !important;
            text-decoration: none;
            font-weight: 500;
            padding: 0.5rem 1.5rem;
            border-radius: 25px;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, 0.2);
            color: white !important;
        }

        .nav-link.btn-login {
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .nav-link.btn-register {
            background: var(--cream);
            color: var(--primary-green) !important;
            font-weight: 600;
        }

        .nav-link.btn-register:hover {
            background: white;
            transform: translateY(-2px);
        }

        .hero-content {
            max-width: 800px;
            text-align: center;
            color: white;
            z-index: 10;
            position: relative;
        }

        .hero-title {
            font-size: 4rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            line-height: 1.2;
            text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }

        .hero-subtitle {
            font-size: 1.4rem;
            margin-bottom: 3rem;
            opacity: 0.95;
            font-weight: 400;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        .hero-buttons {
            display: flex;
            gap: 1.5rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .hero-btn {
            padding: 1rem 2.5rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .hero-btn.primary {
            background: white;
            color: var(--primary-green);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
        }

        .hero-btn.primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
            color: var(--primary-green);
        }

        .hero-btn.secondary {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .hero-btn.secondary:hover {
            background: rgba(255, 255, 255, 0.3);
            color: white;
            transform: translateY(-3px);
        }

        .features-section {
            padding: 5rem 0;
            background: var(--cream);
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 3rem;
            margin-top: 3rem;
        }

        .feature-card {
            background: white;
            border-radius: 20px;
            padding: 2.5rem;
            text-align: center;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border: 1px solid rgba(45, 138, 79, 0.1);
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2rem;
            color: white;
        }

        .feature-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--dark-green);
        }

        .feature-description {
            color: #666;
            line-height: 1.6;
        }

        .section-title {
            text-align: center;
            font-size: 3rem;
            font-weight: 700;
            color: var(--dark-green);
            margin-bottom: 1rem;
        }

        .section-subtitle {
            text-align: center;
            font-size: 1.2rem;
            color: #666;
            max-width: 600px;
            margin: 0 auto;
        }

        .stats-section {
            background: var(--primary-green);
            color: white;
            padding: 4rem 0;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            text-align: center;
        }

        .stat-item h3 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .stat-item p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .cta-section {
            background: linear-gradient(135deg, var(--dark-green), var(--primary-green));
            color: white;
            padding: 5rem 0;
            text-align: center;
        }

        .cta-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .cta-subtitle {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        .footer {
            background: #1a1a1a;
            color: white;
            padding: 3rem 0 1rem;
            text-align: center;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .footer-section h5 {
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--cream);
        }

        .footer-section a {
            color: #ccc;
            text-decoration: none;
            display: block;
            margin-bottom: 0.5rem;
            transition: color 0.3s ease;
        }

        .footer-section a:hover {
            color: var(--secondary-green);
        }

        .floating-shapes {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 1;
        }

        .shape {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        .shape:nth-child(1) {
            width: 100px;
            height: 100px;
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .shape:nth-child(2) {
            width: 150px;
            height: 150px;
            top: 60%;
            right: 10%;
            animation-delay: 2s;
        }

        .shape:nth-child(3) {
            width: 80px;
            height: 80px;
            bottom: 20%;
            left: 20%;
            animation-delay: 4s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .hero-subtitle {
                font-size: 1.1rem;
            }
            
            .hero-buttons {
                flex-direction: column;
                align-items: center;
            }
            
            .nav-links {
                gap: 1rem;
            }
            
            .features-grid {
                grid-template-columns: 1fr;
            }
            
            .section-title {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center w-100">
                <a href="/" class="navbar-brand">
                    <i class="fas fa-cow"></i>
                    DairyFarm Pro
                </a>
                
                @if (Route::has('login'))
                    <div class="nav-links">
                        @auth
                            <a href="{{ url('/home') }}" class="nav-link">
                                <i class="fas fa-home me-1"></i>Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="nav-link btn-login">
                                <i class="fas fa-sign-in-alt me-1"></i>Login
                            </a>
                            
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="nav-link btn-register">
                                    <i class="fas fa-user-plus me-1"></i>Get Started
                                </a>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="floating-shapes">
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
        </div>
        
        <div class="container">
            <div class="hero-content mx-auto">
                <h1 class="hero-title">Modern Dairy Farm Management</h1>
                <p class="hero-subtitle">
                    Streamline your dairy operations with our comprehensive management system. 
                    Track cattle, monitor milk production, manage health records, and boost your farm's productivity.
                </p>
                
                <div class="hero-buttons">
                    @guest
                        <a href="{{ route('register') }}" class="hero-btn primary">
                            <i class="fas fa-rocket"></i>
                            Start Free Trial
                        </a>
                        <a href="#features" class="hero-btn secondary">
                            <i class="fas fa-play"></i>
                            Learn More
                        </a>
                    @else
                        <a href="{{ url('/home') }}" class="hero-btn primary">
                            <i class="fas fa-tachometer-alt"></i>
                            Go to Dashboard
                        </a>
                    @endguest
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="features-section">
        <div class="container">
            <h2 class="section-title">Why Choose DairyFarm Pro?</h2>
            <p class="section-subtitle">
                Everything you need to manage your dairy farm efficiently in one powerful platform
            </p>
            
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-cow"></i>
                    </div>
                    <h3 class="feature-title">Cattle Management</h3>
                    <p class="feature-description">
                        Complete cattle tracking with breeding records, health monitoring, and productivity analytics. 
                        Keep detailed profiles for each animal.
                    </p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-glass-whiskey"></i>
                    </div>
                    <h3 class="feature-title">Milk Production</h3>
                    <p class="feature-description">
                        Track daily milk production, analyze trends, and optimize output. 
                        Generate detailed reports for better decision making.
                    </p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-heartbeat"></i>
                    </div>
                    <h3 class="feature-title">Health Records</h3>
                    <p class="feature-description">
                        Maintain comprehensive health records, vaccination schedules, and veterinary visits. 
                        Never miss an important health checkup.
                    </p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-wheat-awn"></i>
                    </div>
                    <h3 class="feature-title">Feed Management</h3>
                    <p class="feature-description">
                        Optimize feed consumption, track nutrition programs, and manage feed inventory. 
                        Ensure your cattle get the best nutrition.
                    </p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3 class="feature-title">Analytics & Reports</h3>
                    <p class="feature-description">
                        Comprehensive analytics dashboard with insights into productivity, profitability, 
                        and operational efficiency.
                    </p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="feature-title">Team Management</h3>
                    <p class="feature-description">
                        Manage your farm staff, assign tasks, track performance, and maintain 
                        employee records efficiently.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-item">
                    <h3>500+</h3>
                    <p>Farms Using Our System</p>
                </div>
                <div class="stat-item">
                    <h3>50K+</h3>
                    <p>Cattle Managed</p>
                </div>
                <div class="stat-item">
                    <h3>1M+</h3>
                    <p>Liters Tracked</p>
                </div>
                <div class="stat-item">
                    <h3>99.9%</h3>
                    <p>Uptime Reliability</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <h2 class="cta-title">Ready to Transform Your Dairy Farm?</h2>
            <p class="cta-subtitle">Join hundreds of farmers who have modernized their operations with DairyFarm Pro</p>
            
            @guest
                <a href="{{ route('register') }}" class="hero-btn primary">
                    <i class="fas fa-arrow-right"></i>
                    Get Started Today
                </a>
            @else
                <a href="{{ url('/home') }}" class="hero-btn primary">
                    <i class="fas fa-tachometer-alt"></i>
                    Access Your Dashboard
                </a>
            @endguest
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h5>DairyFarm Pro</h5>
                    <p>Modern dairy farm management for the digital age. Streamline operations and boost productivity.</p>
                </div>
                <div class="footer-section">
                    <h5>Features</h5>
                    <a href="#">Cattle Management</a>
                    <a href="#">Milk Production</a>
                    <a href="#">Health Records</a>
                    <a href="#">Feed Management</a>
                </div>
                <div class="footer-section">
                    <h5>Support</h5>
                    <a href="#">Help Center</a>
                    <a href="#">Documentation</a>
                    <a href="#">Contact Us</a>
                    <a href="#">Training</a>
                </div>
                <div class="footer-section">
                    <h5>Connect</h5>
                    <a href="#"><i class="fab fa-facebook me-2"></i>Facebook</a>
                    <a href="#"><i class="fab fa-twitter me-2"></i>Twitter</a>
                    <a href="#"><i class="fab fa-linkedin me-2"></i>LinkedIn</a>
                    <a href="#"><i class="fab fa-youtube me-2"></i>YouTube</a>
                </div>
            </div>
            
            <div class="border-top pt-3 mt-3">
                <p>&copy; 2025 DairyFarm Pro. All rights reserved. | Privacy Policy | Terms of Service</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Add scroll effect to navbar
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 100) {
                navbar.style.background = 'rgba(45, 138, 79, 0.95)';
            } else {
                navbar.style.background = 'rgba(255, 255, 255, 0.1)';
            }
        });
    </script>
</body>
</html>
