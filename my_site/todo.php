<?php
include 'includes/config.php';

if (empty($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

$username = $_SESSION['username'] ?? 'User';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?php echo htmlspecialchars($username); ?>'s To-Do List</title>
<link rel="stylesheet" href="my_style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<script src="nav.js" defer></script>
</head>
<body>
<nav id="main-nav"><?php include 'nav.html'; ?></nav>


<form method="post" action="login.php" style="position:absolute; top:10px; right:10px;">
    <button type="submit" name="logout">Log out</button>
</form>

<div class="body_wrapper">
    <h1>Welcome back, <?php echo htmlspecialchars($username); ?>!</h1>

    <form id="todo-form">
        <input type="text" id="todo-input" placeholder="Enter new task">
        <button type="submit">Add to list</button>
    </form>

    <ul id="todo-list"></ul>
</div>

<?php include 'footer.php'; ?>
<script src="todo.js"></script>
</body>
</html>
