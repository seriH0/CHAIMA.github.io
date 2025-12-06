<?php
// start the session if it hasn’t been initialized yet
if (session_status() === PHP_SESSION_NONE) {
    session_start();
    var_dump($_SESSION);

}

// header and the blog data functions
include 'header.php'; 
require_once 'blog_model.php'; 

// taking all posts from the JSON file
$posts = load_all_posts();

// checking if the user is logged in ro not
// Allow admin view via session OR a query flag (?admin=1) for environments without a dedicated blog login.
// This does NOT bypass your security in the controller; it only reveals UI controls. 
$is_admin_session = isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true;
$is_admin_query   = (isset($_GET['admin']) && $_GET['admin'] === '1');
$is_admin = $is_admin_session || $is_admin_query;
?>

<div class="blog-hero" style="text-align:center; padding:40px 20px; background:#b2d8d8; border-radius:8px; margin-bottom:20px;">
    <h1 style="font-size:2.5rem; margin:0; color:#333; font-family:'Georgia',serif;">The Developer's Blog</h1>
    <p style="font-size:1.2rem; color:#555; margin-top:10px;">Documenting the journey of building a robust Web Architecture.</p>
</div>

<!-- Theme toggle button -->
<div style="text-align:center; margin:20px;">
    <button id="theme-toggle" 
            style="padding:10px 20px; border:none; border-radius:5px; cursor:pointer; background:#333; color:#fff;">
        Toggle Light/Dark Theme
    </button>
</div>

<?php if ($is_admin): ?>
<!-- to show the add post button but only for logged-in users -->
<div style="text-align: center; margin-top: 20px; margin-bottom: 20px;">
    <a href="blog_add.php" 
       style="background-color: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 4px; display: inline-block;">
        + Add New Post
    </a>
</div>
<?php endif; ?>

<div class="blog-container">

    <main class="blog-main">
        <?php
        if (!empty($posts)) {
            // switching the order so that the last posts appears first
            // If your JSON is an associative array keyed by ID, array_values ensures proper reindexing for array_reverse.
            $posts_list = is_array($posts) ? array_values($posts) : [];
            $posts_list = array_reverse($posts_list);

            // ✅ show number of posts
            echo '<p style="text-align:center; font-weight:bold; margin-bottom:20px;">Total Posts: ' . count($posts_list) . '</p>';
            
            foreach ($posts_list as $post) {
                // Each post is wrapped in an article block
                echo '<article id="' . htmlspecialchars($post['id']) . '" class="blog-article">';
                
                // If logged in, show edit/delete controls for this post
                if ($is_admin) {
                    echo '<div class="admin-controls" style="position: absolute; top: 15px; right: 20px; font-size: 0.9rem;">';
                    
                    // Link to edit page
                    echo '<a href="blog_edit.php?id=' . htmlspecialchars($post['id']) . '" 
                             style="color: #92ccd9ff; text-decoration: none; margin-right: 15px;">
                             [EDIT]
                          </a>';

                    // Link to delete action with confirmation
                    echo '<a href="blog_controller.php?action=delete&id=' . htmlspecialchars($post['id']) . '" 
                             onclick="return confirm(\'Are you sure you want to delete this post?\');"
                             style="color: #f39716ff; text-decoration: none;">
                             [DELETE]
                          </a>';
                    echo '</div>';
                }

                // Display the post title and date
                echo '<h2>' . htmlspecialchars($post['title']) . '</h2>';
                echo '<small>Posted: ' . htmlspecialchars($post['date']) . '</small>';
                
                // Handle collapsible content
                echo '<div class="post-content">';
                $is_first = true;
                $content_id = 'content-' . htmlspecialchars($post['id']);

                // Ensure paragraphs exist and are an array
                $paragraphs = isset($post['paragraphs']) && is_array($post['paragraphs']) ? $post['paragraphs'] : [];
                foreach ($paragraphs as $paragraph) {
                    if ($is_first) {
                        // to always show the first paragraph
                        echo '<p>' . htmlspecialchars($paragraph) . '</p>';
                        
                        // If there are more paragraphs, start a collapsible section
                        if (count($paragraphs) > 1) {
                            echo '<div id="' . $content_id . '" class="collapse">';
                            $is_first = false; 
                            continue;
                        }
                    } else {
                        echo '<p>' . htmlspecialchars($paragraph) . '</p>';
                    }
                }
                if (count($paragraphs) > 1) {
                    echo '</div>'; 
                    echo '<button class="btn btn-sm btn-link read-more-btn" type="button" 
                               data-bs-toggle="collapse" data-bs-target="#' . $content_id . '" 
                               aria-expanded="false" aria-controls="' . $content_id . '">';
                    echo 'Read More...';
                    echo '</button>';
                }
                echo '</div>';
                
                echo '</article>';
            }
        } else {
            // a message is shown if there are no posts yet
            echo '<p class="text-center p-5">No posts available. Log in to add one.</p>';
        }
        ?>
    </main>

    <aside class="blog-aside">
        <h3>Quick Navigation</h3>
        <ul>
            <?php
            // build a list of links to each post for quick access
            if (!empty($posts)) {
                $posts_list_nav = is_array($posts) ? array_values($posts) : [];
                foreach ($posts_list_nav as $post) { 
                    echo '<li>';
                    echo '<a href="#' . htmlspecialchars($post['id']) . '">';
                    echo htmlspecialchars($post['title']);
                    echo '</a>';
                    echo '</li>';
                }
            }
            ?>
        </ul>
    </aside>

</div>

<!-- ✅ Theme toggle script -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    const toggleBtn = document.getElementById("theme-toggle");
    toggleBtn.addEventListener("click", function() {
        document.body.classList.toggle("dark-theme");
    });
});
</script>


<?php include 'footer.php'; ?>
