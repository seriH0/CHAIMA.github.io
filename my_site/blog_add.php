<?php
// Start the session so we can check login status
session_start();

// Basic authentication check.
// If the user somehow landed here without logging in,
// kick them back to the login page.
if (empty($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

// Bring in the header template for consistent layout
include 'header.php';
?>

<div class="container" style="
    max-width: 600px;
    margin: 50px auto;
    padding: 20px;
    background: #fff;
    border-radius: 8px;
">
    <h2>Create a New Blog Entry</h2>

    <!-- 
        This form sends the user's input to blog_controller.php.
        The hidden 'action' field tells the controller EXACTLY what to do.
    -->
    <form action="blog_controller.php" method="POST">
        <input type="hidden" name="action" value="add">

        <!-- Title Field -->
        <div style="margin-bottom: 15px;">
            <label for="title" style="display: block; margin-bottom: 5px;">
                Post Title:
            </label>
            <input 
                type="text" 
                id="title" 
                name="title" 
                required
                style="width: 100%; padding: 8px;"
            >
        </div>

        <!-- Content Field -->
        <div style="margin-bottom: 15px;">
            <label for="content" style="display: block; margin-bottom: 5px;">
                Post Content  
                <small style="color:#666;">(Press enter twice to make paragraphs)</small>
            </label>
            <textarea 
                id="content" 
                name="content" 
                rows="10" 
                required 
                style="width: 100%; padding: 8px;"
            ></textarea>
        </div>

        <!-- Buttons -->
        <button 
            type="submit"
            style="
                background-color: #28a745;
                color: white;
                padding: 10px 15px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
            "
        >
            Publish Post
        </button>

        <a 
            href="blog.php"
            style="margin-left: 10px; color: #007bff; text-decoration: none;"
        >
            Cancel
        </a>
    </form>
</div>

<!-- Optional autosave script -->
<script src="autosave.js"></script>

<?php
// Footer template
include 'footer.php';
?>
