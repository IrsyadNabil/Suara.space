<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Suara.Space</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #000;
            color: #fff;
            min-height: 100vh;
        }

        .container {
            max-width: 400px;
            margin: 0 auto;
            background: #0a0a0a;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .header {
            padding: 20px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #1a1a1a;
        }

        .header h1 {
            font-size: 28px;
            font-weight: 600;
        }

        .logout-btn {
            background: none;
            border: none;
            color: #666;
            font-size: 14px;
            cursor: pointer;
            padding: 8px 16px;
            border-radius: 6px;
            transition: all 0.2s;
        }

        .logout-btn:hover {
            background: #1a1a1a;
            color: #fff;
        }

        .content {
            flex: 1;
            padding: 0 24px 100px;
        }

        .section {
            margin-top: 24px;
        }

        .section-label {
            font-size: 12px;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 12px;
            padding: 0 8px;
        }

        .menu-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 16px;
            background: #1a1a1a;
            border-radius: 8px;
            margin-bottom: 8px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .menu-item:hover {
            background: #2a2a2a;
            transform: translateX(4px);
        }

        .menu-item-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .menu-text {
            font-size: 15px;
            font-weight: 400;
        }

        .menu-arrow {
            color: #666;
        }

        .external-icon {
            width: 16px;
            height: 16px;
            color: #666;
        }

        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            max-width: 400px;
            width: 100%;
            background: #0a0a0a;
            border-top: 1px solid #1a1a1a;
            display: flex;
            padding: 12px 0;
        }

        .nav-item {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
            color: #666;
            text-decoration: none;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            cursor: pointer;
            transition: color 0.2s;
        }

        .nav-item:hover {
            color: #fff;
        }

        .nav-item.active {
            color: #fff;
        }

        /* Modal Styles */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.8);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal-overlay.active {
            display: flex;
        }

        .modal {
            background: #1e1e2d;
            border-radius: 16px;
            width: 90%;
            max-width: 340px;
            position: relative;
            padding: 32px 24px 24px;
        }

        .modal-close {
            position: absolute;
            top: 16px;
            right: 16px;
            background: #2a2a3a;
            border: none;
            color: #fff;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .modal-close:hover {
            background: #3a3a4a;
        }

        .modal-title {
            text-align: center;
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 24px;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-label {
            display: block;
            font-size: 13px;
            color: #999;
            margin-bottom: 8px;
        }

        .form-input {
            width: 100%;
            padding: 14px 16px;
            background: #2a2a3a;
            border: none;
            border-radius: 8px;
            color: #fff;
            font-size: 15px;
        }

        .form-input:focus {
            outline: 2px solid #4a4a5a;
        }

        .password-input-wrapper {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #666;
            cursor: pointer;
            padding: 4px;
        }

        .password-toggle:hover {
            color: #999;
        }

        .delete-btn {
            width: 100%;
            padding: 14px;
            background: none;
            border: none;
            color: #ff4444;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            margin: 16px 0;
            border-radius: 8px;
            transition: all 0.2s;
        }

        .delete-btn:hover {
            background: rgba(255, 68, 68, 0.1);
        }

        .modal-btn {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 24px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            margin-bottom: 12px;
        }

        .btn-primary {
            background: #fff;
            color: #000;
        }

        .btn-primary:hover {
            background: #e0e0e0;
        }

        .btn-secondary {
            background: none;
            color: #fff;
        }

        .btn-secondary:hover {
            background: #2a2a3a;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Profile</h1>
            <button class="logout-btn">Logout</button>
        </div>

        <div class="content">
            <div class="section">
                <div class="section-label">Account</div>
                <div class="menu-item" onclick="openEditModal()">
                    <div class="menu-item-left">
                        <span class="menu-text">Edit Profile</span>
                    </div>
                    <svg class="menu-arrow" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M8 6l4 4-4 4"/>
                    </svg>
                </div>

                <div class="menu-item" onclick="openPasswordModal()">
                    <div class="menu-item-left">
                        <span class="menu-text">Change Password</span>
                    </div>
                    <svg class="menu-arrow" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M8 6l4 4-4 4"/>
                    </svg>
                </div>

                <div class="menu-item">
                    <div class="menu-item-left">
                        <span class="menu-text">Settings</span>
                    </div>
                    <svg class="menu-arrow" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M8 6l4 4-4 4"/>
                    </svg>
                </div>

            
            </div>

            <div class="section">
                <div class="section-label">Company</div>
                <div class="menu-item">
                    <div class="menu-item-left">
                        <span class="menu-text">Contact Support</span>
                    </div>
                    <svg class="external-icon" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 3h8v8M11 3L3 11"/>
                    </svg>
                </div>
            </div>
        </div>

        <nav class="bottom-nav">
            <a href="library.php" class="nav-item">
                <div class="nav-icon">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="6" height="6" rx="1"/>
                        <rect x="11" y="3" width="6" height="6" rx="1"/>
                        <rect x="3" y="11" width="6" height="6" rx="1"/>
                        <rect x="11" y="11" width="6" height="6" rx="1"/>
                    </svg>
                </div>
                <span>Library</span>
            </a>
            <a href="explore.php" class="nav-item ">
                <div class="nav-icon">
                    <svg width="20" height="20" fill="currentColor">
                        <circle cx="10" cy="10" r="7"/>
                        <path d="M10 3v7l4 4" fill="none" stroke="#0a0a0a" stroke-width="2"/>
                    </svg>
                </div>
                <span>Explore</span>
            </a>
            <a href="profile.php" class="nav-item active">
                <div class="nav-icon">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="10" cy="7" r="4"/>
                        <path d="M3 18c0-3.3 3.1-6 7-6s7 2.7 7 6"/>
                    </svg>
                </div>
                <span>Profile</span>
            </a>
        </nav>

    <!-- Edit Profile Modal -->
    <div class="modal-overlay" id="editModal">
        <div class="modal">
            <button class="modal-close" onclick="closeEditModal()">✕</button>
            <h2 class="modal-title">Edit Profile</h2>
            
            <div class="form-group">
                <label class="form-label">Name</label>
                <input type="text" class="form-input" value="musang">
            </div>
            
            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" class="form-input" value="vpmusang2025@gmail.com">
            </div>

            <button class="delete-btn">Delete My Account</button>
            
            <button class="modal-btn btn-primary">SAVE</button>
            <button class="modal-btn btn-secondary" onclick="closeEditModal()">CANCEL</button>
        </div>
    </div>

    <!-- Change Password Modal -->
    <div class="modal-overlay" id="passwordModal">
        <div class="modal">
            <button class="modal-close" onclick="closePasswordModal()">✕</button>
            <h2 class="modal-title">Change Password</h2>
            
            <div class="form-group">
                <label class="form-label">CURRENT PASSWORD</label>
                <div class="password-input-wrapper">
                    <input type="password" class="form-input" placeholder="Enter current password" id="currentPass">
                    <button class="password-toggle" onclick="togglePassword('currentPass')">
                        <span>👁</span>
                    </button>
                </div>
            </div>
            
            <div class="form-group">
                <label class="form-label">NEW PASSWORD</label>
                <div class="password-input-wrapper">
                    <input type="password" class="form-input" placeholder="New password" id="newPass">
                    <button class="password-toggle" onclick="togglePassword('newPass')">
                        <span>👁</span>
                    </button>
                </div>
            </div>
            
            <div class="form-group">
                <div class="password-input-wrapper">
                    <input type="password" class="form-input" placeholder="Confirm new password" id="confirmPass">
                    <button class="password-toggle" onclick="togglePassword('confirmPass')">
                        <span>👁</span>
                    </button>
                </div>
            </div>
            
            <button class="modal-btn btn-primary">SAVE</button>
            <button class="modal-btn btn-secondary" onclick="closePasswordModal()">CANCEL</button>
        </div>
    </div>

    <script>
        function openEditModal() {
            document.getElementById('editModal').classList.add('active');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.remove('active');
        }

        function openPasswordModal() {
            document.getElementById('passwordModal').classList.add('active');
        }

        function closePasswordModal() {
            document.getElementById('passwordModal').classList.remove('active');
        }

        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            input.type = input.type === 'password' ? 'text' : 'password';
        }

        // Close modal when clicking outside
        document.querySelectorAll('.modal-overlay').forEach(overlay => {
            overlay.addEventListener('click', function(e) {
                if (e.target === this) {
                    this.classList.remove('active');
                }
            });
        });
    </script>
</body>
</html>