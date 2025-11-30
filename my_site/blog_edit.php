<?php
session_start();
require_once 'blog_model.php';  // pulling in our data functions

// ---------------------------------------------------------------
// STEP 1: Make sure user is allowed to be here by verificatio
// ---------------------------------------------------------------
if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
    // User is not logged in, so we politely kick them back to login
    header("Location: login.php");
    exit();
}

// ---------------------------------------------------------------
// STEP 2: Validate the ID coming from the URL
// ---------------------------------------------------------------
if (empty($_GET['id'])) {
    header("Location: blog.php?error=missing_id");
    exit();
}

// sanitize just to avoid weird characters sneaking through
$post_id = htmlspecialchars($_GET['id']);

// ---------------------------------------------------------------
// STEP 3: Get the actual post from the model
// ---------------------------------------------------------------
$post_data = get_single_post($post_id);

if (!$post_data) {
    // If the ID didn’t match anything, no point continuing
    header("Location: blog.php?error=post_not_found");
    exit();
}

/*
    The database (JSON file) stores the text as paragraphs inside an array.
    But textarea expects ONE big text block.

    So: glue the array back together with newlines so the textarea shows it properly.
*/
$combined_content = implode("\n\n", $post_data['paragraphs']);

include 'header.php';
?>

<!-- -----------------------------------------------------------
     VIEW SECTION — everything here is HTML for the edit form
------------------------------------------------------------ -->

<div class="container" style="
    max-width: 620px; 
    margin: 40px auto; 
    padding: 20px; 
    background: #ffffff; 
    border-radius: 10px;
    box-shadow: 0 0 8px rgba(0,0,0,0.1);
">
    
    <h2 style="margin-bottom: 20px;">
        Editing Post: <?php echo htmlspecialchars($post_data['title']); ?>
    </h2>

    <!-- This form sends stuff to the controller -->
    <form method="POST" action="blog_controller.php">

        <!-- Hidden values so controller knows what we are doing -->
        <input type="hidden" name="action" value="update">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($post_data['id']); ?>">

        <!-- EDIT TITLE -->
        <div style="margin-bottom: 15px;">
            <label for="title" style="display:block; margin-bottom:5px;">Post Title</label>
            <input 
                type="text" 
                id="title" 
                name="title" 
                value="<?php echo htmlspecialchars($post_data['title']); ?>" 
                required
                style="width: 100%; padding: 10px;"
            >
        </div>

        <!-- EDIT CONTENT -->
        <div style="margin-bottom: 15px;">
            <label for="content" style="display:block; margin-bottom:5px;">
                Post Content  
                <span style="font-size: 12px; color: #666;">(Use blank lines to separate paragraphs)</span>
            </label>
            <textarea 
                id="content" 
                name="content" 
                rows="10"
                required
                style="width: 100%; padding: 10px;"
            ><?php echo htmlspecialchars($combined_content); ?></textarea>
        </div>

        <!-- BUTTONS -->
        <button type="submit" style="
            background:#007bff; 
            color:#fff; 
            padding: 10px 18px; 
            border:none; 
            border-radius:5px;
            cursor:pointer;
        ">Save</button>

        <a href="blog.php" style="margin-left: 15px; color:#007bff;">Cancel</a>
    </form>
</div>

<?php include 'footer.php'; ?>
