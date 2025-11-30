<?php
// start the session if it hasn’t been initialized yet
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// header and the blog data functions
include 'header.php'; 
require_once 'blog_model.php'; 

// taking all posts from the JSON file
$posts = get_blog_posts();

// checking if the user is logged in ro not
$is_admin = isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true;
?>

<div class="blog-hero">
    <h1>The Developer's Blog</h1>
    <p>Documenting the journey of building a robust Web Architecture.</p>
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
            $posts = array_reverse($posts);
            
            foreach ($posts as $post) {
                // Each post is wrapped in an article block
                echo '<article id="' . htmlspecialchars($post['id']) . '" class="blog-article">';
                
                // If logged in, show edit/delete controls for this post
                if ($is_admin) {
                    echo '<div style="position: absolute; top: 15px; right: 20px; font-size: 0.9rem;">';
                    
                    // Link to edit page
                    echo '<a href="blog_edit.php?id=' . $post['id'] . '" 
                             style="color: #92ccd9ff; text-decoration: none; margin-right: 15px;">
                             [EDIT]
                          </a>';

                    // Link to delete action with confirmation
                    echo '<a href="blog_controller.php?action=delete&id=' . $post['id'] . '" 
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

                foreach ($post['paragraphs'] as $paragraph) {
                    if ($is_first) {
                        // to always show the first paragraph
                        echo '<p>' . htmlspecialchars($paragraph) . '</p>';
                        
                        // If there are more paragraphs, start a collapsible section
                        if (count($post['paragraphs']) > 1) {
                            echo '<div id="' . $content_id . '" class="collapse">';
                            $is_first = false; 
                            continue;
                        }
                    } else {
                        echo '<p>' . htmlspecialchars($paragraph) . '</p>';
                    }
                }
                if (count($post['paragraphs']) > 1) {
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
                foreach ($posts as $post) { 
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

<?php include 'footer.php'; ?>
