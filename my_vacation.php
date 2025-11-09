<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Chaima">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Dream Vacation</title>
    <link rel="stylesheet" href="my_style.css">
    <script src="nav.js"></script>
    <style>
        .vacation-img {
            width: 350px;          
            height: auto;          
            border: 4px solid #1bb8b5; 
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            margin: 10px;
            object-fit: cover; 
        }
        .image-container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav id="main-nav"></nav>
    <script>
        const current_path = location.pathname;
        setNav(current_path);
    </script>

    <!-- some page content -->
    <div class="body_wrapper">
        <h1>An Ideal Vacation</h1>
        <p>An ideal vacation would be visiting <strong>Japan</strong> or <strong>South Korea</strong> since their environment is very different from here.</p>

        <div class="image-container">
            <img src="images/tokyo.jpeg" alt="Japan" class="vacation-img">
            <img src="images/seoul.webp" alt="Korea" class="vacation-img">
        </div>

        <h2>A few things I would never miss:</h2>
        <ul>
            <li>Visit Tokyo and Seoul</li>
            <li>Visit traditional temples</li>
            <li>Obviously eat anything and everything</li>
        </ul>
    </div>
</body>
</html>