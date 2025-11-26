<?php
session_start();
// Cek apakah user sudah login
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header('Location: sign_in.php');
    exit();
}
$user_name = $_SESSION['user_name'] ?? 'User';
$user_email = $_SESSION['user_email'] ?? '';
$user_id = $_SESSION['user_id'] ?? '';
// Koneksi database (sesuaikan dengan konfigurasi Anda)
$host = 'localhost';
$dbname = 'suara.space';
$username = 'root';
$password = '';
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}
// Fungsi untuk mendapatkan data user
function getUserData($pdo, $user_id)
{
    $stmt = $pdo->prepare("SELECT nama, email FROM users WHERE id_user = ?");
    $stmt->execute([$user_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
// Fungsi untuk update profile
function updateProfile($pdo, $user_id, $name, $email)
{
    $stmt = $pdo->prepare("UPDATE users SET name = ?, email = ? WHERE id_user = ?");
    return $stmt->execute([$name, $email, $user_id]);
}
// Fungsi untuk ganti password
function changePassword($pdo, $user_id, $current_password, $new_password)
{
    // Verifikasi password saat ini
    $stmt = $pdo->prepare("SELECT password FROM users WHERE id_user = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$user || !password_verify($current_password, $user['password'])) {
        return false; // Password saat ini salah
    }
    // Update password baru
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id_user = ?");
    return $stmt->execute([$hashed_password, $user_id]);
}
// Fungsi untuk menghapus akun
function deleteAccount($pdo, $user_id)
{
    $stmt = $pdo->prepare("DELETE FROM users WHERE id_user = ?");
    return $stmt->execute([$user_id]);
}
// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'update_profile':
                $name = $_POST['name'];
                $email = $_POST['email'];
                if (updateProfile($pdo, $user_id, $name, $email)) {
                    $_SESSION['user_name'] = $name;
                    $_SESSION['user_email'] = $email;
                    echo json_encode(['success' => true, 'message' => 'Profile berhasil diperbarui']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Gagal memperbarui profile']);
                }
                exit;
            case 'change_password':
                $current_password = $_POST['current_password'];
                $new_password = $_POST['new_password'];
                $confirm_password = $_POST['confirm_password'];
                if ($new_password !== $confirm_password) {
                    echo json_encode(['success' => false, 'message' => 'Password baru tidak cocok']);
                    exit;
                }
                if (strlen($new_password) < 6) {
                    echo json_encode(['success' => false, 'message' => 'Password minimal 6 karakter']);
                    exit;
                }
                if (changePassword($pdo, $user_id, $current_password, $new_password)) {
                    echo json_encode(['success' => true, 'message' => 'Password berhasil diubah']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Password saat ini salah']);
                }
                exit;
            case 'delete_account':
                if (deleteAccount($pdo, $user_id)) {
                    session_destroy();
                    echo json_encode(['success' => true, 'message' => 'Akun berhasil dihapus']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Gagal menghapus akun']);
                }
                exit;
        }
    }
}
// Ambil data user terbaru
$user_data = getUserData($pdo, $user_id);
$user_name = $user_data['name'] ?? $user_name;
$user_email = $user_data['email'] ?? $user_email;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Music Therapy - SPA</title>
    <script>
        const SIDEBAR_WIDTH = '300px';
    </script>
    <style>
        /* Variabel CSS untuk lebar */
        :root {
            --sidebar-width: 300px;
        }
        /* Reset and Global */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #140f2b 0%, #1a153d 60%, #0f1438 100%);
            color: white;
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
        }
        /* ------------------------------------------------------------------ */
        /* KODINGAN UNTUK SIDEBAR, MAIN-CONTAINER, DAN EFEK MENGECIL */
        /* ------------------------------------------------------------------ */
        .main-container {
            transition: transform 0.3s ease-in-out, width 0.3s ease-in-out;
            box-sizing: border-box;
            width: 100%;
            min-height: 100vh;
            position: relative;
            z-index: 10;
        }
        .logo {
            position: fixed;
            top: 20px;
            left: 20px;
            width: 48px;
            height: 48px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #1a1a2e;
            font-weight: 700;
            font-size: 1.5rem;
            cursor: pointer;
            z-index: 1001;
        }
        .top-right-button {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 10px 15px;
            background-color: #34495e;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            z-index: 1001;
            transition: right 0.3s ease-in-out;
        }
        .sidebar {
            height: 100%;
            width: var(--sidebar-width);
            position: fixed;
            top: 0;
            right: 0;
            background-color: #2c3e50;
            color: white;
            padding: 20px;
            box-sizing: border-box;
            box-shadow: -4px 0 10px rgba(0, 0, 0, 0.5);
            transform: translateX(var(--sidebar-width));
            transition: transform 0.3s ease-in-out;
            z-index: 1000;
        }
        .sidebar h2 {
            border-bottom: 1px solid #34495e;
            padding-bottom: 15px;
            margin-bottom: 15px;
        }
        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 12px 10px;
            margin-bottom: 5px;
            border-radius: 4px;
            transition: background-color 0.2s;
        }
        .sidebar a:hover {
            background-color: #34495e;
        }
        /* KELAS 'ACTIVE' - Membuat Konten Mengecil dan Sidebar Muncul */
        .top-right-button.active {
            right: calc(20px + var(--sidebar-width));
        }
        .main-container.active {
            width: calc(100% - var(--sidebar-width));
        }
        .sidebar.active {
            transform: translateX(0);
        }
        /* ------------------------------------------------------------------ */
        /* KODINGAN UNTUK MAIN CONTENT (menu_lagu.php ASLI) */
        /* ------------------------------------------------------------------ */
        .get-started-page {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 0 15px 80px;
            text-align: center;
            max-width: 960px;
            margin: auto;
            gap: 40px;
            position: relative;
            z-index: 100;
            min-height: 100vh;
        }
        .player-page {
            display: none;
            flex-direction: column;
            min-height: 100vh;
            padding: 0 30px 60px;
            backdrop-filter: blur(15px);
            background: linear-gradient(135deg, #202040 0%, #1a162f 55%, #151d3a 100%);
            position: relative;
            overflow: hidden;
        }
        .player-page.active {
            display: flex;
        }
        /* Hilangkan bottom-nav asli */
        .bottom-nav {
            display: none !important;
        }
        /* SISA KODINGAN CSS ASLI menu_lagu.php */
        /* ==================================== */
        .get-started-page h1 {
            font-size: 3.25rem;
            font-weight: 800;
            color: white;
        }
        .subtitle {
            font-size: 1.25rem;
            color: rgb(200 200 230 / 0.7);
            margin-bottom: 20px;
        }
        .categories {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(190px, 1fr));
            gap: 35px;
            width: 100%;
            max-width: 900px;
        }
        .category-card {
            background: rgba(255 255 255 / 0.05);
            border-radius: 20px;
            padding: 30px 15px 40px 15px;
            cursor: pointer;
            border: 1px solid transparent;
            transition: all 0.25s ease;
            user-select: none;
            box-shadow: 0 10px 40px rgb(0 0 0 / 0.4);
            margin: 20px;
        }
        .category-card:hover,
        .category-card:focus {
            background: rgba(255 255 255 / 0.12);
            border-color: rgba(255 255 255 / 0.3);
            transform: translateY(-10px);
            outline: none;
        }
        .category-icon {
            margin: auto;
            width: 140px;
            height: 140px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            box-shadow: 0 10px 30px rgb(0 0 0 / 0.6);
        }
        .category-icon svg {
            width: 65px !important;
            height: 65px !important;
            filter: drop-shadow(0 0 5px rgb(255 255 255 / 0.3));
        }
        .focus-icon {
            background: linear-gradient(135deg, #ff6b9d 0%, #c06c84 100%);
        }
        .relax-icon {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }
        .sleep-icon {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .meditate-icon {
            background: linear-gradient(135deg, #00c9ff 0%, #92fe9d 100%);
        }
        .category-title {
            font-weight: 700;
            font-size: 1.45rem;
            letter-spacing: 0.04em;
            color: white;
            text-shadow: 0 0 8px rgb(0 0 0 / 0.5);
        }
        /* Player Page */
        .header {
            padding-top: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 960px;
            margin: 15px auto 40px;
            width: 100%;
            user-select: none;
        }
        .back-btn {
            color: #ccc;
            font-size: 16px;
            padding: 10px 22px;
            border-radius: 14px;
            border: none;
            background: transparent;
            cursor: pointer;
            font-weight: 600;
            transition: color 0.3s;
            letter-spacing: 0.04em;
        }
        .back-btn:hover {
            color: white;
        }
        .category-selector {
            background: rgba(255 255 255 / 0.1);
            border: none;
            border-radius: 14px;
            color: white;
            font-size: 17px;
            font-weight: 600;
            padding: 10px 30px;
            cursor: pointer;
            user-select: none;
            letter-spacing: 0.04em;
            box-shadow: 0 8px 15px rgb(0 0 0 / 0.5);
            transition: background 0.3s;
        }
        .category-selector:hover,
        .category-selector:focus {
            background: rgba(255 255 255 / 0.22);
            outline: none;
        }
        .header-right {
            display: flex;
            gap: 25px;
            align-items: center;
            font-weight: 600;
            font-size: 14px;
            color: #c3c3c3;
            user-select: none;
        }
        .switch {
            position: relative;
            display: inline-block;
            width: 52px;
            height: 28px;
        }
        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #5534a7;
            transition: 0.4s;
            border-radius: 28px;
        }
        .slider:before {
            position: absolute;
            content: "";
            height: 22px;
            width: 22px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: 0.4s;
            border-radius: 50%;
        }
        input:checked+.slider {
            background-color: #9e5bff;
        }
        input:checked+.slider:before {
            transform: translateX(24px);
        }
        .player-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin: auto;
            max-width: 580px;
            width: 100%;
            gap: 28px;
            position: relative;
            z-index: 100;
        }
        .status-text {
            font-size: 1rem;
            letter-spacing: 2.5px;
            font-weight: 600;
            color: #bbb;
            text-transform: uppercase;
        }
        .timer {
            font-weight: 900;
            font-size: 6.5rem;
            letter-spacing: 5px;
            color: white;
            line-height: 1;
            user-select: none;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .play-mode {
            background: rgba(255 255 255 / 0.1);
            padding: 12px 34px;
            border-radius: 28px;
            font-weight: 600;
            color: white;
            letter-spacing: 0.05em;
            font-size: 14px;
            user-select: none;
            box-shadow: 0 0 22px rgb(255 255 255 / 0.15);
        }
        .controls {
            display: flex;
            gap: 40px;
            align-items: center;
            justify-content: center;
            user-select: none;
        }
        .control-btn {
            background: rgba(255 255 255 / 0.1);
            border: none;
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            cursor: pointer;
            transition: background-color 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 6px 14px rgb(0 0 0 / 0.4);
        }
        .control-btn:hover {
            background: rgba(255 255 255 / 0.22);
        }
        .control-btn svg {
            width: 22px;
            height: 22px;
            user-select: none;
        }
        .play-pause-btn {
            width: 90px;
            height: 90px;
            background: white;
            color: #1a1a2e;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 0 40px rgba(255 255 255 / 0.8);
            transition: transform 0.2s ease;
        }
        .play-pause-btn:active {
            transform: scale(0.95);
        }
        .play-pause-btn svg {
            width: 32px;
            height: 32px;
        }
        .now-playing {
            margin-top: 40px;
            background: rgba(255 255 255 / 0.07);
            padding: 24px 28px;
            border-radius: 18px;
            box-shadow: 0 15px 50px rgba(0 0 0 / 0.3);
            width: 100%;
            max-width: 580px;
            display: flex;
            align-items: center;
            gap: 24px;
            user-select: none;
        }
        .album-art {
            width: 90px;
            height: 90px;
            border-radius: 14px;
            background-size: cover;
            background-position: center;
            box-shadow: 0 0 20px rgba(0, 201, 255, 0.4);
            transition: all 0.3s ease;
        }
        .track-info {
            flex: 1;
            color: white;
            user-select: text;
        }
        .track-title {
            font-weight: 800;
            font-size: 1.4rem;
            margin-bottom: 4px;
        }
        .track-category {
            font-size: 0.9rem;
            color: #b8b8d1;
            letter-spacing: 0.04em;
            font-weight: 600;
            user-select: none;
        }
        .track-genre {
            font-size: 0.75rem;
            margin-top: 6px;
            color: #9a9aad;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            font-weight: 600;
            user-select: none;
        }
        .track-actions {
            display: flex;
            gap: 20px;
            font-size: 1.5rem;
            align-items: center;
            user-select: none;
        }
        .action-btn {
            background: none;
            border: none;
            color: white;
            cursor: pointer;
            transition: transform 0.2s;
            user-select: none;
        }
        .action-btn:hover {
            transform: scale(1.3);
            color: #ff6b9d;
        }
        @media (max-width: 768px) {
            .get-started-page h1 {
                font-size: 2rem;
            }
            .categories {
                grid-template-columns: repeat(2, 1fr);
                gap: 24px;
            }
            .timer {
                font-size: 4rem;
            }
            .play-pause-btn {
                width: 70px;
                height: 70px;
            }
            .play-pause-btn svg {
                width: 24px;
                height: 24px;
            }
            .player-container {
                padding: 0 15px;
            }
            .now-playing {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
            .album-art {
                width: 70px;
                height: 70px;
            }
        }
        /* ------------------------------------------------------------------ */
        /* KODINGAN UNTUK INTEGRATED PAGES (LIBRARY, EXPLORE, PROFILE) */
        /* ------------------------------------------------------------------ */
        .integrated-pages-wrapper {
            position: relative;
            min-height: 100vh;
        }
        .app-page {
            display: flex;
            flex-direction: column;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            min-height: 100vh;
            padding-top: 88px;
            padding-bottom: 20px;
            background: #0a0a0a;
            transition: opacity 0.3s ease;
            z-index: 100;
        }
        .hidden-page {
            display: none;
            opacity: 0;
            z-index: 0;
            pointer-events: none;
        }
        .app-page:not(.hidden-page) {
            display: flex;
            opacity: 1;
            z-index: 200;
            pointer-events: auto;
        }
        .app-header-back {
            background: #0a0a0a;
            padding: 10px 30px 0;
            width: 100%;
            max-width: 960px;
            margin: 0 auto;
        }
        .back-to-home-btn {
            background: none;
            border: 1px solid #1a1a1a;
            color: #666;
            font-size: 14px;
            cursor: pointer;
            padding: 8px 16px;
            border-radius: 6px;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 16px;
        }
        .back-to-home-btn:hover {
            color: #fff;
            background: #1a1a1a;
        }
        .app-container {
            max-width: 960px;
            margin: 0 auto;
            width: 100%;
            flex: 1;
            display: flex;
            flex-direction: column;
            padding: 0 30px;
        }
        .lib-exp-header {
            padding: 0 0 20px;
            border-bottom: 1px solid #1a1a1a;
        }
        .lib-exp-header h1 {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 20px;
        }
        .filter-tabs {
            display: flex;
            gap: 12px;
            padding: 20px 0;
            overflow-x: auto;
            scrollbar-width: none;
        }
        .filter-tabs::-webkit-scrollbar {
            display: none;
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
        .app-content {
            flex: 1;
            padding: 0 0 20px;
            overflow-y: auto;
            scrollbar-width: none;
        }
        .app-content::-webkit-scrollbar {
            display: none;
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
        .track-title-lib {
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
        /* Style tambahan untuk library */
        .lib-filter {
            transition: all 0.3s ease;
        }
        .track-item .track-meta {
            line-height: 1.5;
        }
        .track-item .icon-btn svg {
            transition: all 0.2s;
        }
        .track-item .icon-btn:hover svg {
            stroke: #ff4444;
            transform: scale(1.1);
        }
        /* Explore Specific CSS */
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
        /* Profile Specific CSS */
        .profile-header {
            padding: 0 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #1a1a1a;
        }
        .profile-header h1 {
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
        /* Modal Styles */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.8);
            z-index: 2000;
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
    <!-- Audio element untuk memutar lagu -->
    <audio id="audioPlayer" preload="auto"></audio>
    <div class="logo" onclick="location.href='index.php'">S</div>
    <button id="toggleButton" class="top-right-button" aria-label="Toggle Library Menu">
        ☰ Menu
    </button>
    <div id="mainContainer" class="main-container">
        <main class="get-started-page" id="getStartedPage" tabindex="0" aria-label="Get Started Music Therapy">
            <h1>Get Started</h1>
            <p class="subtitle">What would you like to try first?</p>
            <section class="categories" role="list" aria-label="Music categories">
                <div>
                    <button class="category-card focus-icon" onclick="selectCategory('Focus')" aria-label="Focus category" tabindex="0" role="listitem">
                        <div class="category-icon">
                            <svg viewBox="0 0 24 24" fill="white" aria-hidden="true" focusable="false">
                                <path d="M12 2L2 7v10c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V7l-10-5z" />
                            </svg>
                        </div>
                        <div class="category-title">Focus</div>
                    </button>
                    <button class="category-card relax-icon" onclick="selectCategory('Relax')" aria-label="Relax category" tabindex="0" role="listitem">
                        <div class="category-icon">
                            <svg viewBox="0 0 24 24" fill="white" aria-hidden="true" focusable="false">
                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                            </svg>
                        </div>
                        <div class="category-title">Relax</div>
                    </button>
                    <button class="category-card sleep-icon" onclick="selectCategory('Sleep')" aria-label="Sleep category" tabindex="0" role="listitem">
                        <div class="category-icon">
                            <svg viewBox="0 0 24 24" fill="white" aria-hidden="true" focusable="false">
                                <path d="M12 3c-4.97 0-9 4.03-9 9s4.03 9 9 9 9-4.03 9-9c0-.46-.04-.92-.1-1.36-.98 1.37-2.58 2.26-4.4 2.26-2.98 0-5.4-2.42-5.4-5.4 0-1.81.89-3.42 2.26-4.4-.44-.06-.9-.1-1.36-.1z" />
                            </svg>
                        </div>
                        <div class="category-title">Sleep</div>
                    </button>
                    <button class="category-card meditate-icon" onclick="selectCategory('Meditate')" aria-label="Meditate category" tabindex="0" role="listitem">
                        <div class="category-icon">
                            <svg viewBox="0 0 24 24" fill="white" aria-hidden="true" focusable="false">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-5.5-2.5l7.51-3.49L17.5 6.5 9.99 9.99 6.5 17.5zm5.5-6.6c.61 0 1.1.49 1.1 1.1s-.49 1.1-1.1 1.1-1.1-.49-1.1-1.1.49-1.1 1.1-1.1z" />
                            </svg>
                        </div>
                        <div class="category-title">Meditate</div>
                    </button>
                </div>
            </section>
        </main>
        <section class="player-page" id="playerPage" aria-label="Music Player">
            <header class="header" role="banner">
                <button type="button" class="back-btn" aria-label="Back to categories" onclick="goBack()">← Back</button>
                <select class="category-selector" id="categorySelector" aria-label="Select music category" onchange="changeCategory()">
                    <option value="Focus">Focus</option>
                    <option value="Relax">Relax</option>
                    <option value="Sleep">Sleep</option>
                    <option value="Meditate">Meditate</option>
                </select>
            </header>
            <div class="player-container">
                <p class="status-text" id="statusText">Increasing Focus...</p>
                <div class="timer" id="timer">00:00</div>
                <div class="play-mode">∞ Infinite Play</div>
                <div class="controls" role="group" aria-label="Playback controls">
                    <button type="button" class="control-btn" aria-label="Previous track" onclick="previousTrack()">
                        <svg viewBox="0 0 24 24" fill="white" aria-hidden="true" focusable="false">
                            <path d="M6 6h2v12H6zm3.5 6l8.5 6V6z" />
                        </svg>
                    </button>
                    <button type="button" class="play-pause-btn" aria-label="Play or pause music" onclick="togglePlayPause()">
                        <span id="playIcon">
                            <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" focusable="false">
                                <path d="M8 5v14l11-7z" />
                            </svg>
                        </span>
                    </button>
                    <button type="button" class="control-btn" aria-label="Next track" onclick="nextTrack()">
                        <svg viewBox="0 0 24 24" fill="white" aria-hidden="true" focusable="false">
                            <path d="M6 18l8.5-6L6 6v12zM16 6v12h2V6h-2z" />
                        </svg>
                    </button>
                </div>
                <section class="now-playing" aria-live="polite" aria-atomic="true" aria-label="Now playing track details">
                    <div class="album-art" aria-hidden="true"></div>
                    <div class="track-info">
                        <div class="track-title" id="trackTitle">Let In The Light</div>
                        <div class="track-category" id="trackCategory">High Neural Effect</div>
                        <div class="track-genre">Electronic</div>
                    </div>
                </section>
            </div>
        </section>
        <div id="integratedPagesWrapper" class="integrated-pages-wrapper">
            <!-- LIBRARY PAGE - SUDAH DIPERBAIKI -->
            <div id="libraryPageContent" class="app-page hidden-page">
                <div class="app-header-back">
                    <button class="back-to-home-btn" onclick="goHome()">← Back to Home</button>
                </div>
                <div class="app-container">
                    <div class="lib-exp-header">
                        <h1>Library</h1>
                    </div>
                    <div class="filter-tabs">
                        <button class="filter-tab lib-filter" data-category="all">All</button>
                        <button class="filter-tab lib-filter" data-category="Focus">Focus</button>
                        <button class="filter-tab lib-filter" data-category="Relax">Relax</button>
                        <button class="filter-tab lib-filter" data-category="Sleep">Sleep</button>
                        <button class="filter-tab lib-filter" data-category="Meditate">Meditate</button>
                    </div>
                    <div class="app-content" id="libraryContent">
                        <div style="text-align: center; padding: 60px 20px; color: #666;">
                            <svg width="80" height="80" fill="none" stroke="currentColor" stroke-width="2" style="margin: 0 auto 20px; display: block; opacity: 0.3;">
                                <circle cx="40" cy="40" r="35"/>
                                <path d="M40 20v40M25 30l15-10 15 10M25 50l15-10 15 10"/>
                            </svg>
                            <h3 style="font-size: 18px; margin-bottom: 8px; color: #999;">Belum Ada Riwayat</h3>
                            <p style="font-size: 14px;">Mulai dengarkan musik untuk melihat riwayat putar Anda</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- EXPLORE PAGE -->
            <div id="explorePageContent" class="app-page hidden-page">
                <div class="app-header-back">
                    <button class="back-to-home-btn" onclick="goHome()">← Back to Home</button>
                </div>
                <div class="app-container">
                    <div class="lib-exp-header">
                        <h1>Explore</h1>
                        <div class="search-box">
                            <svg class="search-icon" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="7" cy="7" r="5" />
                                <line x1="11" y1="11" x2="15" y2="15" />
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
                    <div class="app-content">
                        <div class="section">
                            <div class="section-title">
                                <svg class="section-icon" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M3 8h3l3-6 3 12 3-6h3" />
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
                </div>
            </div>

            <!-- PROFILE PAGE -->
            <div id="profilePageContent" class="app-page hidden-page">
                <div class="app-header-back">
                    <button class="back-to-home-btn" onclick="goHome()">← Back to Home</button>
                </div>
                <div class="app-container">
                    <div class="profile-header">
                        <h1>Profile</h1>
                        <button class="logout-btn" onclick="location.href='logout.php'">Logout</button>
                    </div>
                    <div class="app-content">
                        <div class="section">
                            <div class="section-label">Account</div>
                            <div class="menu-item" onclick="openEditModal()">
                                <div class="menu-item-left">
                                    <span class="menu-text">Edit Profile</span>
                                </div>
                                <svg class="menu-arrow" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M8 6l4 4-4 4" />
                                </svg>
                            </div>
                            <div class="menu-item" onclick="openPasswordModal()">
                                <div class="menu-item-left">
                                    <span class="menu-text">Change Password</span>
                                </div>
                                <svg class="menu-arrow" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M8 6l4 4-4 4" />
                                </svg>
                            </div>
                            <div class="menu-item">
                                <div class="menu-item-left">
                                    <span class="menu-text">Settings</span>
                                </div>
                                <svg class="menu-arrow" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M8 6l4 4-4 4" />
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
                                    <path d="M3 3h8v8M11 3L3 11" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="sidebar" class="sidebar">
        <h2>Menu</h2>
        <a href="javascript:void(0)" onclick="showPage('library')">Library Anda</a>
        <a href="javascript:void(0)" onclick="showPage('explore')">Jelajahi Musik</a>
        <a href="javascript:void(0)" onclick="showPage('profile')">Profil Saya</a>
        <a href="logout.php">Logout</a>
    </div>
    <!-- Modal Edit Profile -->
    <div class="modal-overlay" id="editModal">
        <div class="modal">
            <button class="modal-close" onclick="closeEditModal()">✕</button>
            <h2 class="modal-title">Edit Profile</h2>
            <form id="editProfileForm">
                <div class="form-group">
                    <label class="form-label">Name</label>
                    <input type="text" class="form-input" name="name" value="<?php echo htmlspecialchars($user_name); ?>" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-input" name="email" value="<?php echo htmlspecialchars($user_email); ?>" required>
                </div>
                <input type="hidden" name="action" value="update_profile">
                <button type="button" class="delete-btn" onclick="confirmDeleteAccount()">Delete My Account</button>
                <button type="submit" class="modal-btn btn-primary">SAVE</button>
                <button type="button" class="modal-btn btn-secondary" onclick="closeEditModal()">CANCEL</button>
            </form>
        </div>
    </div>
    <!-- Modal Ganti Password -->
    <div class="modal-overlay" id="passwordModal">
        <div class="modal">
            <button class="modal-close" onclick="closePasswordModal()">✕</button>
            <h2 class="modal-title">Change Password</h2>
            <form id="changePasswordForm">
                <div class="form-group">
                    <label class="form-label">CURRENT PASSWORD</label>
                    <div class="password-input-wrapper">
                        <input type="password" class="form-input" name="current_password" placeholder="Enter current password" id="currentPass" required>
                        <button type="button" class="password-toggle" onclick="togglePassword('currentPass')">
                            <span>👁</span>
                        </button>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">NEW PASSWORD</label>
                    <div class="password-input-wrapper">
                        <input type="password" class="form-input" name="new_password" placeholder="New password" id="newPass" required>
                        <button type="button" class="password-toggle" onclick="togglePassword('newPass')">
                            <span>👁</span>
                        </button>
                    </div>
                </div>
                <div class="form-group">
                    <div class="password-input-wrapper">
                        <input type="password" class="form-input" name="confirm_password" placeholder="Confirm new password" id="confirmPass" required>
                        <button type="button" class="password-toggle" onclick="togglePassword('confirmPass')">
                            <span>👁</span>
                        </button>
                    </div>
                </div>
                <input type="hidden" name="action" value="change_password">
                <button type="submit" class="modal-btn btn-primary">SAVE</button>
                <button type="button" class="modal-btn btn-secondary" onclick="closePasswordModal()">CANCEL</button>
            </form>
        </div>
    </div>
    <!-- Modal Konfirmasi Hapus Akun -->
    <div class="modal-overlay" id="deleteConfirmModal">
        <div class="modal">
            <button class="modal-close" onclick="closeDeleteModal()">✕</button>
            <h2 class="modal-title">Delete Account</h2>
            <p style="text-align: center; margin-bottom: 20px; color: #ff6b6b;">
                Apakah Anda yakin ingin menghapus akun? Tindakan ini tidak dapat dibatalkan.
            </p>
            <form id="deleteAccountForm">
                <input type="hidden" name="action" value="delete_account">
                <button type="submit" class="delete-btn" style="background: #ff4444; color: white;">YA, HAPUS AKUN SAYA</button>
                <button type="button" class="modal-btn btn-secondary" onclick="closeDeleteModal()">BATAL</button>
            </form>
        </div>
    </div>

    <!-- JAVASCRIPT LENGKAP -->
    <script>
        // ==================== GLOBAL AUDIO & PLAYER STATE ====================
        const audioPlayer = document.getElementById('audioPlayer');
        let isPlaying = false;
        let minutes = 0;
        let seconds = 0;
        let timerInterval;
        let currentTrackIndex = 0;
        let currentCategory = 'Focus';
        // Kodingan Sidebar Toggle
        const toggleButton = document.getElementById('toggleButton');
        const sidebar = document.getElementById('sidebar');
        const mainContainer = document.getElementById('mainContainer');
        document.documentElement.style.setProperty('--sidebar-width', SIDEBAR_WIDTH);
        toggleButton.addEventListener('click', function () {
            sidebar.classList.toggle('active');
            mainContainer.classList.toggle('active');
            toggleButton.classList.toggle('active');
            if (sidebar.classList.contains('active')) {
                sidebar.focus();
            }
        });
        // ==================== DATA LAGU ====================
        const tracks = {
            Focus: [
                { title: 'Herbarium', color: '#ff6b9d', category: 'High Neural Effect', genre: 'Electronic', file: 'Herbarium.mp3', cover: 'herbarium.jpg' },
                { title: 'Beautiful', color: '#c06c84', category: 'High Neural Effect', genre: 'Electronic', file: 'Beautiful.mp3', cover: 'beautiful.jpg' },
                { title: 'Now is enough', color: '#ff8fab', category: 'High Neural Effect', genre: 'Electronic', file: 'Now is enough.mp3', cover: 'nowisnow.jpg' },
            ],
            Relax: [
                { title: 'Multo', color: '#4facfe', category: 'Serene Vibes', genre: 'Ambient', file: 'Multo.mp3', cover: 'multo.jpg' },
                { title: 'Beautiful', color: '#00f2fe', category: 'Serene Vibes', genre: 'Ambient', file: 'Beautiful.mp3', cover: 'beautiful.jpg' },
                { title: 'Now is enough', color: '#7eb8ff', category: 'Serene Vibes', genre: 'Ambient', file: 'Now is enough.mp3', cover: 'nowisnow.jpg' },
            ],
            Sleep: [
                { title: 'Herbarium', color: '#667eea', category: 'Night Calm', genre: 'Chill', file: 'Herbarium.mp3', cover: 'herbarium.jpg' },
                { title: 'Multo', color: '#764ba2', category: 'Night Calm', genre: 'Chill', file: 'Multo.mp3', cover: 'multo.jpg' },
                { title: 'Beautiful', color: '#8b7cd6', category: 'Night Calm', genre: 'Chill', file: 'Beautiful.mp3', cover: 'beautiful.jpg' },
            ],
            Meditate: [
                { title: 'Now is enough', color: '#00c9ff', category: 'Zen Atmosphere', genre: 'Meditative', file: 'Now is enough.mp3', cover: 'nowisnow.jpg' },
                { title: 'Multo', color: '#92fe9d', category: 'Zen Atmosphere', genre: 'Meditative', file: 'Multo.mp3', cover: 'multo.jpg' },
                { title: 'Herbarium', color: '#4ee9ce', category: 'Zen Atmosphere', genre: 'Meditative', file: 'Herbarium.mp3', cover: 'herbarium.jpg' },
            ],
        };
        // ==================== HELPER ====================
        function adjustColor(color, amount) {
            const clamp = (num) => Math.min(Math.max(num, 0), 255);
            const num = parseInt(color.replace('#', ''), 16);
            const r = clamp((num >> 16) + amount);
            const g = clamp(((num >> 8) & 0x00FF) + amount);
            const b = clamp((num & 0x0000FF) + amount);
            return '#' + ((r << 16) | (g << 8) | b).toString(16).padStart(6, '0');
        }
        function showMessage(message, isSuccess = true) {
            const messageEl = document.createElement('div');
            messageEl.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                padding: 15px 20px;
                background: ${isSuccess ? '#4CAF50' : '#f44336'};
                color: white;
                border-radius: 4px;
                z-index: 10000;
                box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            `;
            messageEl.textContent = message;
            document.body.appendChild(messageEl);
            setTimeout(() => document.body.removeChild(messageEl), 3000);
        }
        // ==================== PLAYER FUNCTIONS ====================
        function updateTrackDisplay() {
            const track = tracks[currentCategory][currentTrackIndex];
            const playerPage = document.getElementById('playerPage');
            const trackTitleElem = document.getElementById('trackTitle');
            const trackCategoryElem = document.getElementById('trackCategory');
            const statusText = document.getElementById('statusText');
            const albumArt = document.querySelector('.album-art');
            trackTitleElem.textContent = track.title;
            trackCategoryElem.textContent = track.category;
            statusText.textContent = `Increasing ${currentCategory}...`;
            playerPage.style.background = `linear-gradient(135deg, ${track.color}33 0%, #1a162f 50%, #0f1438 100%)`;
            if (track.cover) {
                albumArt.style.backgroundImage = `url('${track.cover}')`;
            } else {
                albumArt.style.backgroundImage = `linear-gradient(135deg, ${track.color} 0%, ${adjustColor(track.color, -20)} 100%)`;
            }
            audioPlayer.src = track.file;
        }
        function playCurrentTrack() {
            const track = tracks[currentCategory][currentTrackIndex];
            audioPlayer.src = track.file;
            audioPlayer.play().catch(e => console.log('Autoplay prevented:', e));
        }
        function updatePlayButton() {
            const icon = document.getElementById('playIcon');
            icon.innerHTML = isPlaying
                ? `<svg viewBox="0 0 24 24" fill="currentColor"><path d="M6 4h4v16H6V4zm8 0h4v16h-4V4z"/></svg>`
                : `<svg viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>`;
        }
        function resetTimer() {
            minutes = 0;
            seconds = 0;
            updateTimerDisplay();
        }
        function updateTimerDisplay() {
            const tm = document.getElementById('timer');
            const m = String(minutes).padStart(2, '0');
            const s = String(seconds).padStart(2, '0');
            tm.textContent = `${m}:${s}`;
        }
        function startTimer() {
            stopTimer();
            timerInterval = setInterval(() => {
                seconds++;
                if (seconds === 60) {
                    minutes++;
                    seconds = 0;
                }
                updateTimerDisplay();
            }, 1000);
        }
        function stopTimer() {
            if (timerInterval) clearInterval(timerInterval);
        }
        function togglePlayPause() {
            isPlaying = !isPlaying;
            if (isPlaying) {
                startTimer();
                audioPlayer.play();
            } else {
                stopTimer();
                audioPlayer.pause();
            }
            updatePlayButton();
        }
        function goBack() {
            document.getElementById('playerPage').classList.remove('active');
            document.getElementById('getStartedPage').style.display = 'flex';
            stopTimer();
            isPlaying = false;
            updatePlayButton();
            resetTimer();
            audioPlayer.pause();
        }
        function changeCategory() {
            const selector = document.getElementById('categorySelector');
            currentCategory = selector.value;
            currentTrackIndex = 0;
            resetTimer();
            updateTrackDisplay();
            updateTimerDisplay();
            isPlaying = false;
            updatePlayButton();
            audioPlayer.pause();
        }
        function previousTrack() {
            currentTrackIndex--;
            if (currentTrackIndex < 0) currentTrackIndex = tracks[currentCategory].length - 1;
            resetTimer();
            updateTrackDisplay();
            updateTimerDisplay();
            if (isPlaying) {
                playCurrentTrack();
                setTimeout(() => addToRecent(currentCategory, currentTrackIndex), 1000);
            }
        }
        function nextTrack() {
            currentTrackIndex++;
            if (currentTrackIndex >= tracks[currentCategory].length) currentTrackIndex = 0;
            resetTimer();
            updateTrackDisplay();
            updateTimerDisplay();
            if (isPlaying) {
                playCurrentTrack();
                setTimeout(() => addToRecent(currentCategory, currentTrackIndex), 1000);
            }
        }
        audioPlayer.addEventListener('ended', function () {
            nextTrack();
            if (isPlaying) playCurrentTrack();
        });
        // ==================== NAVIGASI HALAMAN ====================
        function goHome() {
            document.getElementById('getStartedPage').style.display = 'flex';
            document.getElementById('playerPage').classList.remove('active');
            document.querySelectorAll('.app-page').forEach(page => page.classList.add('hidden-page'));
            sidebar.classList.remove('active');
            mainContainer.classList.remove('active');
            toggleButton.classList.remove('active');
            stopTimer();
            isPlaying = false;
            updatePlayButton();
            resetTimer();
            audioPlayer.pause();
        }
        function showPage(pageId) {
            document.getElementById('getStartedPage').style.display = 'none';
            document.getElementById('playerPage').classList.remove('active');
            document.querySelectorAll('.app-page').forEach(page => page.classList.add('hidden-page'));
            const targetPage = document.getElementById(pageId + 'PageContent');
            if (targetPage) targetPage.classList.remove('hidden-page');
            sidebar.classList.remove('active');
            mainContainer.classList.remove('active');
            toggleButton.classList.remove('active');
            stopTimer();
            isPlaying = false;
            updatePlayButton();
            resetTimer();
            audioPlayer.pause();
            // Khusus Library: Load recent tracks
            if (pageId === 'library') {
                displayRecentTracks('all');
                const libraryFilters = document.querySelectorAll('.lib-filter');
                libraryFilters.forEach((f, idx) => {
                    f.style.background = idx === 0 ? '#fff' : '#1a1a1a';
                    f.style.color = idx === 0 ? '#000' : '#fff';
                });
            }
        }
        function selectCategory(cat) {
            currentCategory = cat;
            currentTrackIndex = 0;
            resetTimer();
            document.getElementById('getStartedPage').style.display = 'none';
            document.querySelectorAll('.app-page').forEach(page => page.classList.add('hidden-page'));
            const playerPage = document.getElementById('playerPage');
            playerPage.classList.add('active');
            document.getElementById('categorySelector').value = cat;
            updateTrackDisplay();
            updateTimerDisplay();
            isPlaying = false;
            updatePlayButton();
            audioPlayer.pause();
            setTimeout(() => {
                isPlaying = true;
                updatePlayButton();
                startTimer();
                playCurrentTrack();
                setTimeout(() => addToRecent(currentCategory, currentTrackIndex), 1000);
            }, 500);
        }
        // ==================== EXPLORE & SEARCH ====================
        function getAllTracks() {
            const allTracks = [];
            for (const category in tracks) {
                tracks[category].forEach(track => allTracks.push({ ...track, category }));
            }
            return allTracks;
        }
        function getTracksByCategory(category) {
            return tracks[category] ? tracks[category].map(t => ({ ...t, category })) : [];
        }
        function searchTracks(query) {
            if (!query?.trim()) return [];
            const q = query.toLowerCase();
            return getAllTracks().filter(t =>
                t.title.toLowerCase().includes(q) ||
                t.genre.toLowerCase().includes(q) ||
                t.category.toLowerCase().includes(q)
            );
        }
        function displaySearchResults(results, title = 'Hasil Pencarian') {
            let container = document.getElementById('searchResults');
            if (!container) {
                const exploreContent = document.querySelector('#explorePageContent .app-content');
                const div = document.createElement('div');
                div.id = 'searchResults';
                div.style.marginTop = '20px';
                exploreContent.insertBefore(div, exploreContent.firstChild);
                container = div;
            }
            if (results.length === 0) {
                container.innerHTML = `
                    <div style="text-align: center; padding: 40px 20px; color: #666;">
                        <svg width="64" height="64" fill="none" stroke="currentColor" stroke-width="2" style="margin: 0 auto 16px; display: block;">
                            <circle cx="32" cy="32" r="30"/><line x1="20" y1="32" x2="44" y2="32"/>
                        </svg>
                        <h3 style="font-size: 18px; margin-bottom: 8px; color: #999;">Tidak Ditemukan</h3>
                        <p style="font-size: 14px;">Lagu tidak ditemukan</p>
                    </div>
                `;
                return;
            }
            let html = `<div class="section"><div class="section-title">${title}</div>`;
            results.forEach(track => {
                const idx = tracks[track.category].findIndex(t => t.file === track.file);
                html += `
                    <div class="track-item" onclick="playSearchedTrack('${track.category}', ${idx})">
                        <img src="${track.cover || 'data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'56\' height=\'56\'%3E%3Crect fill=\'%23${track.color.substring(1)}\' width=\'56\' height=\'56\'/%3E%3C/svg%3E'}" 
                             alt="${track.title}" class="track-cover" style="object-fit: cover;">
                        <div class="track-info">
                            <div class="track-title-lib">${track.title}</div>
                            <div class="track-meta">${track.genre.toUpperCase()}<br>${track.category}</div>
                        </div>
                        <div class="track-actions">
                            <button class="icon-btn" onclick="event.stopPropagation(); showMessage('Fitur favorit belum aktif')">
                                <svg width="20" height="20" fill="currentColor">
                                    <path d="M10 3l2.5 5.5 6 .5-4.5 4 1.5 6-5.5-3.5L4 19l1.5-6L1 9l6-.5z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                `;
            });
            html += '</div>';
            container.innerHTML = html;
        }
        function playSearchedTrack(category, trackIndex) {
            currentCategory = category;
            currentTrackIndex = trackIndex;
            resetTimer();
            document.querySelectorAll('.app-page').forEach(page => page.classList.add('hidden-page'));
            const playerPage = document.getElementById('playerPage');
            playerPage.classList.add('active');
            document.getElementById('categorySelector').value = category;
            updateTrackDisplay();
            updateTimerDisplay();
            setTimeout(() => {
                isPlaying = true;
                updatePlayButton();
                startTimer();
                playCurrentTrack();
                setTimeout(() => addToRecent(category, trackIndex), 1000);
            }, 300);
        }
        function filterByCategory(category, buttonElement) {
            const results = getTracksByCategory(category);
            displaySearchResults(results, `Kategori: ${category}`);
            document.querySelectorAll('#explorePageContent .filter-tab').forEach(btn => {
                btn.style.background = '#1a1a1a';
                btn.style.color = '#fff';
            });
            if (buttonElement) {
                buttonElement.style.background = '#fff';
                buttonElement.style.color = '#000';
            }
        }
        // ==================== RECENT TRACKS SYSTEM ====================
        let recentTracks = [];
        function loadRecentTracks() {
            const saved = localStorage.getItem('recentTracks');
            if (saved) recentTracks = JSON.parse(saved);
        }
        function saveRecentTracks() {
            localStorage.setItem('recentTracks', JSON.stringify(recentTracks));
        }
        function addToRecent(category, trackIndex) {
            const track = tracks[category][trackIndex];
            const recentTrack = {
                ...track,
                category,
                trackIndex,
                timestamp: new Date().toISOString(),
                playedAt: new Date().toLocaleString('id-ID', {
                    day: '2-digit', month: 'short', year: 'numeric',
                    hour: '2-digit', minute: '2-digit'
                })
            };
            recentTracks = recentTracks.filter(t => !(t.file === track.file && t.category === category));
            recentTracks.unshift(recentTrack);
            if (recentTracks.length > 20) recentTracks = recentTracks.slice(0, 20);
            saveRecentTracks();
            const libraryPage = document.getElementById('libraryPageContent');
            if (libraryPage && !libraryPage.classList.contains('hidden-page')) {
                displayRecentTracks();
            }
        }
        function displayRecentTracks(filterCategory = 'all') {
            const container = document.getElementById('libraryContent');
            if (!container) return;
            const tracksToShow = filterCategory === 'all'
                ? recentTracks
                : recentTracks.filter(t => t.category === filterCategory);
            if (tracksToShow.length === 0) {
                container.innerHTML = `
                    <div style="text-align: center; padding: 60px 20px; color: #666;">
                        <svg width="80" height="80" fill="none" stroke="currentColor" stroke-width="2" style="margin: 0 auto 20px; display: block; opacity: 0.3;">
                            <circle cx="40" cy="40" r="35"/>
                            <path d="M40 20v40M25 30l15-10 15 10M25 50l15-10 15 10"/>
                        </svg>
                        <h3 style="font-size: 18px; margin-bottom: 8px; color: #999;">${filterCategory === 'all' ? 'Belum Ada Riwayat' : 'Tidak Ada Lagu ' + filterCategory}</h3>
                        <p style="font-size: 14px;">Mulai dengarkan musik untuk melihat riwayat putar Anda</p>
                    </div>
                `;
                return;
            }
            let html = '<div class="section"><div class="section-title">Recently Played</div>';
            tracksToShow.forEach((track, index) => {
                html += `
                    <div class="track-item" onclick="playFromLibrary(${index}, '${filterCategory}')">
                        <img src="${track.cover || 'data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'56\' height=\'56\'%3E%3Crect fill=\'%23${track.color.substring(1)}\' width=\'56\' height=\'56\'/%3E%3C/svg%3E'}" 
                             alt="${track.title}" class="track-cover" style="object-fit: cover;">
                        <div class="track-info">
                            <div class="track-title-lib">${track.title}</div>
                            <div class="track-meta">${track.genre.toUpperCase()} • ${track.category}<br>${track.playedAt}</div>
                        </div>
                        <div class="track-actions">
                            <button class="icon-btn" onclick="event.stopPropagation(); removeFromRecent(${index}, '${filterCategory}')">
                                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M3 6h18M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                `;
            });
            html += '</div>';
            container.innerHTML = html;
        }
        function playFromLibrary(index, filterCategory) {
            let trackToPlay;
            if (filterCategory === 'all') {
                trackToPlay = recentTracks[index];
            } else {
                const filtered = recentTracks.filter(t => t.category === filterCategory);
                trackToPlay = filtered[index];
            }
            if (!trackToPlay) return;
            currentCategory = trackToPlay.category;
            currentTrackIndex = trackToPlay.trackIndex;
            resetTimer();
            document.querySelectorAll('.app-page').forEach(p => p.classList.add('hidden-page'));
            const playerPage = document.getElementById('playerPage');
            playerPage.classList.add('active');
            document.getElementById('categorySelector').value = currentCategory;
            updateTrackDisplay();
            updateTimerDisplay();
            setTimeout(() => {
                isPlaying = true;
                updatePlayButton();
                startTimer();
                playCurrentTrack();
            }, 300);
        }
        function removeFromRecent(index, filterCategory) {
            if (filterCategory === 'all') {
                recentTracks.splice(index, 1);
            } else {
                const filtered = recentTracks.filter(t => t.category === filterCategory);
                const trackToRemove = filtered[index];
                const actualIndex = recentTracks.findIndex(t =>
                    t.file === trackToRemove.file &&
                    t.category === trackToRemove.category &&
                    t.timestamp === trackToRemove.timestamp
                );
                if (actualIndex !== -1) recentTracks.splice(actualIndex, 1);
            }
            saveRecentTracks();
            displayRecentTracks(filterCategory);
            showMessage('Lagu dihapus dari riwayat', true);
        }
        // ==================== EVENT LISTENERS & INIT ====================
        document.addEventListener('DOMContentLoaded', function () {
            // Load recent tracks
            loadRecentTracks();
            // Library filter tabs
            document.querySelectorAll('.lib-filter').forEach(filter => {
                filter.addEventListener('click', function () {
                    const category = this.getAttribute('data-category');
                    document.querySelectorAll('.lib-filter').forEach(f => {
                        f.style.background = '#1a1a1a';
                        f.style.color = '#fff';
                    });
                    this.style.background = '#fff';
                    this.style.color = '#000';
                    displayRecentTracks(category);
                });
            });
            // Explore search & filter
            const searchInput = document.querySelector('#explorePageContent .search-input');
            if (searchInput) {
                let timeout;
                searchInput.addEventListener('input', e => {
                    clearTimeout(timeout);
                    timeout = setTimeout(() => {
                        const results = searchTracks(e.target.value);
                        displaySearchResults(results, 'Hasil Pencarian');
                    }, 300);
                });
                searchInput.addEventListener('keyup', e => {
                    if (!e.target.value.trim()) {
                        const container = document.getElementById('searchResults');
                        if (container) container.innerHTML = '';
                    }
                });
            }
            const filterTabs = document.querySelectorAll('#explorePageContent .filter-tab');
            const categories = ['Focus', 'Relax', 'Sleep', 'Meditate'];
            filterTabs.forEach((tab, i) => {
                tab.addEventListener('click', e => filterByCategory(categories[i], e.target));
            });
        });
        // ==================== MODAL & PROFILE HANDLERS ====================
        function openEditModal() { document.getElementById('editModal').classList.add('active'); }
        function closeEditModal() { document.getElementById('editModal').classList.remove('active'); }
        function openPasswordModal() { document.getElementById('passwordModal').classList.add('active'); }
        function closePasswordModal() { document.getElementById('passwordModal').classList.remove('active'); }
        function confirmDeleteAccount() { document.getElementById('deleteConfirmModal').classList.add('active'); }
        function closeDeleteModal() { document.getElementById('deleteConfirmModal').classList.remove('active'); }
        function togglePassword(id) {
            const el = document.getElementById(id);
            el.type = el.type === 'password' ? 'text' : 'password';
        }
        document.querySelectorAll('.modal-overlay').forEach(overlay => {
            overlay.addEventListener('click', e => {
                if (e.target === this) this.classList.remove('active');
            });
        });
        // Form handlers
        document.getElementById('editProfileForm')?.addEventListener('submit', function (e) {
            e.preventDefault();
            fetch('', { method: 'POST', body: new FormData(this) })
                .then(r => r.json())
                .then(data => {
                    showMessage(data.message, data.success);
                    if (data.success) {
                        closeEditModal();
                        setTimeout(() => location.reload(), 1000);
                    }
                });
        });
        document.getElementById('changePasswordForm')?.addEventListener('submit', function (e) {
            e.preventDefault();
            fetch('', { method: 'POST', body: new FormData(this) })
                .then(r => r.json())
                .then(data => {
                    showMessage(data.message, data.success);
                    if (data.success) {
                        closePasswordModal();
                        this.reset();
                    }
                });
        });
        document.getElementById('deleteAccountForm')?.addEventListener('submit', function (e) {
            e.preventDefault();
            if (!confirm('Yakin ingin menghapus akun? Tindakan ini tidak bisa dibatalkan!')) return;
            fetch('', { method: 'POST', body: new FormData(this) })
                .then(r => r.json())
                .then(data => {
                    showMessage(data.message, data.success);
                    if (data.success) {
                        setTimeout(() => window.location.href = 'sign_in.php', 2000);
                    } else {
                        closeDeleteModal();
                    }
                });
        });
    </script>
</body>
</html>