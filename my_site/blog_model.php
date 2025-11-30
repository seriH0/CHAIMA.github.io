<?php
// Location of the blog JSON "database"
define('BLOG_DATABASE', 'blog_posts.json'); 
// ^ Feel free to move this path later when you reorganize your project

/**
 * Load all blog posts from disk.
 * Returns an array every time (never null) to avoid annoying errors in the controller.
 */
function load_all_posts() {

    // If the file doesn’t exist, let's just create an empty one.
    // This avoids PHP warnings and gives you a clean starting point.
    if (!file_exists(BLOG_DATABASE)) {
        file_put_contents(BLOG_DATABASE, json_encode([]));
        return [];
    }

    // Grab the JSON data from file
    $raw_json = file_get_contents(BLOG_DATABASE);

    // If file is empty or unreadable → return empty list instead of dying
    if ($raw_json === false || trim($raw_json) === '') {
        return [];
    }

    // Convert JSON to PHP array
    $decoded = json_decode($raw_json, true);

    // If decoding fails (broken JSON), at least don’t crash the whole site
    return is_array($decoded) ? $decoded : [];
}



/**
 * Add a new post to the JSON file.
 * Mandatory requirement: ADD functionality.
 */
function create_new_post($title, $fullText) {

    $all_posts = load_all_posts();

    // Simple unique ID generator using timestamp + random digits
    // Feels very “web-dev student project”, but it works perfectly.
    $id = 'p_' . time() . '_' . rand(1000, 9999);

    // Convert content into paragraphs separated by newlines
    $paragraph_list = array_filter(
        array_map('trim', explode("\n", $fullText))
    );

    // Build the object for this new blog entry
    $post = [
        'id' => $id,
        'date' => date('Y-m-d'),   // Automatic date: no user input necessary
        'title' => $title,
        'paragraphs' => $paragraph_list
    ];

    // Add new post to our blog array
    $all_posts[$id] = $post;

    // Save back to disk
    return file_put_contents(BLOG_DATABASE, json_encode($all_posts, JSON_PRETTY_PRINT)) !== false;
}



/**
 * Remove a post from the JSON file.
 * Mandatory requirement: DELETE functionality.
 */
function remove_post($postId) {

    $all_posts = load_all_posts();

    if (!isset($all_posts[$postId])) {
        // Trying to delete something that doesn’t exist — nothing to do
        return false;
    }

    unset($all_posts[$postId]); // goodbye post

    return file_put_contents(BLOG_DATABASE, json_encode($all_posts, JSON_PRETTY_PRINT)) !== false;
}



/**
 * Fetch a SINGLE post based on ID.
 * Useful for editing and displaying detailed pages.
 */
function fetch_post($postId) {
    $all_posts = load_all_posts();
    return $all_posts[$postId] ?? null;
}



/**
 * Update an existing post.
 * This fulfils EDIT (optional CRUD).
 */
function update_post($postId, $newTitle, $newContent) {

    $all_posts = load_all_posts();

    if (!isset($all_posts[$postId])) {
        return false; // Can't update what doesn’t exist
    }

    // Re-split text into paragraphs
    $paragraphs = array_filter(
        array_map('trim', explode("\n", $newContent))
    );

    // Apply changes
    $all_posts[$postId]['title'] = $newTitle;
    $all_posts[$postId]['paragraphs'] = $paragraphs;

    return file_put_contents(BLOG_DATABASE, json_encode($all_posts, JSON_PRETTY_PRINT)) !== false;
}
