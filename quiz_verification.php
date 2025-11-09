<?php
// ncluding the nav and footer to keep a consistent design
echo '<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="author" content="Chaima">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Quiz Results</title>
  <link rel="stylesheet" href="my_style.css">
  <script src="nav.js"></script>
</head>
<body>
  <nav id="main-nav"></nav>
  <script>
    const current_path = location.pathname;
    setNav(current_path);
  </script>
  <div class="body_wrapper">';
?>

<?php
// response possible
$name = htmlspecialchars($_GET["name"] ?? "");
$email = htmlspecialchars($_GET["email"] ?? "");
$q1 = $_GET["q1"] ?? "";
$q2 = $_GET["q2"] ?? "";
$q3 = $_GET["q3"] ?? "";
$q4 = $_GET["q4"] ?? "";
$q5 = $_GET["q5"] ?? "";

// --- Validating 
if (empty($name) || empty($email) || empty($q1) || empty($q2) || empty($q3) || empty($q4) || empty($q5)) {
    echo "<h2>Please fill in all the fields before submitting the quiz.</h2>";
} else {
    //  Computing the score 
    $score = 0;

    if ($q1 == "a") $score += 10;
    elseif ($q1 == "b") $score += 20;
    elseif ($q1 == "c") $score += 30;

    if (intval($q2) >= 5) {
    $score += intval($q2) * 10;  // big boost for 5 or more kids since getting a score of 100 was pretty hard i noticed
} else {
    $score += intval($q2) * 2;   // normal calculation
}


    if ($q3 == "Sunny") $score += 20;
    elseif ($q3 == "Rainy") $score += 10;
    else $score += 15;

    if ($q4 == "beach") $score += 25;
    elseif ($q4 == "mountains") $score += 20;
    else $score += 10;

    if (is_array($q5)) $score += count($q5) * 5;

    // show all categories and highlight the matching one 
    $categories = [
        "Comfy individual — relaxed and calm!" => [
            "min" => 0,
            "max" => 49,
            "img" => "images/shy.png"
        ],
        "Balanced spirit — adaptable and open-minded!" => [
            "min" => 50,
            "max" => 99,
            "img" => "images/cool.png"
        ],
        "Adventurous soul — energetic and on-the-go!" => [
            "min" => 100,
            "max" => 1000,
            "img" => "images/chill.png"
        ]
    ];

    echo "<h2>Hello, $name!</h2>";
    echo "<p>Your total score is <strong>$score</strong>.</p>";
    echo "<h3>Results:</h3>";
    // I wanted my images to be shown next to each other and not on top of each other so i fixed the flex-direction: row
    echo "<div class='results-wrapper' style='display:flex; flex-direction:row; gap:20px; justify-content:center; flex-wrap:wrap;'>";

    foreach ($categories as $desc => $data) {
        $highlight = ($score >= $data['min'] && $score <= $data['max']) ? 
                     "background-color:#b2d8d8; font-weight:bold; padding:10px; border-radius:8px;" : 
                     "padding:10px;";
        echo "<div style='$highlight; text-align:center;'>";
        echo "<img src='{$data['img']}' alt='Emoji' width='100'><br>";
        echo "<p style='margin:5px 0;'>$desc</p>";
        echo "</div>";
    }

    echo "</div>";
}
?>

<?php
echo "</div>";
include 'footer.php';
echo "</body></html>";
?>
