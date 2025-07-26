<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - DairyFarm Pro</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-green: #2d8a4f;
            --secondary-green: #4caf50;
            --accent-blue: #3498db;
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
            background: linear-gradient(135deg, 
                var(--primary-green) 0%, 
                var(--secondary-green) 50%, 
                var(--accent-blue) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow-x: hidden;
            padding: 1rem 0;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><rect fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="1" width="20" height="20" x="40" y="40"/></svg>');
            background-size: 60px 60px;
            opacity: 0.3;
            animation: move 20s linear infinite;
        }

        @keyframes move {
            0% { transform: translateX(0) translateY(0); }
            100% { transform: translateX(-60px) translateY(-60px); }
        }

        .login-container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 25px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .login-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            min-height: 90vh;
            max-height: 600px;
        }

        .login-image {
            background: linear-gradient(135deg, 
                rgba(45, 138, 79, 0.9), 
                rgba(76, 175, 80, 0.8)),
                url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><defs><pattern id="farm" x="0" y="0" width="100" height="100" patternUnits="userSpaceOnUse"><rect fill="%23f0f8f0" width="100" height="100"/><circle fill="%23e8f5e8" cx="50" cy="50" r="30" opacity="0.3"/></pattern></defs><rect fill="url(%23farm)" width="1000" height="1000"/></svg>');
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
            padding: 3rem;
            position: relative;
        }

        .login-image::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><rect fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="0.5" width="20" height="20" x="40" y="40"/></svg>');
            background-size: 40px 40px;
            opacity: 0.2;
        }

        .image-content {
            position: relative;
            z-index: 10;
        }

        .image-content h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }

        .image-content p {
            font-size: 1.1rem;
            opacity: 0.9;
            line-height: 1.6;
            margin-bottom: 2rem;
        }

        .feature-list {
            list-style: none;
            text-align: left;
        }

        .feature-list li {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            font-size: 1rem;
        }

        .feature-list li i {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
        }

        .login-form {
            padding: 4rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .form-header .logo {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-green);
            margin-bottom: 0.5rem;
        }

        .form-header .logo i {
            margin-right: 0.5rem;
        }

        .form-header h1 {
            font-size: 2rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }

        .form-header p {
            color: #6c757d;
            font-size: 1rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #2c3e50;
        }

        .form-control {
            width: 100%;
            padding: 1rem 1.5rem;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-green);
            background: white;
            box-shadow: 0 0 0 3px rgba(45, 138, 79, 0.1);
        }

        .form-control.is-invalid {
            border-color: #dc3545;
            background: #fff5f5;
        }

        .invalid-feedback {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }

        .form-check {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .form-check-input {
            margin-right: 0.5rem;
        }

        .form-check-label {
            color: #6c757d;
            cursor: pointer;
        }

        .btn-login {
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            color: white;
            border: none;
            padding: 1rem 2rem;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s ease;
            margin-bottom: 1.5rem;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(45, 138, 79, 0.3);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .forgot-password {
            text-align: center;
            margin-bottom: 2rem;
        }

        .forgot-password a {
            color: var(--primary-green);
            text-decoration: none;
            font-weight: 500;
        }

        .forgot-password a:hover {
            text-decoration: underline;
        }

        .register-link {
            text-align: center;
            padding-top: 2rem;
            border-top: 1px solid #e9ecef;
        }

        .register-link a {
            color: var(--primary-green);
            text-decoration: none;
            font-weight: 600;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        .floating-elements {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            pointer-events: none;
        }

        .floating-cow {
            position: absolute;
            color: rgba(255, 255, 255, 0.1);
            font-size: 2rem;
            animation: float 8s ease-in-out infinite;
        }

        .floating-cow:nth-child(1) {
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .floating-cow:nth-child(2) {
            top: 60%;
            right: 15%;
            animation-delay: 3s;
        }

        .floating-cow:nth-child(3) {
            bottom: 30%;
            left: 20%;
            animation-delay: 6s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-30px) rotate(10deg); }
        }

        @media (max-width: 768px) {
            .login-grid {
                grid-template-columns: 1fr;
                min-height: 0;
                max-height: none;
            }
            
            .login-image {
                min-height: 250px;
                padding: 2rem;
            }
            
            .image-content h2 {
                font-size: 2rem;
            }
            
            .login-form {
                padding: 2rem;
            }
            
            .form-header h1 {
                font-size: 1.5rem;
            }
        }

        @media (max-width: 576px) {
            .login-container {
                padding: 1rem;
            }
            
            .login-form {
                padding: 1.5rem;
            }
            
            .login-grid {
                min-height: 0;
            }
            
            .login-image {
                min-height: 200px;
            }
        }
    </style>
</head>
<body>
    <div class="floating-elements">
        <div class="floating-cow"><i class="fas fa-cow"></i></div>
        <div class="floating-cow"><i class="fas fa-tractor"></i></div>
        <div class="floating-cow"><i class="fas fa-wheat-awn"></i></div>
    </div>

    <div class="login-container">
        <div class="login-card">
            <div class="login-grid">
                <!-- Left Side - Image & Features -->
                <div class="login-image">
                    <div class="image-content">
                        <h2>Welcome to DairyFarm Pro</h2>
                        <p>Modern dairy farm management for the digital age. Streamline your operations and boost productivity.</p>
                        
                        <ul class="feature-list">
                            <li>
                                <i class="fas fa-cow"></i>
                                Complete cattle management system
                            </li>
                            <li>
                                <i class="fas fa-chart-line"></i>
                                Real-time production analytics
                            </li>
                            <li>
                                <i class="fas fa-heartbeat"></i>
                                Health monitoring & records
                            </li>
                            <li>
                                <i class="fas fa-mobile-alt"></i>
                                Mobile-friendly interface
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Right Side - Login Form -->
                <div class="login-form">
                    <div class="form-header">
                        <div class="logo">
                            <i class="fas fa-cow"></i>
                            DairyFarm Pro
                        </div>
                        <h1>Sign In</h1>
                        <p>Access your farm management dashboard</p>
                    </div>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group">
                            <label for="email" class="form-label">Email Address</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                   name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                                   placeholder="Enter your email address">

                            @error('email')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password" class="form-label">Password</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                                   name="password" required autocomplete="current-password"
                                   placeholder="Enter your password">

                            @error('password')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" 
                                   {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                Remember me for 30 days
                            </label>
                        </div>

                        <button type="submit" class="btn-login">
                            <i class="fas fa-sign-in-alt me-2"></i>
                            Sign In to Dashboard
                        </button>

                        @if (Route::has('password.request'))
                            <div class="forgot-password">
                                <a href="{{ route('password.request') }}">
                                    Forgot your password?
                                </a>
                            </div>
                        @endif

                        @if (Route::has('register'))
                            <div class="register-link">
                                <p>Don't have an account? <a href="{{ route('register') }}">Create one now</a></p>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Add some interactive effects
        document.addEventListener('DOMContentLoaded', function() {
            // Focus animation for form inputs
            const inputs = document.querySelectorAll('.form-control');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'scale(1.02)';
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.style.transform = 'scale(1)';
                });
            });

            // Button loading state
            const loginBtn = document.querySelector('.btn-login');
            const form = document.querySelector('form');
            
            form.addEventListener('submit', function() {
                loginBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Signing in...';
                loginBtn.disabled = true;
            });
        });
    </script>
</body>
</html>
