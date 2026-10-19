<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Fetch full user info from database
 $user_id = $_SESSION['user_id'];
 $stmt = $conn->prepare("SELECT username, email, created_at FROM users WHERE id = ?");
 $stmt->bind_param("i", $user_id);
 $stmt->execute();
 $result = $stmt->get_result();
 $user = $result->fetch_assoc();
 $stmt->close();

// Calculate days since registration
 $created_date = new DateTime($user['created_at']);
 $now = new DateTime();
 $days = $created_date->diff($now)->days;

// Format the date nicely
 $formatted_date = $created_date->format('F j, Y');
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
                <?php echo htmlspecialchars($user['username']); ?>
            </div>
            <a href="logout.php" class="btn-logout">Logout</a>
        </div>
    </nav>

    <div class="dashboard-content">
        <div class="welcome-section">
            <h1>Welcome back, <?php echo htmlspecialchars($user['username']); ?>!</h1>
            <p>You're now logged in to your dashboard. Here's a quick overview of your account.</p>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon bg-purple">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                </div>
                <div class="stat-label">Username</div>
                <div class="stat-value"><?php echo htmlspecialchars($user['username']); ?></div>
            </div>
            <div class="stat-card">
                <div class="stat-icon bg-blue">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                        <polyline points="22,6 12,13 2,6"/>
                    </svg>
                </div>
                <div class="stat-label">Email Address</div>
                <div class="stat-value"><?php echo htmlspecialchars($user['email']); ?></div>
            </div>
            <div class="stat-card">
                <div class="stat-icon bg-green">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/>
                        <line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                </div>
                <div class="stat-label">Member Since</div>
                <div class="stat-value"><?php echo $formatted_date; ?></div>
            </div>
            <div class="stat-card">
                <div class="stat-icon bg-orange">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <polyline points="12,6 12,12 16,14"/>
                    </svg>
                </div>
                <div class="stat-label">Days Active</div>
                <div class="stat-value"><?php echo $days; ?> days</div>
            </div>
                    </div>
        </div>

        <div class="section-title">Quick Actions</div>
        <div class="actions-grid">
            <div class="action-card" onclick="alert('Profile feature coming soon!')">
                <div class="action-icon">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                </div>
                <h3>My Profile</h3>
                <p>View and edit your account details</p>
            </div>
            <div class="action-card" onclick="alert('Settings feature coming soon!')">
                <div class="action-icon">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="3"/>
                        <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/>
                    </svg>
                </div>
                <h3>Settings</h3>
                <p>Manage your account preferences</p>
            </div>
            <div class="action-card" onclick="alert('Messages feature coming soon!')">
                <div class="action-icon">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                    </svg>
                </div>
                <h3>Messages</h3>
                <p>Check your inbox and notifications</p>
            </div>
            <div class="action-card" onclick="alert('Activity feature coming soon!')">
                <div class="action-icon">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 12h-4l-3 9L9 3l-3 9H2"/>
                    </svg>
                </div>
                <h3>Activity</h3>
                <p>See your recent account activity</p>
            </div>
        </div>
    </div>

    <footer class="footer">
        &copy; <?php echo date('Y'); ?> MyApp. Built with PHP &amp; MySQL.
    </footer>
</body>
</html>