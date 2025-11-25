<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Suara.Space</title>
    <style>

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

/* Mobile Menu Toggle */
.mobile-menu-btn {
    display: none;
    background: none;
    border: none;
    color: white;
    font-size: 24px;
    cursor: pointer;
    padding: 5px;
}

/* Responsive */
@media (max-width: 768px) {
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

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #000000;
            color: white;
            overflow-x: hidden;
        }

        /* Header Navigation */
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
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            color: white;
            font-size: 22px;
            font-weight: 600;
            text-decoration: none;
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
            bottom: -8px;
            left: 0;
            right: 0;
            height: 2px;
            background: white;
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
        }

        /* Hero Section */
        .hero {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 120px 60px 80px;
            position: relative;
            background: #000000;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 20%;
            right: -10%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(138, 43, 226, 0.15) 0%, transparent 70%);
            border-radius: 50%;
            animation: pulse 8s ease-in-out infinite;
        }

        .hero::after {
            content: '';
            position: absolute;
            bottom: 20%;
            left: -10%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(75, 0, 130, 0.1) 0%, transparent 70%);
            border-radius: 50%;
            animation: pulse 10s ease-in-out infinite reverse;
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
                opacity: 0.3;
            }
            50% {
                transform: scale(1.1);
                opacity: 0.5;
            }
        }

        .hero-content {
            max-width: 900px;
            text-align: center;
            position: relative;
            z-index: 10;
            margin-bottom: 60px;
        }

        .hero h1 {
            font-size: 68px;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 30px;
            letter-spacing: -1px;
        }

        .hero-subtitle {
            font-size: 20px;
            color: rgba(255, 255, 255, 0.7);
            line-height: 1.6;
            margin-bottom: 15px;
        }

        .hero-description {
            font-size: 20px;
            color: rgba(255, 255, 255, 0.7);
            line-height: 1.6;
        }

        .hero-illustration {
            position: relative;
            width: 600px;
            height: 400px;
            margin-top: 40px;
        }

        .illustration-img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        /* Mission Section */
        .mission-section {
            padding: 120px 60px;
            background: #0a0a0a;
            position: relative;
        }

        .mission-content {
            max-width: 1000px;
            margin: 0 auto;
        }

        .mission-section h2 {
            font-size: 42px;
            margin-bottom: 40px;
            font-weight: 700;
        }

        .mission-text {
            font-size: 18px;
            line-height: 1.8;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 30px;
        }

        .highlight {
            color: #a855f7;
            font-weight: 600;
        }

        /* Team Section */
        .team-section {
            padding: 120px 60px;
            background: #000000;
        }

        .team-header {
            text-align: center;
            margin-bottom: 80px;
        }

        .team-header h2 {
            font-size: 48px;
            font-weight: 700;
            margin-bottom: 20px;
            text-transform: lowercase;
        }

        .team-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 60px;
            max-width: 900px;
            margin: 0 auto;
        }

        .team-member {
            text-align: center;
            padding: 40px 30px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s;
            backdrop-filter: blur(10px);
        }

        .team-member:hover {
            transform: translateY(-8px);
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(168, 85, 247, 0.4);
            box-shadow: 0 15px 40px rgba(168, 85, 247, 0.2);
        }

        .member-photo {
            width: 400px;
            height: 400px;
            border-radius: 16px;
            margin: 0 auto 25px;
            overflow: hidden;
            border: 3px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s;
        }

        .team-member:hover .member-photo {
            border-color: rgba(168, 85, 247, 0.5);
            box-shadow: 0 10px 30px rgba(168, 85, 247, 0.3);
        }

        .member-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .member-photo.placeholder {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 64px;
            font-weight: 600;
            color: white;
        }

        .member-name {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 8px;
            color: white;
        }

        .member-role {
            font-size: 16px;
            color: rgba(255, 255, 255, 0.6);
        }

        /* Footer */
        .footer {
            padding: 60px;
            text-align: center;
            background: #0a0a0a;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }

        .footer-text {
            color: rgba(255, 255, 255, 0.5);
            font-size: 14px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .header {
                padding: 20px 30px;
            }

            .nav-links {
                display: none;
            }

            .hero {
                padding: 100px 30px 60px;
            }

            .hero h1 {
                font-size: 42px;
            }

            .hero-subtitle,
            .hero-description {
                font-size: 16px;
            }

            .hero-illustration {
                width: 100%;
                height: 300px;
            }

            .mission-section,
            .team-section {
                padding: 80px 30px;
            }

            .mission-section h2 {
                font-size: 32px;
            }

            .team-header h2 {
                font-size: 36px;
            }

            .team-grid {
                grid-template-columns: 1fr;
                gap: 40px;
                padding: 0 20px;
            }

            .member-photo {
                width: 150px;
                height: 150px;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <a href="index.php" class="logo">
            <div class="logo-icon">S</div>
            Suara.Space
        </a>
        <nav class="nav-links">
            <a href="index.php">Home</a>
            <a href="science.php">Our Science</a>
            <a href="about_us.php" class="active">About Us</a>
        </nav>
        <a href="sign_in.php" class="btn-app">SIGN IN</a>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>We're about making a positive impact.</h1>
            <p class="hero-subtitle">
                Music is usually made to grab your attention, which leads to distraction.
            </p>
            <p class="hero-description">
                We create music with a new approach, putting your needs first.
            </p>
        </div>
        <div class="hero-illustration">
            <img src="work.png" alt="Illustration" class="illustration-img">
        </div>
    </section>

    <!-- Mission Section -->
    <section class="mission-section">
        <div class="mission-content">
            <h2>Our Mission</h2>
            <p class="mission-text">
                Our mission is to help people around the world unlock their full potential. 
                Started as a focus-music company in 2024, <span class="highlight">Suara.Space</span> has already grown to support users 
                in all aspects of their lives, becoming a leading name in science-backed audio technology.
            </p>
            <p class="mission-text">
                Suara.Space believes that different brains have different needs, and that understanding a person 
                is key to helping them. The possibilities of noninvasive neurostimulation in the digital age are 
                limitless, and extend beyond music.
            </p>
            <p class="mission-text">
                We are pushing toward adjustment of brain states through sound, light, and touch, as well as 
                dynamic stimulation through biosensors. <span class="highlight">Radical personalization</span> is essential, as is learning 
                over time. For the first time in history we have the understanding and ability to shape our 
                brain activity for the better, to support anyone, anywhere.
            </p>
            <p class="mission-text">
                In addition, our mission is also to fulfill the requirements of the IF-G web practicum assignment.
            </p>
        </div>
    </section>

    <!-- Team Section -->
    <section class="team-section">
        <div class="team-header">
            <h2>Meet Our Team</h2>
        </div>
        <div class="team-grid">
            <div class="team-member">
                <div class="member-photo placeholder">
                    <img src="nabil.jpeg" alt="Irsyad Nabil" style="display:none;" onload="this.style.display='block'; this.parentElement.classList.remove('placeholder');">
                    AS
                </div>
                <div class="member-name">Irsyad Nabil</div>
                <div class="member-role">NIM 123240092</div>
            </div>
            <div class="team-member">
                <div class="member-photo placeholder">
                    <img src="rico.jpeg" alt="Jonathan Enrico" style="display:none;" onload="this.style.display='block'; this.parentElement.classList.remove('placeholder');">
                    BP
                </div>
                <div class="member-name">Jonathan Enrico</div>
                <div class="member-role">NIM 123240106</div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <p class="footer-text">© 2024 Suara.Space. All rights reserved.</p>
    </footer>

    <script>
        // Smooth scroll
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

        // Header background on scroll
        window.addEventListener('scroll', () => {
            const header = document.querySelector('.header');
            if (window.scrollY > 50) {
                header.style.background = 'rgba(10, 10, 10, 0.98)';
            } else {
                header.style.background = 'rgba(10, 10, 10, 0.95)';
            }
        });
    </script>
</body>
</html>