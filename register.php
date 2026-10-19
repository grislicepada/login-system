<?php
session_start();
require 'db.php';

 $errors = [];
 $username = $email = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm  = $_POST['confirm_password'];

    if (empty($username)) $errors[] = "Username is required";
    if (empty($email)) $errors[] = "Email is required";
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid email format";
    if (empty($password)) $errors[] = "Password is required";
    elseif (strlen($password) < 6) $errors[] = "Password must be at least 6 characters";
    if ($password !== $confirm) $errors[] = "Passwords do not match";

    if (empty($errors)) {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hashed);
        if ($stmt->execute()) {
            header("Location: login.php?registered=1");
            exit;
        } else {
            $errors[] = "Username or Email already exists";
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="box">
        <h2>Register</h2>
        <?php if (!empty($errors)): ?>
            <div class="errors"><?php foreach ($errors as $e) echo "<p>$e</p>"; ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <input type="text" name="username" placeholder="Username" value="<?php echo htmlspecialchars($username); ?>" required>
            <input type="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($email); ?>" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            <button type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
</body>
</html>