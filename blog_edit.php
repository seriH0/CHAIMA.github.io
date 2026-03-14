<?php
session_start();
require_once 'blog_model.php';

if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

if (empty($_GET['id'])) {
    header("Location: blog.php?error=missing_id");
    exit();
}

$post_id = htmlspecialchars($_GET['id']);
$post_data = fetch_post($post_id);

if (!$post_data) {
    header("Location: blog.php?error=post_not_found");
    exit();
}

$combined_content = implode("\n\n", $post_data['paragraphs']);
include 'header.php';
?>

<div class="container" style="max-width:620px;margin:40px auto;padding:20px;background:#fff;border-radius:10px;box-shadow:0 0 8px rgba(0,0,0,0.1);">
    <h2>Editing Post: <?php echo htmlspecialchars($post_data['title']); ?></h2>
    <form method="POST" action="blog_controller.php">
        <input type="hidden" name="action" value="update">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($post_data['id']); ?>">

        <div style="margin-bottom:15px;">
            <label for="title">Post Title</label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($post_data['title']); ?>" required style="width:100%;padding:10px;">
        </div>

        <div style="margin-bottom:15px;">
            <label for="content">Post Content <small>(blank lines = new paragraphs)</small></label>
            <textarea id="content" name="content" rows="10" required style="width:100%;padding:10px;"><?php echo htmlspecialchars($combined_content); ?></textarea>
        </div>

        <button type="submit" style="background:#007bff;color:#fff;padding:10px 18px;border:none;border-radius:5px;cursor:pointer;">Save</button>
        <a href="blog.php" style="margin-left:15px;color:#007bff;">Cancel</a>
    </form>
</div>

<?php include 'footer.php'; ?>
