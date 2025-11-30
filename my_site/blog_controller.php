<?php
require_once 'blog_model.php';

// Make sure the session exists (avoid warnings)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* -------------------------------------------------------
   BASIC SECURITY: 
   Only logged-in users should be allowed to modify anything.
---------------------------------------------------------*/
if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

/* -------------------------------------------------------
   FIGURE OUT WHAT THE USER IS TRYING TO DO
   - The “action” can come from either a POST or GET.
   - Examples:
     action=add
     action=delete
     action=update
---------------------------------------------------------*/
$action = $_POST['action'] ?? $_GET['action'] ?? null;

/*
    If no action was provided, then this controller
    doesn’t really have anything to do.
*/
if (!$action) {
    header("Location: blog.php");
    exit();
}

/* -------------------------------------------------------
   HANDLE THE SELECTED ACTION
---------------------------------------------------------*/
switch ($action) {

    /* -------------------- ADD A NEW POST -------------------- */
    case 'add':
        /*
            For adding a post, we expect a title + content from a form.
            Example: blog_add.php sends these fields.
        */
        if (!empty($_POST['title']) && !empty($_POST['content'])) {

            // Light sanitization (removes HTML tags, avoids weirdness)
            $title = htmlspecialchars($_POST['title']);
            $content = htmlspecialchars($_POST['content']);

            // Try saving it via the model
            $save_ok = save_new_blog_post($title, $content);

            if ($save_ok) {
                header("Location: blog.php?status=post_created");
                exit();
            }
        }

        // If something failed:
        header("Location: blog_add.php?error=create_failed");
        exit();


    /* -------------------- DELETE A POST -------------------- */
    case 'delete':
        /*
            Deleting is usually triggered via a link:
            blog_controller.php?action=delete&id=post_123
        */
        if (!empty($_GET['id'])) {
            $id = htmlspecialchars($_GET['id']);

            if (delete_blog_post($id)) {
                header("Location: blog.php?status=post_deleted");
                exit();
            }

            header("Location: blog.php?error=delete_failed");
            exit();
        }

        header("Location: blog.php?error=missing_id");
        exit();


    /* -------------------- UPDATE AN EXISTING POST -------------------- */
    case 'update':
        /*
            Updating comes from blog_edit.php
            Fields expected:
            - id
            - title
            - content
        */
        if (!empty($_POST['id']) && !empty($_POST['title']) && !empty($_POST['content'])) {

            $id      = htmlspecialchars($_POST['id']);
            $title   = htmlspecialchars($_POST['title']);
            $content = htmlspecialchars($_POST['content']);

            if (update_blog_post($id, $title, $content)) {
                header("Location: blog.php?status=post_updated");
                exit();
            }

            header("Location: blog.php?error=update_failed");
            exit();
        }

        header("Location: blog.php?error=missing_fields");
        exit();


    /* -------------------- UNKNOWN ACTION -------------------- */
    default:
        // Anything else = we don’t support it
        header("Location: blog.php?error=unknown_action");
        exit();
}

// Just in case something falls through
header("Location: blog.php");
exit();
