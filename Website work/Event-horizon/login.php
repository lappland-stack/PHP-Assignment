
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

            <form class="login-form" action="#" method="post">

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

                <div class="remember-me">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Remember me</label>
                </div>

                <button class="main-button login-button" type="button">
                    Sign In
                </button>

            </form>

            <p class="login-notice">
                Account registration is managed by the event administrator.
                Please contact an administrator if you need an account.
            </p>

            <p class="login-back">
                Not ready to sign in? <a href="events.php">Browse our events</a>.
            </p>

        </div>
    </main>

    <footer>
        <p>&copy; 2026 Event Horizon</p>
    </footer>

</div>
</body>
</html>

