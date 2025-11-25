<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library - Brain.fm</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
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
            border-bottom: 1px solid #1a1a1a;
        }

        .header h1 {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .tabs {
            display: flex;
            gap: 0;
            border-bottom: 1px solid #1a1a1a;
        }

        .tab {
            flex: 1;
            padding: 12px;
            background: none;
            border: none;
            color: #666;
            font-size: 15px;
            cursor: pointer;
            position: relative;
        }

        .tab.active {
            color: #fff;
        }

        .tab.active::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            right: 0;
            height: 2px;
            background: #fff;
        }

        .filter-tabs {
            display: flex;
            gap: 12px;
            padding: 20px 24px;
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
            padding: 0 24px 100px;
        }

        .track-item {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 12px 0;
            cursor: pointer;
            transition: background 0.2s;
            border-radius: 8px;
        }

        .track-item:hover {
            background: #1a1a1a;
            padding-left: 12px;
            padding-right: 12px;
            margin-left: -12px;
            margin-right: -12px;
        }

        .track-cover {
            width: 56px;
            height: 56px;
            border-radius: 4px;
            object-fit: cover;
        }

        .track-info {
            flex: 1;
        }

        .track-title {
            font-size: 15px;
            font-weight: 500;
            margin-bottom: 4px;
        }

        .track-meta {
            font-size: 12px;
            color: #666;
            text-transform: uppercase;
        }

        .track-actions {
            display: flex;
            gap: 16px;
            align-items: center;
        }

        .icon-btn {
            background: none;
            border: none;
            color: #666;
            cursor: pointer;
            padding: 4px;
            transition: color 0.2s;
        }

        .icon-btn:hover {
            color: #fff;
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
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Library</h1>
            <div class="tabs">
                <button class="tab active">Favorites</button>
                <button class="tab">Recent</button>
            </div>
        </div>

        <div class="filter-tabs">
            <button class="filter-tab">Focus</button>
            <button class="filter-tab">Relax</button>
            <button class="filter-tab">Sleep</button>
            <button class="filter-tab">Meditate</button>
        </div>

        <div class="content">
            <div class="track-item">
                <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='56' height='56'%3E%3Crect fill='%23654321' width='56' height='56'/%3E%3C/svg%3E" alt="Track cover" class="track-cover">
                <div class="track-info">
                    <div class="track-title">Sandstone Cliffs</div>
                    <div class="track-meta">PIANO<br>Deep Work +1 more</div>
                </div>
                <div class="track-actions">
                    <button class="icon-btn">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="2" y="2" width="16" height="16" rx="2"/>
                            <line x1="6" y1="6" x2="14" y2="6"/>
                            <line x1="6" y1="10" x2="14" y2="10"/>
                            <line x1="6" y1="14" x2="10" y2="14"/>
                        </svg>
                    </button>
                    <button class="icon-btn">
                        <svg width="20" height="20" fill="currentColor">
                            <path d="M10 3l2.5 5.5 6 .5-4.5 4 1.5 6-5.5-3.5L4 19l1.5-6L1 9l6-.5z"/>
                        </svg>
                    </button>
                    <button class="icon-btn">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="10" cy="10" r="8"/>
                            <line x1="10" y1="6" x2="10" y2="10"/>
                            <line x1="10" y1="14" x2="10" y2="14"/>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="track-item">
                <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='56' height='56'%3E%3Crect fill='%234a90e2' width='56' height='56'/%3E%3C/svg%3E" alt="Track cover" class="track-cover">
                <div class="track-info">
                    <div class="track-title">Pieces For The Harp</div>
                    <div class="track-meta">CLASSICAL<br>Deep Work +1 more</div>
                </div>
                <div class="track-actions">
                    <button class="icon-btn">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="2" y="2" width="16" height="16" rx="2"/>
                            <line x1="6" y1="6" x2="14" y2="6"/>
                            <line x1="6" y1="10" x2="14" y2="10"/>
                            <line x1="6" y1="14" x2="10" y2="14"/>
                        </svg>
                    </button>
                    <button class="icon-btn">
                        <svg width="20" height="20" fill="currentColor">
                            <path d="M10 3l2.5 5.5 6 .5-4.5 4 1.5 6-5.5-3.5L4 19l1.5-6L1 9l6-.5z"/>
                        </svg>
                    </button>
                    <button class="icon-btn">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="10" cy="10" r="8"/>
                            <line x1="10" y1="6" x2="10" y2="10"/>
                            <line x1="10" y1="14" x2="10" y2="14"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <nav class="bottom-nav">
            <a href="library.php" class="nav-item active">
                <div class="nav-icon">
                    <svg width="20" height="20" fill="currentColor">
                        <rect x="3" y="3" width="6" height="6" rx="1"/>
                        <rect x="11" y="3" width="6" height="6" rx="1"/>
                        <rect x="3" y="11" width="6" height="6" rx="1"/>
                        <rect x="11" y="11" width="6" height="6" rx="1"/>
                    </svg>
                </div>
                <span>Library</span>
            </a>
            <a href="explore.php" class="nav-item">
                <div class="nav-icon">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="10" cy="10" r="7"/>
                        <path d="M10 3v7l4 4"/>
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