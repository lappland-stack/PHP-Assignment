
<?php

require_once 'includes/db.php';

session_start();

$error = "";

// Redirect users who are already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}

// Process the login form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Find the account using its username
    $sql = "SELECT user_id, username, password_hash
            FROM users
            WHERE username = :username";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(['username' => $username]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check the password against the stored hash
    if ($user && password_verify($password, $user['password_hash'])) {

        session_regenerate_id(true);

        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];

        header("Location: dashboard.php");
        exit;

    } else {

        $error = "Invalid username or password.";

    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Event Horizon</title>
    <link rel="stylesheet" href="CSS/style.css">
    <link rel="icon" href="favicon.webp">
</head>

<body>
<div class="content">

    <header>
        <h1>Event Horizon</h1>
        <p>Welcome back. Sign in to manage your bookings.</p>
    </header>

    <nav>
        <a href="index.php">Home</a>
        <a href="events.php">Events</a>
        <a href="login.php">Login</a>
    </nav>

    <main>
        <div class="login-container">

            <h2>Account Login</h2>

            <?php if ($error): ?>
                <p class="login-notice">
                    <?= htmlspecialchars($error) ?>
                </p>
            <?php endif; ?>

            <form class="login-form" action="login.php" method="POST">

                <label for="username">Username</label>

                <input
                    type="text"
                    id="username"
                    name="username"
                    placeholder="Enter your username"
                    required
                >

                <label for="password">Password</label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Enter your password"
                    required
                >

                <button class="main-button login-button" type="submit">
                    Sign In
                </button>

            </form>

            <p class="login-notice">
                Account registration is managed by the event administrator.
                Please contact an administrator if you need an account.
            </p>

            <p class="login-back">
                Not ready to sign in?
                <a href="events.php">Browse our events</a>.
            </p>

        </div>
    </main>

    <footer>
        <p>&copy; 2026 Event Horizon</p>
    </footer>

</div>
</body>
</html>

