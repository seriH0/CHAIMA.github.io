<?php
// Location of the blog JSON "database"
define('BLOG_DATABASE', 'blog_posts.json'); 

/**
 * Load all blog posts from disk.
 */
function load_all_posts() {
    if (!file_exists(BLOG_DATABASE)) {
        file_put_contents(BLOG_DATABASE, json_encode([]));
        return [];
    }
    $raw_json = file_get_contents(BLOG_DATABASE);
    if ($raw_json === false || trim($raw_json) === '') {
        return [];
    }
    $decoded = json_decode($raw_json, true);
    return is_array($decoded) ? $decoded : [];
}

/**
 * Add a new post.
 */
function create_new_post($title, $fullText) {
    $all_posts = load_all_posts();
    $id = 'p_' . time() . '_' . rand(1000, 9999);

    $paragraph_list = array_filter(
        array_map('trim', preg_split("/\r?\n\r?\n/", $fullText))
    );

    $post = [
        'id' => $id,
        'date' => date('Y-m-d'),
        'title' => $title,
        'paragraphs' => $paragraph_list
    ];

    $all_posts[$id] = $post;
    return file_put_contents(BLOG_DATABASE, json_encode($all_posts, JSON_PRETTY_PRINT)) !== false;
}

/**
 * Delete a post.
 */
function remove_post($postId) {
    $all_posts = load_all_posts();
    if (!isset($all_posts[$postId])) {
        return false;
    }
    unset($all_posts[$postId]);
    return file_put_contents(BLOG_DATABASE, json_encode($all_posts, JSON_PRETTY_PRINT)) !== false;
}

/**
 * Fetch a single post.
 */
function fetch_post($postId) {
    $all_posts = load_all_posts();
    return $all_posts[$postId] ?? null;
}

/**
 * Update a post.
 */
function update_post($postId, $newTitle, $newContent) {
    $all_posts = load_all_posts();
    if (!isset($all_posts[$postId])) {
        return false;
    }
    $paragraphs = array_filter(
        array_map('trim', preg_split("/\r?\n\r?\n/", $newContent))
    );
    $all_posts[$postId]['title'] = $newTitle;
    $all_posts[$postId]['paragraphs'] = $paragraphs;
    return file_put_contents(BLOG_DATABASE, json_encode($all_posts, JSON_PRETTY_PRINT)) !== false;
}
