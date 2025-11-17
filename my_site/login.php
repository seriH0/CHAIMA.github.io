<?php
include 'includes/config.php';

$showTodo = false;
$errorMessage = '';
$prefillUsername = '';
$hashedPassword = 'b14e9015dae06b5e206c2b37178eac45e193792c5ccf1d48974552614c61f2ff'; // "CS203"

$attemptsFile = __DIR__ . '/sessions/login_attempts.json';

// Load previous login attempts
if (file_exists($attemptsFile)) {
    $attempts = json_decode(file_get_contents($attemptsFile), true);
} else {
    $attempts = [];
}

// logut
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    session_destroy();
    session_start();
    $errorMessage = "Successfully logged out.";
}

// to pre-fill username if a cookie exists
if (isset($_COOKIE['todo-username'])) {
    $prefillUsername = $_COOKIE['todo-username'];
}

// attempting to login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username']) && isset($_POST['password'])) {
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
        // Verify password
        if (hash('sha256', $passwordEntered) === $hashedPassword) {
            // Successful login
            $_SESSION['is_logged_in'] = true;
            $showTodo = true;

            setcookie('todo-username', $usernameEntered, time() + 30*24*60*60);
            $prefillUsername = $usernameEntered;

            // Reseting for the attempts
            $attempts[$usernameEntered]['attempts'] = 0;
            $attempts[$usernameEntered]['locked_until'] = 0;
        } else {
            // Wrong password → increment attempts
            $attempts[$usernameEntered]['attempts'] += 1;

            if ($attempts[$usernameEntered]['attempts'] >= 3) {
                // Lock the user
                $attempts[$usernameEntered]['locked_until'] = time() + 30; // 30 seconds lock
                $attempts[$usernameEntered]['attempts'] = 0;
                $errorMessage = "Too many failed attempts. You are locked out for 30 seconds.";
            } else {
                $errorMessage = "Incorrect username or password. Attempt " . $attempts[$usernameEntered]['attempts'] . " of 3.";
            }
        }
    }

    // Save updated attempts back to file
    file_put_contents($attemptsFile, json_encode($attempts));
}

// Redirect if session is already logged in
if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true) {
    $showTodo = true;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Chaima">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login / To-Do List</title>
    <link rel="stylesheet" href="my_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <script src="nav.js" defer></script>
</head>
<body>
<nav id="main-nav"></nav>
<script>const current_path = location.pathname; setNav(current_path);</script>

<div class="body_wrapper">
    <?php if (!$showTodo): ?>
        <!-- Login Form -->
        <h2>Enter your credentials</h2>
        <form method="post" action="login.php">
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($prefillUsername); ?>" required><br><br>

            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required><br><br>

            <button type="submit">Login</button>
        </form>

        <?php if (!empty($errorMessage)): ?>
            <p style="color:red; font-weight:bold;"><?php echo htmlspecialchars($errorMessage); ?></p>
        <?php endif; ?>
    <?php else: ?>
        <!-- To-Do List Page -->
        <div style="position: relative;">
            <form method="post" action="login.php" style="position: absolute; top: 0; right: 0;">
                <button type="submit" name="logout">Log out</button>
            </form>
            <h1><?php echo htmlspecialchars($prefillUsername); ?>'s To-Do List</h1>

            <form id="todo-form">
                <input type="text" id="todo-input" placeholder="Enter new task">
                <button type="submit">Add to list</button>
            </form>

            <ul id="todo-list"></ul>
        </div>

        <script src="todo.js"></script>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
