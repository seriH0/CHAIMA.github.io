<?php
$showTodo = false;
$errorMessage = '';

//we want to only store the hash
$hashedPassword = 'b14e9015dae06b5e206c2b37178eac45e193792c5ccf1d48974552614c61f2ff';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $passwordEntered = $_POST['password'] ?? '';

    // Comparison, of the hash of password that was entered to stored hash
    if (hash('sha256', $passwordEntered) === $hashedPassword) {
        $showTodo = true; // if true , then it will be correct
    } else {
        $errorMessage = "Incorrect password. Please try again.";
    }
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
      <h2>Enter Password to Access To-Do List</h2>
      <form method="post" action="login.php">
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        <button type="submit">Login</button>
      </form>

      <?php if (!empty($errorMessage)): ?>
        <p style="color:red; font-weight:bold;"><?php echo htmlspecialchars($errorMessage); ?></p>
      <?php endif; ?>

    <?php else: ?>
      <!-- else, because if the password is right then the page will load -->
      <h1>My To-Do List</h1>

      <form id="todo-form">
        <input type="text" id="todo-input" placeholder="Enter new task">
        <button type="submit">Add to list</button>
      </form>

      <ul id="todo-list"></ul>
      <script src="todo.js"></script>
    <?php endif; ?>
  </div>

  <?php include 'footer.php'; ?>
</body>
</html>
