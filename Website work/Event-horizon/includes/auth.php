
<?php

// Start a session if one hasn't already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check whether a user is logged in
function requireLogin() {

    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit;
    }

}

?>

