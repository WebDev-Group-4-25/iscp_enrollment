<?php
require_once '../includes/session.php';

// Destroy the session first
session_unset();
session_destroy();

// Start a new session to set flash message
session_start();
$_SESSION['flash'] = "You have been logged out.";

// Redirect to login
header("Location: login.php");
exit;
