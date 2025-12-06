<?php
session_start(); // MUST start session at the very top
include 'includes/config.php';

$showTodo = false;
$errorMessage = '';
$prefillUsername = '';
$hashedPassword = 'b14e9015dae06b5e206c2b37178eac45e193792c5ccf1d48974552614c61f2ff'; // "CS203"

$attemptsFile = __DIR__ . '/sessions/login_attempts.json';

// Load previous login attempts
if (file_exists($attemptsFile)) {
    $attempts = json_decode(file_get_contents($attemptsFile), true);
    if (!is_array($attempts)) {
        $attempts = [];
    }
} else {
    $attempts = [];
}

// Log out
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    session_destroy();
    session_start();
    $errorMessage = "Successfully logged out.";
}

// Pre-fill username if a cookie exists
if (isset($_COOKIE['todo-username'])) {
    $prefillUsername = $_COOKIE['todo-username'];
}

// Attempting to login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'], $_POST['password'])) {
    $usernameEntered = trim($_POST['username']);
    $passwordEntered = $_POST['password'];
    $prefillUsername = $usernameEntered;

    if (!isset($attempts[$usernameEntered])) {
        $attempts[$usernameEntered] = [
            'attempts' => 0,
            'locked_until' => 0
        ];
    }

    // Check if user is locked out
    if ($attempts[$usernameEntered]['locked_until'] > time()) {
        $remaining = $attempts[$usernameEntered]['locked_until'] - time();
        $errorMessage = "Too many failed attempts. Please wait $remaining seconds.";
    } else {
        // Correct password?
        if (hash('sha256', $passwordEntered) === $hashedPassword) {
            $_SESSION['is_logged_in'] = true;
            $_SESSION['username'] = $usernameEntered; // store username in session
            $showTodo = true;

            setcookie('todo-username', $usernameEntered, time() + 30*24*60*60);

            // Reset login attempts
            $attempts[$usernameEntered]['attempts'] = 0;
            $attempts[$usernameEntered]['locked_until'] = 0;
        } else {
            $attempts[$usernameEntered]['attempts'] += 1;

            if ($attempts[$usernameEntered]['attempts'] >= 3) {
                $attempts[$usernameEntered]['locked_until'] = time() + 30; // lock for 30 sec
                $attempts[$usernameEntered]['attempts'] = 0;
                $errorMessage = "Too many failed attempts. You are locked out for 30 seconds.";
            } else {
                $errorMessage = "Incorrect username or password. Attempt " . $attempts[$usernameEntered]['attempts'] . " of 3.";
            }
        }
    }

    // Save updated attempts
    file_put_contents($attemptsFile, json_encode($attempts));
}

// Redirect if session is already logged in
if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true) {
    $showTodo = true;
    $prefillUsername = $_SESSION['username'] ?? $prefillUsername;
}
?>
