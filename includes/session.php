<?php
// Start the session if it hasn't already been started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function is_logged_in()
{
    return isset($_SESSION['user_id']);
}

function require_login()
{
    if (!is_logged_in()) {
        if (empty($_SESSION['flash'])) {
            $_SESSION['flash'] = "Please log in to continue.";
        }
        header('Location: /iscp_enrollment/pages/login.php');
        exit;
    }
}
