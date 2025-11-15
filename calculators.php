<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Chaima">
    <title>Calculators</title>
    <link rel="stylesheet" href="my_style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="2-calculator_utils.js" defer></script>
    <script src="2-calculator.js" defer></script>
    <script src="nav.js"></script>

</head>

<body>
    <nav id="main-nav"></nav>
<script>
    const current_path = location.pathname;
    setNav(current_path);
</script>



    <div class="body_wrapper">
        <h1>Some calculators!</h1>

        <!-- Age -->
        <h2>How old are you in terms of days?</h2>
        <input type="date" id="DOB">
        <button onclick="compute_days()">Submit</button>
        <div id="output_days"></div>
        <hr>

        <!-- Circle area -->
        <h2>The radius and area of the biggest circle fitting in your screen</h2>
        <button onclick="compute_circle()">Submit</button>
        <div id="output_circle"></div>
        <hr>

        <!-- Palindrome -->
        <h2>Palindrome checker</h2>
        <input type="text" id="possible_palindrome">
        <button onclick="check_palindrome()">Submit</button>
        <div id="output_palindrome"></div>
        <hr>

        <!-- Fibonacci sequence -->
        <h2>Fibonacci sequence</h2>
        <input type="number" id="fibo_length" min="1" placeholder="Enter number of terms">
        <button onclick="create_fibo()">Submit</button>
        <div id="output_fibo"></div>
        <hr>
    </div>

   <?php include 'footer.php'; ?>

</body>
</html>