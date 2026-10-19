<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - MyApp</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="dashboard-page">
    <nav class="navbar">
        <div class="logo">
            <div class="logo-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M12 2L2 7l10 5 10-5-10-5z"/>
                    <path d="M2 17l10 5 10-5"/>
                    <path d="M2 12l10 5 10-5"/>
                </svg>
            </div>
            <span>MyApp</span>
        </div>
        <div class="nav-right">
            <div class="user-badge">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                    <circle cx="12" cy="7" r="4"/>
                </svg>
                <?php echo htmlspecialchars($_SESSION['username']); ?>
            </div>
            <a href="logout.php" class="btn-logout">Logout</a>
        </div>
    </nav>

    <div class="dashboard-content">
        <p style="color: #718096; text-align: center; padding: 60px;">Welcome! More content coming soon.</p>
    </div>
</body>
</html>