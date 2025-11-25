<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Science you can hear - Suara.Space</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: #000;
            color: #fff;
            overflow-x: hidden;
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
            width: 100%;
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
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 120px 20px 60px;
            position: relative;
            background: radial-gradient(ellipse at center, #1a1a2e 0%, #000 70%);
        }

        .hero-title {
            font-size: 72px;
            font-weight: 700;
            margin-bottom: 20px;
            background: linear-gradient(135deg, #fff 0%, #a78bfa 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-subtitle {
            font-size: 20px;
            color: #9ca3af;
            max-width: 600px;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .hero-imageSC {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin: 20px 0;
        }

        .hero-image-item {
            width: 280px;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            object-fit: cover;
        }

        .section {
            padding: 100px 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .section-title {
            font-size: 48px;
            font-weight: 700;
            text-align: center;
            margin-bottom: 60px;
            background: linear-gradient(135deg, #fff 0%, #a78bfa 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 40px;
            margin-top: 60px;
        }

        .feature-card {
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.1) 0%, rgba(139, 92, 246, 0.1) 100%);
            border: 1px solid rgba(99, 102, 241, 0.2);
            border-radius: 24px;
            padding: 40px;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 60px rgba(99, 102, 241, 0.3);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            border-radius: 20px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            object-fit: cover;
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            position: relative;
        }

        .feature-icon::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: inherit;
            opacity: 0.2;
            border-radius: inherit;
        }

        .feature-title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 12px;
        }

        .feature-desc {
            color: #9ca3af;
            line-height: 1.6;
            font-size: 15px;
        }

        .product-showcase {
            background: radial-gradient(ellipse at center, #1a1a2e 0%, #000 70%);
            padding: 100px 20px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            position: relative;
        }

        .performance-section {
            background: linear-gradient(135deg,
                    rgba(99, 102, 241, 0.05) 0%,
                    rgba(139, 92, 246, 0.15) 100%);
            border-radius: 24px;
            padding: 60px 40px;
            width: 100%;
            margin: 0;
            border: 1px solid rgba(99, 102, 241, 0.1);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            display: block;
        }

        .performance-title {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 16px;
            color: #fff;
            text-align: left;
            background: linear-gradient(135deg, #fff 0%, #a78bfa 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1.2;
        }

        .performance-subtitle {
            font-size: 36px;
            font-weight: 700;
            margin: 20px 0 30px;
            color: #fff;
            text-align: left;
        }

        .performance-desc {
            font-size: 18px;
            color: #9ca3af;
            line-height: 1.6;
            text-align: left;
            margin-bottom: 40px;
            max-width: 600px;
        }

        .read-science-btn {
            display: inline-block;
            background: linear-gradient(135deg,
                    rgba(99, 102, 241, 0.2) 0%,
                    rgba(139, 92, 246, 0.1) 100%);
            color: #a78bfa;
            padding: 16px 40px;
            border-radius: 50px;
            text-decoration: none;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: 1px solid rgba(99, 102, 241, 0.3);
            text-align: center;
            backdrop-filter: blur(10px);
            align-self: flex-start;
            margin-top: 20px;
        }

        .read-science-btn:hover {
            background: linear-gradient(135deg,
                    rgba(99, 102, 241, 0.3) 0%,
                    rgba(139, 92, 246, 0.2) 100%);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(99, 102, 241, 0.2);
        }

        .waveform {
            width: 100%;
            height: 200px;
            margin: 60px 0;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
        }

        .wave-bar {
            width: 20px;
            background: linear-gradient(135deg, #f163d7ff 0%, #8b5cf6 100%);
            border-radius: 4px;
            height: 20px;
            animation: wave 1.5s ease-in-out infinite;
        }

        @keyframes wave {
            0%, 100% {
                height: 20px;
            }
            50% {
                height: 160px;
            }
        }

        .wave-bar:nth-child(2) { animation-delay: 0.1s; }
        .wave-bar:nth-child(3) { animation-delay: 0.2s; }
        .wave-bar:nth-child(4) { animation-delay: 0.3s; }
        .wave-bar:nth-child(5) { animation-delay: 0.4s; }
        .wave-bar:nth-child(6) { animation-delay: 0.3s; }
        .wave-bar:nth-child(7) { animation-delay: 0.2s; }
        .wave-bar:nth-child(8) { animation-delay: 0.1s; }

        .stats-section {
            padding: 100px 20px;
            text-align: center;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 50px;
            max-width: 1000px;
            margin: 60px auto 0;
        }

        .stat-item {
            padding: 30px;
        }

        .stat-number {
            font-size: 56px;
            font-weight: 700;
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 10px;
        }

        .stat-label {
            color: #9ca3af;
            font-size: 16px;
        }

        .testimonials {
            background: #0a0a0a;
            padding: 100px 20px;
        }

        .testimonial-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .testimonial-card {
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.05) 0%, rgba(139, 92, 246, 0.05) 100%);
            border: 1px solid rgba(99, 102, 241, 0.1);
            border-radius: 20px;
            padding: 30px;
            display: flex;
            flex-direction: column;
        }

        .testimonial-text {
            color: #fff;
            line-height: 1.8;
            margin-bottom: 20px;
            font-size: 20px;
            font-weight: 700;
        }

        .testimonial-author {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }

        .author-name {
            color: #6b7280;
            font-weight: 600;
            font-size: 14px;
        }

        .read-article {
            color: rgba(134, 136, 251, 1);
            text-decoration: none;
            font-size: 20px;
            font-weight: 600;
            transition: color 0.3s;
        }

        .read-article:hover {
            color: #8b5cf6;
        }

        .footer {
            background: #0a0a0a;
            padding: 60px 20px 30px;
            border-top: 1px solid rgba(99, 102, 241, 0.1);
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 40px;
            margin-bottom: 40px;
        }

        .footer-section h3 {
            margin-bottom: 20px;
            font-size: 18px;
        }

        .footer-section a {
            display: block;
            color: #9ca3af;
            text-decoration: none;
            margin-bottom: 10px;
            font-size: 14px;
            transition: color 0.3s;
        }

        .footer-section a:hover {
            color: #6366f1;
        }

        .footer-bottom {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid rgba(99, 102, 241, 0.1);
            color: #6b7280;
            font-size: 14px;
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 42px;
            }

            .section-title {
                font-size: 32px;
            }

            .feature-grid {
                grid-template-columns: 1fr;
            }

            .performance-section {
                padding: 40px 20px;
                border-radius: 16px;
            }

            .performance-title {
                font-size: 20px;
            }

            .performance-subtitle {
                font-size: 28px;
            }

            .performance-desc {
                font-size: 16px;
            }

            .read-science-btn {
                padding: 14px 30px;
                font-size: 14px;
                align-self: flex-start;
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
    <!-- NAVBAR UPDATED -->
    <header class="header">
        <a href="index.php" class="logo">
            <div class="logo-icon">S</div>
            Suara.Space
        </a>
        <nav class="nav-links" id="navLinks">
            <a href="index.php">Home</a>
            <a href="science.php" class="active">Our Science</a>
            <a href="about_us.php">About Us</a>
        </nav>
        <button class="mobile-menu-btn" onclick="toggleMobileMenu()">☰</button>
        <a href="sign_in.php" class="btn-app">SIGN IN</a>
    </header>

    <section class="hero">
        <h1 class="hero-title">Science you can hear</h1>
        <p class="hero-subtitle">
            Experience revolutionary audio technology backed by biomedical research.
            Personalized neural stimulation meets premium sound quality.
        </p>
        <div class="hero-imageSC">
            <img src="hp1.jpg" alt="Headphone man1" class="hero-image-item">
            <img src="hp2.jpg" alt="Headphone man2" class="hero-image-item">
            <img src="hp3.jpg" alt="Headphone man3" class="hero-image-item">
        </div>
    </section>

    <section class="section">
        <h2 class="section-title">Play the ultimate hearing test with <br>plurallistic controls</h2>
        <div class="feature-grid">
            <div class="feature-card">
                <img src="bio.jpg.jpg" alt="Ikon analisis biomedis" class="feature-icon">
                <h3 class="feature-title">Biomedical analysis</h3>
                <p class="feature-desc">Advanced algorithms analyze your unique hearing profile to deliver personalized neural stimulation.</p>
            </div>

            <div class="feature-card">
                <img src="brain.jpeg.jpg" alt="Ikon monitoring EEG" class="feature-icon">
                <h3 class="feature-title">In-base EEG analysis</h3>
                <p class="feature-desc">Real-time brainwave monitoring ensures optimal stimulation patterns for your brain.</p>
            </div>

            <div class="feature-card">
                <img src="ai.jpg.jpg" alt="Ikon adaptasi AI" class="feature-icon">
                <h3 class="feature-title">Supervised learning</h3>
                <p class="feature-desc">AI-powered adaptation that learns from your preferences to continuously improve your experience.</p>
            </div>
        </div>
    </section>

    <section class="product-showcase">
        <div class="performance-section">
            <h2 class="performance-title">How do we know Suara.Space works?</h2>
            <h3 class="performance-subtitle">Performance testing with placebo controls</h3>
            <p class="performance-desc">
                We test our music with simple games used to measure focused attention in psychology research.
                Our experiments always include a control (placebo) of the same music without Suara.Space technology,
                so we can be sure our tech is what makes the difference.
            </p>
            <a href="#science" class="read-science-btn">READ THE LATEST SCIENCE</a>
        </div>
    </section>

    <section class="section">
        <h2 class="section-title">Patented neural entertainment</h2>
        <div class="waveform">
            <div class="wave-bar"></div>
            <div class="wave-bar"></div>
            <div class="wave-bar"></div>
            <div class="wave-bar"></div>
            <div class="wave-bar"></div>
            <div class="wave-bar"></div>
            <div class="wave-bar"></div>
            <div class="wave-bar"></div>
        </div>
        <p style="text-align: center; color: #9ca3af; max-width: 700px; margin: 0 auto; line-height: 1.8;">
            Our proprietary technology uses precisely calibrated frequencies to stimulate neural pathways,
            enhancing cognitive function and promoting states of focused relaxation.
        </p>
    </section>

    <section class="stats-section">
        <h2 class="section-title">Trusted by innovators worldwide</h2>
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-number">98%</div>
                <div class="stat-label">User satisfaction</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">50K+</div>
                <div class="stat-label">Active users</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">15+</div>
                <div class="stat-label">Research papers</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">24/7</div>
                <div class="stat-label">Neural tracking</div>
            </div>
        </div>
    </section>

    <section class="testimonials" id="reviews">
        <h2 class="section-title">Supporting literature</h2>
        <div class="testimonial-grid">
            <div class="testimonial-card">
                <p class="testimonial-text">Preferred stimulation levels in introverts and extroverts: Effects on arousal and performance.</p>
                <div class="testimonial-author">
                    <div class="author-name">Geen, R. G. (1984)</div>
                    <br>
                    <a href="#" class="read-article">Read article</a>
                </div>
            </div>
            <div class="testimonial-card">
                <p class="testimonial-text">Cortical activity patterns in ADHD during arousal, activation and sustained attention.</p>
                <div class="testimonial-author">
                    <div class="author-name">Loo, S. K. et al. (2009)</div>
                    <br>
                    <a href="#" class="read-article">Read article</a>
                </div>
            </div>
            <div class="testimonial-card">
                <p class="testimonial-text">The differential distraction of background music on the cognitive test performance of introvert and extravert.</p>
                <div class="testimonial-author">
                    <div class="author-name">Furnham, A. & Bradley, A. (1997)</div>
                    <br>
                    <a href="#" class="read-article">Read article</a>
                </div>
            </div>
        </div>
    </section>

    <section class="section" id="science">
        <h2 class="section-title">Read our science</h2>
        <div class="feature-grid">
            <div class="feature-card">
                <h3 class="feature-title">Neural Plasticity Research</h3>
                <p class="feature-desc">Published studies on how targeted audio stimulation can enhance neuroplasticity and cognitive performance.</p>
            </div>
            <div class="feature-card">
                <h3 class="feature-title">Brainwave Optimization</h3>
                <p class="feature-desc">Peer-reviewed findings on EEG-guided audio therapy for stress reduction and mental clarity.</p>
            </div>
            <div class="feature-card">
                <h3 class="feature-title">Personalized Acoustics</h3>
                <p class="feature-desc">Research on machine learning algorithms that adapt sound profiles to individual hearing characteristics.</p>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h3>Product</h3>
                <a href="#">Features</a>
                <a href="#">Technology</a>
                <a href="#">Pricing</a>
                <a href="#">Reviews</a>
            </div>
            <div class="footer-section">
                <h3>Research</h3>
                <a href="#">Publications</a>
                <a href="#">Clinical Trials</a>
                <a href="#">White Papers</a>
                <a href="#">Case Studies</a>
            </div>
            <div class="footer-section">
                <h3>Company</h3>
                <a href="about_us.html">About Us</a>
                <a href="#">Team</a>
                <a href="#">Careers</a>
                <a href="#">Contact</a>
            </div>
            <div class="footer-section">
                <h3>Support</h3>
                <a href="#">Help Center</a>
                <a href="#">Documentation</a>
                <a href="#">Privacy Policy</a>
                <a href="#">Terms of Service</a>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© 2025 Suara.Space. All rights reserved.</p>
        </div>
    </footer>

    <script>
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