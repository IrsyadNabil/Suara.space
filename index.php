<?php
session_start();
$is_logged_in = isset($_SESSION['logged_in']) && $_SESSION['logged_in'];
$user_name = $_SESSION['user_name'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suara.Space - Music made for Creativity</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
            overflow-x: hidden;
            background: #000000;
        }

        .container {
            position: relative;
            min-height: 100vh;
            background: linear-gradient(#000000 100%);
        }

        /* Header Navigation - UPDATED */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 60px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            background: rgba(10, 10, 10, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            transition: background 0.3s;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            color: white;
            font-size: 22px;
            font-weight: 600;
            text-decoration: none;
            transition: transform 0.3s;
        }

        .logo:hover {
            transform: scale(1.05);
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: #0a0a0a;
            font-size: 20px;
        }

        .nav-links {
            display: flex;
            gap: 35px;
            align-items: center;
        }

        .nav-links a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            font-size: 15px;
            transition: color 0.3s;
            position: relative;
            padding-bottom: 5px;
        }

        .nav-links a:hover {
            color: white;
        }

        .nav-links a.active {
            color: white;
        }

        .nav-links a.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, #a855f7, #6366f1);
            animation: slideIn 0.3s ease;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            color: white;
            font-size: 14px;
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, #a855f7, #6366f1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: white;
        }

        @keyframes slideIn {
            from {
                width: 0;
                left: 50%;
            }
            to {
                width: 100%;
                left: 0;
            }
        }

        .btn-app {
            padding: 12px 28px;
            background: white;
            color: #0a0a0a;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s;
            letter-spacing: 0.5px;
        }

        .btn-app:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(255, 255, 255, 0.2);
            background: #f0f0f0;
        }

        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            color: white;
            font-size: 24px;
            cursor: pointer;
            padding: 5px;
        }

        .hero {
            position: relative;
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 8rem 4rem 2rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        .hero-content {
            flex: 1;
            max-width: 580px;
        }

        .hero h1 {
            font-size: 4.5rem;
            font-weight: 800;
            color: #fff;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            letter-spacing: -0.02em;
        }

        .highlight {
            position: relative;
            display: inline-block;
            min-width: 380px;
        }

        .highlight::after {
            content: '';
            position: absolute;
            bottom: 8px;
            left: 0;
            right: 0;
            height: 18px;
            background: #4f46e5;
            z-index: -1;
            transition: all 0.4s ease;
        }

        .text-rotate {
            display: inline-block;
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        .hero p {
            font-size: 1.25rem;
            color: rgba(255, 255, 255, 0.8);
            line-height: 1.6;
            margin-bottom: 2.5rem;
        }

        .cta-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.8rem;
            background: #fff;
            color: #000;
            padding: 1rem 2rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            transition: transform 0.2s, box-shadow 0.2s;
            letter-spacing: 0.3px;
        }

        .cta-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(255, 255, 255, 0.3);
        }

        .hero-visual {
            flex: 1;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .person-illustration {
            position: relative;
            width: 450px;
            height: 450px;
        }

        .glow {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(168, 85, 247, 0.4) 0%, transparent 70%);
            border-radius: 50%;
            filter: blur(40px);
            animation: pulse 3s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% {
                transform: translate(-50%, -50%) scale(1);
                opacity: 0.6;
            }
            50% {
                transform: translate(-50%, -50%) scale(1.1);
                opacity: 0.8;
            }
        }

        .person {
            position: relative;
            z-index: 2;
        }

        .head {
            width: 100px;
            height: 110px;
            background: linear-gradient(135deg, #b794f6 0%, #a78bfa 100%);
            border-radius: 50% 50% 45% 45%;
            position: absolute;
            top: 80px;
            left: 175px;
        }

        .hair {
            width: 70px;
            height: 80px;
            background: #1e1b4b;
            border-radius: 50% 50% 0 0;
            position: absolute;
            top: -20px;
            left: 15px;
        }

        .headphones {
            width: 130px;
            height: 130px;
            border: 18px solid #f3f4f6;
            border-radius: 50%;
            position: absolute;
            top: 70px;
            left: 160px;
        }

        .body {
            width: 140px;
            height: 160px;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            border-radius: 40px 40px 0 0;
            position: absolute;
            top: 180px;
            left: 155px;
        }

        .arm-left {
            width: 60px;
            height: 120px;
            background: linear-gradient(135deg, #60a5fa 0%, #3b82f6 100%);
            border-radius: 30px;
            position: absolute;
            top: 200px;
            left: 125px;
            transform: rotate(-15deg);
        }

        .arm-right {
            width: 65px;
            height: 130px;
            background: linear-gradient(135deg, #60a5fa 0%, #3b82f6 100%);
            border-radius: 30px;
            position: absolute;
            top: 200px;
            left: 260px;
            transform: rotate(25deg);
        }

        .laptop {
            width: 180px;
            height: 100px;
            background: linear-gradient(135deg, #4b5563 0%, #374151 100%);
            border-radius: 8px;
            position: absolute;
            top: 310px;
            left: 135px;
            transform: perspective(600px) rotateX(25deg);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5);
        }

        .laptop::before {
            content: '';
            position: absolute;
            top: 8px;
            left: 8px;
            right: 8px;
            bottom: 8px;
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
            border-radius: 4px;
        }

        .categories {
            position: relative;
            z-index: 10;
            display: flex;
            justify-content: center;
            gap: 1.5rem;
            padding: 3rem 4rem;
            overflow-x: auto;
        }

        .category {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.9rem 1.5rem;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            white-space: nowrap;
        }

        .category:hover {
            background: rgba(255, 255, 255, 0.15);
            color: #fff;
            transform: translateY(-2px);
        }

        .category.active {
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
            border-color: rgba(255, 255, 255, 0.3);
        }

        .icon {
            width: 18px;
            height: 18px;
            opacity: 0.8;
        }

        @media (max-width: 1024px) {
            .hero {
                flex-direction: column;
                text-align: center;
                padding: 6rem 2rem 2rem;
            }

            .hero h1 {
                font-size: 3rem;
            }

            .person-illustration {
                width: 350px;
                height: 350px;
            }

            .header {
                padding: 20px 30px;
            }

            .nav-links {
                display: none;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                flex-direction: column;
                background: rgba(10, 10, 10, 0.98);
                padding: 20px;
                gap: 20px;
                border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            }

            .nav-links.active {
                display: flex;
            }

            .mobile-menu-btn {
                display: block;
            }
        }

        @media (max-width: 768px) {
            .btn-app {
                padding: 10px 20px;
                font-size: 13px;
            }

            .logo {
                font-size: 18px;
            }

            .logo-icon {
                width: 35px;
                height: 35px;
                font-size: 18px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="bg-gradient"></div>

        <!-- NAVBAR UPDATED -->
        <header class="header">
            <a href="index.php" class="logo">
                <div class="logo-icon">S</div>
                Suara.Space
            </a>
            <nav class="nav-links" id="navLinks">
                <a href="index.php" class="active">Home</a>
                <a href="science.php">Our Science</a>
                <a href="about_us.php">About Us</a>
            </nav>
            
            <?php if ($is_logged_in): ?>
                <div class="user-info">
                    <div class="user-avatar">
                        <?php echo strtoupper(substr($user_name, 0, 1)); ?>
                    </div>
                    <span>Hi, <?php echo htmlspecialchars($user_name); ?></span>
                </div>
                <a href="menu_lagu.php" class="btn-app">OPEN APP</a>
            <?php else: ?>
                <button class="mobile-menu-btn" onclick="toggleMobileMenu()">☰</button>
                <a href="sign_in.php" class="btn-app">SIGN IN</a>
            <?php endif; ?>
        </header>

        <div class="hero">
            <div class="hero-content">
                <h1>Music made for <span class="highlight"><span class="text-rotate" id="rotatingText">Creativity</span></span></h1>
                <p>The only music app made with modes for different activities in your life.</p>
                <!-- UBAH LINK INI -->
                <a href="<?php echo $is_logged_in ? 'menu_lagu.php' : 'sign_up.php'; ?>" class="cta-btn">
                    try Suara.Space now
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                        <path d="M5 12h14M12 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

            <div class="hero-visual">
                <div class="person-illustration">
                    <div class="glow"></div>
                    <div class="person">
                        <div class="headphones"></div>
                        <div class="head">
                            <div class="hair"></div>
                        </div>
                        <div class="body"></div>
                        <div class="arm-left"></div>
                        <div class="arm-right"></div>
                        <div class="laptop"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="categories">
            <div class="category">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="3" width="7" height="7" />
                    <rect x="14" y="3" width="7" height="7" />
                    <rect x="14" y="14" width="7" height="7" />
                    <rect x="3" y="14" width="7" height="7" />
                </svg>
                DEEP WORK
            </div>
            <div class="category active">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="3" />
                    <path d="M12 5v2M12 17v2M5 12h2M17 12h2" />
                </svg>
                CREATIVITY
            </div>
            <div class="category">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z" />
                    <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z" />
                </svg>
                LEARNING
            </div>
            <div class="category">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10" />
                    <polyline points="12 6 12 12 16 14" />
                </svg>
                LIGHT WORK
            </div>
            <div class="category">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z" />
                </svg>
                MOTIVATION
            </div>
            <div class="category">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M9.59 4.59A2 2 0 1 1 11 8H2m10.59 11.41A2 2 0 1 0 14 16H2" />
                </svg>
                UNWIND
            </div>
            <div class="category">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" />
                </svg>
                RELAX
            </div>
        </div>
    </div>

    <script>
        // Rotating text animation
        const words = ['Creativity', 'Motivation', 'Deep Learning', 'Study'];
        let currentIndex = 0;
        const rotatingText = document.getElementById('rotatingText');

        function rotateText() {
            currentIndex = (currentIndex + 1) % words.length;
            rotatingText.style.opacity = '0';
            rotatingText.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                rotatingText.textContent = words[currentIndex];
                rotatingText.style.opacity = '1';
                rotatingText.style.transform = 'translateY(0)';
            }, 300);
        }

        setInterval(rotateText, 1500);

        // Category click handler
        const categories = document.querySelectorAll('.category');

        categories.forEach(cat => {
            cat.addEventListener('click', function() {
                categories.forEach(c => c.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Mobile menu toggle
        function toggleMobileMenu() {
            const navLinks = document.getElementById('navLinks');
            navLinks.classList.toggle('active');
        }

        // Header background on scroll
        window.addEventListener('scroll', () => {
            const header = document.querySelector('.header');
            if (window.scrollY > 50) {
                header.style.background = 'rgba(10, 10, 10, 0.98)';
            } else {
                header.style.background = 'rgba(10, 10, 10, 0.95)';
            }
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', (e) => {
            const navLinks = document.getElementById('navLinks');
            if (!e.target.closest('.header')) {
                navLinks.classList.remove('active');
            }
        });

        // Close mobile menu when clicking a link
        document.querySelectorAll('.nav-links a').forEach(link => {
            link.addEventListener('click', () => {
                document.getElementById('navLinks').classList.remove('active');
            });
        });
    </script>
</body>

</html>