<?php
session_start();
if (empty($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}
include 'header.php';
?>

<div class="container" style="max-width:600px;margin:50px auto;padding:20px;background:#fff;border-radius:8px;">
    <h2>Create a New Blog Entry</h2>
    <form action="blog_controller.php" method="POST">
        <input type="hidden" name="action" value="add">

        <div style="margin-bottom:15px;">
            <label for="title">Post Title:</label>
            <input type="text" id="title" name="title" required style="width:100%;padding:8px;">
        </div>

        <div style="margin-bottom:15px;">
            <label for="content">Post Content <small>(blank lines = new paragraphs)</small></label>
            <textarea id="content" name="content" rows="10" required style="width:100%;padding:8px;"></textarea>
        </div>

        <button type="submit" style="background:#28a745;color:#fff;padding:10px 15px;border:none;border-radius:5px;cursor:pointer;">Publish Post</button>
        <a href="blog.php" style="margin-left:10px;color:#007bff;">Cancel</a>
    </form>
</div>

<?php include 'footer.php'; ?>


