    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sign Up</title>
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
                background: url('backgroundsign.jpg') no-repeat center center fixed;
                background-size: cover;
                min-height: 100vh;
                display: flex;
                justify-content: center;
                align-items: center;
                position: relative;
                overflow: hidden;
            }

            .container {
                position: relative;
                z-index: 10;
                width: 100%;
                max-width: 1200px;
                padding: 20px;
            }

            /* Header */
            .header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 20px 40px;
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                z-index: 100;
            }

            .logo {
                display: flex;
                align-items: center;
                gap: 10px;
                color: white;
                font-size: 20px;
                font-weight: 600;
            }

            .logo-icon {
                width: 32px;
                height: 32px;
                background: white;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: bold;
                color: #1a1a2e;
            }

            .header-link {
                color: rgba(255, 255, 255, 0.8);
                text-decoration: none;
                font-size: 14px;
                transition: color 0.3s;
            }

            .header-link:hover {
                color: white;
            }

            .header-link.btn {
                color: white;
                font-weight: 600;
                margin-left: 20px;
            }

            /* Auth Container */
            .auth-container {
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
                gap: 60px;
            }

            /* Illustration */
            .illustration {
                flex: 1;
                max-width: 400px;
                text-align: center;
            }

            .illustration-image {
                width: 300px;
                height: 300px;
                margin: 0 auto 40px;
                position: relative;
            }

            .character-image {
                width: 400px;
                height: auto;
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                transition: opacity 0.5s ease, transform 0.5s ease;
                filter: drop-shadow(0 20px 40px rgba(0, 0, 0, 0.3));
            }

            .path {
                position: absolute;
                bottom: 30px;
                left: 50%;
                transform: translateX(-50%);
                width: 200px;
                height: 80px;
                background: linear-gradient(to right, transparent, rgba(236, 72, 153, 0.3), transparent);
                border-radius: 50%;
                filter: blur(15px);
            }

            .stars {
                position: absolute;
                width: 100%;
                height: 100%;
            }

            .star {
                position: absolute;
                width: 4px;
                height: 4px;
                background: white;
                border-radius: 50%;
                animation: twinkle 3s infinite;
            }

            .star:nth-child(1) {
                top: 20%;
                left: 15%;
                animation-delay: 0s;
            }

            .star:nth-child(2) {
                top: 40%;
                right: 20%;
                animation-delay: 0.5s;
            }

            .star:nth-child(3) {
                bottom: 30%;
                left: 25%;
                animation-delay: 1s;
            }

            .star:nth-child(4) {
                top: 60%;
                right: 15%;
                animation-delay: 1.5s;
            }

            .star:nth-child(5) {
                top: 30%;
                left: 40%;
                animation-delay: 0.3s;
            }

            .star:nth-child(6) {
                bottom: 50%;
                right: 30%;
                animation-delay: 1.2s;
            }

            @keyframes twinkle {
                0%, 100% {
                    opacity: 0.3;
                    transform: scale(1);
                }
                50% {
                    opacity: 1;
                    transform: scale(1.5);
                }
            }

            .illustration h2 {
                color: white;
                font-size: 32px;
                margin-bottom: 15px;
                font-weight: 600;
            }

            .illustration p {
                color: rgba(255, 255, 255, 0.7);
                font-size: 16px;
                line-height: 1.6;
            }

            .carousel-dots {
                display: flex;
                gap: 10px;
                justify-content: center;
                margin-top: 30px;
            }

            .dot {
                width: 40px;
                height: 3px;
                background: rgba(255, 255, 255, 0.3);
                border-radius: 2px;
                cursor: pointer;
                transition: all 0.3s;
            }

            .dot.active {
                background: white;
            }

            .dot:hover {
                background: rgba(255, 255, 255, 0.5);
            }

            .slide-content {
                transition: opacity 0.5s ease, transform 0.5s ease;
            }

            /* Auth Box */
            .auth-box {
                background: rgba(30, 30, 45, 0.8);
                backdrop-filter: blur(20px);
                border-radius: 20px;
                padding: 50px;
                width: 100%;
                max-width: 420px;
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
                border: 1px solid rgba(255, 255, 255, 0.1);
            }

            .auth-box h2 {
                color: white;
                text-align: center;
                margin-bottom: 35px;
                font-size: 28px;
                font-weight: 600;
            }

            /* Form Elements */
            .form-group {
                margin-bottom: 20px;
            }

            .input-wrapper {
                position: relative;
            }

            .form-control {
                width: 100%;
                padding: 14px 18px;
                background: rgba(255, 255, 255, 0.05);
                border: 1px solid rgba(255, 255, 255, 0.1);
                border-radius: 12px;
                color: white;
                font-size: 15px;
                transition: all 0.3s;
            }

            .form-control:focus {
                outline: none;
                background: rgba(255, 255, 255, 0.08);
                border-color: rgba(167, 139, 250, 0.5);
            }

            .form-control::placeholder {
                color: rgba(255, 255, 255, 0.3);
            }

            .toggle-password {
                position: absolute;
                right: 15px;
                top: 50%;
                transform: translateY(-50%);
                background: none;
                border: none;
                color: rgba(255, 255, 255, 0.5);
                cursor: pointer;
                font-size: 18px;
                padding: 5px;
            }

            .toggle-password:hover {
                color: rgba(255, 255, 255, 0.8);
            }

            /* Buttons */
            .btn-primary {
                width: 100%;
                padding: 15px;
                background: white;
                color: #1a1a2e;
                border: none;
                border-radius: 12px;
                font-size: 15px;
                font-weight: 600;
                cursor: pointer;
                transition: all 0.3s;
                margin-top: 25px;
            }

            .btn-primary:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 25px rgba(255, 255, 255, 0.2);
            }

            /* Divider */
            .divider {
                text-align: center;
                color: rgba(255, 255, 255, 0.5);
                margin: 30px 0 25px;
                font-size: 13px;
                position: relative;
            }

            .divider::before,
            .divider::after {
                content: '';
                position: absolute;
                top: 50%;
                width: 40%;
                height: 1px;
                background: rgba(255, 255, 255, 0.1);
            }

            .divider::before {
                left: 0;
            }

            .divider::after {
                right: 0;
            }

            /* Social Buttons */
            .social-buttons {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 12px;
            }

            .btn-social {
                padding: 12px;
                background: rgba(255, 255, 255, 0.05);
                border: 1px solid rgba(255, 255, 255, 0.1);
                border-radius: 12px;
                color: white;
                cursor: pointer;
                transition: all 0.3s;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 14px;
            }

            .btn-social:hover {
                background: rgba(255, 255, 255, 0.08);
                border-color: rgba(255, 255, 255, 0.2);
            }

            /* Terms */
            .terms {
                text-align: center;
                color: rgba(255, 255, 255, 0.5);
                font-size: 12px;
                margin-top: 20px;
                line-height: 1.5;
            }

            .terms a {
                color: rgba(255, 255, 255, 0.7);
                text-decoration: underline;
            }

            /* Responsive */
            @media (max-width: 968px) {
                .auth-container {
                    flex-direction: column;
                    padding-top: 80px;
                }
                
                .illustration {
                    display: none;
                }

                .header {
                    padding: 20px;
                }

                .auth-box {
                    padding: 35px 25px;
                }
            }
        </style>
    </head>
    <body>
        <div class="header">
            <div class="logo">
                <div class="logo-icon">S</div>
                Suara.Space
            </div>
            <div>
                <a href="#" class="header-link">Already have an account?</a>
                <a href="sign_in.php" class="header-link btn">SIGN IN</a>
            </div>
        </div>

        <div class="container">
            <div class="auth-container">
                <div class="illustration">
                    <div class="illustration-image">
                        <div class="stars">
                            <div class="star"></div>
                            <div class="star"></div>
                            <div class="star"></div>
                            <div class="star"></div>
                            <div class="star"></div>
                            <div class="star"></div>
                        </div>
                        <img src="signup1.png" alt="Illustration" class="character-image" id="slideImage">
                        <div class="path"></div>
                    </div>
                    <div class="slide-content" id="slideContent">
                        <h2 id="slideTitle">Increase focus</h2>
                        <p id="slideDescription">Science-based music designed to sustain flow state</p>
                    </div>
                    <div class="carousel-dots">
                        <div class="dot active" onclick="changeSlide(0)"></div>
                        <div class="dot" onclick="changeSlide(1)"></div>
                        <div class="dot" onclick="changeSlide(2)"></div>
                    </div>
                </div>

                <div class="auth-box">
                    <h2>Get started for FREE</h2>
                    <form id="signupForm">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Name" required>
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" placeholder="Email" required>
                        </div>
                        <div class="form-group">
                            <div class="input-wrapper">
                                <input type="password" class="form-control" id="password" placeholder="Password" required>
                                <button type="button" class="toggle-password" onclick="togglePassword()">👁</button>
                            </div>
                        </div>
                        <button type="submit" class="btn-primary">CREATE ACCOUNT</button>
                    </form>
                    <div class="divider">OR SIGN UP WITH</div>
                    <div class="social-buttons">
                        <button class="btn-social">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M17.05 20.28c-.98.95-2.05.8-3.08.35-1.09-.46-2.09-.48-3.24 0-1.44.62-2.2.44-3.06-.35C2.79 15.25 3.51 7.59 9.05 7.31c1.35.07 2.29.74 3.08.8 1.18-.24 2.31-.93 3.57-.84 1.51.12 2.65.72 3.4 1.8-3.12 1.87-2.38 5.98.48 7.13-.57 1.5-1.31 2.99-2.54 4.09l.01-.01zM12.03 7.25c-.15-2.23 1.66-4.07 3.74-4.25.29 2.58-2.34 4.5-3.74 4.25z"/>
                            </svg>
                        </button>
                        <button class="btn-social">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M9.198 21.5h4v-8.01h3.604l.396-3.98h-4V7.5a1 1 0 0 1 1-1h3v-4h-3a5 5 0 0 0-5 5v2.01h-2l-.396 3.98h2.396v8.01Z"/>
                            </svg>
                        </button>
                    </div>
                    <div class="terms">
                        By creating an account, you agree to Suara.Space's <a href="#">Terms & Conditions</a> and <a href="#">Privacy Policy</a>
                    </div>
                </div>
            </div>
        </div>

        <script>
            // Data untuk setiap slide
            const slides = [
                {
                    image: 'signup1.png',
                    title: 'Increase focus',
                    description: 'Science-based music designed to sustain flow state'
                },
                {
                    image: 'signup2.png',
                    title: 'Better sleep',
                    description: 'Calming sounds to help you relax and fall asleep faster'
                },
                {
                    image: 'signup3.png',
                    title: 'Deep relaxation',
                    description: 'Reduce stress and anxiety with soothing audio'
                }
            ];

            let currentSlide = 0;

            function changeSlide(index) {
                const image = document.getElementById('slideImage');
                const title = document.getElementById('slideTitle');
                const description = document.getElementById('slideDescription');
                const dots = document.querySelectorAll('.dot');
                const content = document.getElementById('slideContent');

                // Remove active dari semua dots
                dots.forEach(dot => dot.classList.remove('active'));
                
                // Slide out
                content.style.opacity = '0';
                content.style.transform = 'translateX(30px)';
                image.style.opacity = '0';
                image.style.transform = 'translate(-50%, -50%) translateX(30px)';

                setTimeout(() => {
                    // Update konten
                    currentSlide = index;
                    image.src = slides[index].image;
                    title.textContent = slides[index].title;
                    description.textContent = slides[index].description;
                    
                    // Set dot aktif
                    dots[index].classList.add('active');
                    
                    // Slide in
                    setTimeout(() => {
                        content.style.opacity = '1';
                        content.style.transform = 'translateX(0)';
                        image.style.opacity = '1';
                        image.style.transform = 'translate(-50%, -50%) translateX(0)';
                    }, 50);
                }, 400);
            }

            // Auto slide setiap 5 detik
            setInterval(() => {
                currentSlide = (currentSlide + 1) % slides.length;
                changeSlide(currentSlide);
            }, 5000);

            function togglePassword() {
                const input = document.getElementById('password');
                input.type = input.type === 'password' ? 'text' : 'password';
            }

            document.getElementById('signupForm').addEventListener('submit', (e) => {
                e.preventDefault();
                alert('Account created successfully! (Demo only)');
            });
        </script>
    </body>
    </html>