<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore - Brain.fm</title>
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
        }

        .header h1 {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 16px;
        }

        .search-box {
            position: relative;
            margin-bottom: 16px;
        }

        .search-input {
            width: 100%;
            padding: 12px 16px 12px 44px;
            background: #1a1a1a;
            border: none;
            border-radius: 8px;
            color: #fff;
            font-size: 14px;
        }

        .search-input::placeholder {
            color: #666;
        }

        .search-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
        }

        .filter-tabs {
            display: flex;
            gap: 12px;
            overflow-x: auto;
        }

        .filter-tab {
            padding: 10px 24px;
            background: #fff;
            border: none;
            border-radius: 20px;
            color: #000;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            white-space: nowrap;
            transition: all 0.2s;
        }

        .filter-tab:hover {
            background: #e0e0e0;
        }

        .filter-tab:not(:first-child) {
            background: #1a1a1a;
            color: #fff;
        }

        .filter-tab:not(:first-child):hover {
            background: #2a2a2a;
        }

        .content {
            flex: 1;
            padding: 20px 24px 100px;
        }

        .section {
            margin-bottom: 24px;
        }

        .section-title {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 12px;
        }

        .section-icon {
            width: 20px;
            height: 20px;
        }

        .mood-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .mood-tag {
            padding: 10px 20px;
            background: #1a1a1a;
            border: none;
            border-radius: 20px;
            color: #fff;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }

        .mood-tag:hover {
            background: #2a2a2a;
            transform: translateY(-2px);
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

        .nav-icon {
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

     /* Hilangkan scrollbar di semua browser */
.filter-tabs {
    overflow-x: auto;
    scrollbar-width: none; /* Firefox */
}

.filter-tabs::-webkit-scrollbar {
    display: none; /* Chrome & teman-temannya */
}

.content {
    overflow-y: auto;
    scrollbar-width: none;
}

.content::-webkit-scrollbar {
    display: none;
}

    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Explore</h1>
            <div class="search-box">
                <svg class="search-icon" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="7" cy="7" r="5"/>
                    <line x1="11" y1="11" x2="15" y2="15"/>
                </svg>
                <input type="text" class="search-input" placeholder="Search by name, genre, instrumentation or mood...">
            </div>
            <div class="filter-tabs">
                <button class="filter-tab">Focus</button>
                <button class="filter-tab">Relax</button>
                <button class="filter-tab">Sleep</button>
                <button class="filter-tab">Meditate</button>
            </div>
        </div>

        <div class="content">
            <div class="section">
                <div class="section-title">
                    <svg class="section-icon" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 8h3l3-6 3 12 3-6h3"/>
                    </svg>
                    Wind
                </div>
            </div>

            <div class="section">
                <div class="section-title">Moods</div>
                <div class="mood-tags">
                    <button class="mood-tag">Brooding</button>
                    <button class="mood-tag">Calm</button>
                    <button class="mood-tag">Chill</button>
                    <button class="mood-tag">Dark</button>
                    <button class="mood-tag">Downtempo</button>
                    <button class="mood-tag">Dreamlike</button>
                    <button class="mood-tag">Driving</button>
                    <button class="mood-tag">Energizing</button>
                    <button class="mood-tag">Epic</button>
                    <button class="mood-tag">Floating</button>
                    <button class="mood-tag">Heavy</button>
                    <button class="mood-tag">Hopeful</button>
                    <button class="mood-tag">Inspiring</button>
                    <button class="mood-tag">Meditative</button>
                    <button class="mood-tag">Mysterious</button>
                    <button class="mood-tag">Ominous</button>
                    <button class="mood-tag">Optimistic</button>
                    <button class="mood-tag">Playful</button>
                    <button class="mood-tag">Ponderous</button>
                    <button class="mood-tag">Serene</button>
                    <button class="mood-tag">Strong</button>
                    <button class="mood-tag">Upbeat</button>
                    <button class="mood-tag">Uplifting</button>
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
            <a href="explore.php" class="nav-item active">
                <div class="nav-icon">
                    <svg width="20" height="20" fill="currentColor">
                        <circle cx="10" cy="10" r="7"/>
                        <path d="M10 3v7l4 4" fill="none" stroke="#0a0a0a" stroke-width="2"/>
                    </svg>
                </div>
                <span>Explore</span>
            </a>
            <a href="profile.php" class="nav-item">
                <div class="nav-icon">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="10" cy="7" r="4"/>
                        <path d="M3 18c0-3.3 3.1-6 7-6s7 2.7 7 6"/>
                    </svg>
                </div>
                <span>Profile</span>
            </a>
        </nav>
    </div>
</body>
</html>