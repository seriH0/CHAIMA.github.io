<?php
require_once 'blog_model.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* Only logged-in users can modify posts */
if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

$action = $_POST['action'] ?? $_GET['action'] ?? null;
if (!$action) {
    header("Location: blog.php");
    exit();
}

switch ($action) {

    /* ----------------------------------------
       ADD NEW POST
    ---------------------------------------- */
    case 'add':
        if (!empty($_POST['title']) && !empty($_POST['content'])) {

            $title   = trim($_POST['title']);   // RAW
            $content = trim($_POST['content']); // RAW

            if (create_new_post($title, $content)) {
                header("Location: blog.php?status=post_created");
                exit();
            }
        }
        header("Location: blog_add.php?error=create_failed");
        exit();


    /* ----------------------------------------
       DELETE POST
    ---------------------------------------- */
    case 'delete':
        if (!empty($_GET['id'])) {

            $id = $_GET['id']; // RAW

            if (remove_post($id)) {
                header("Location: blog.php?status=post_deleted");
                exit();
            }

            header("Location: blog.php?error=delete_failed");
            exit();
        }
        header("Location: blog.php?error=missing_id");
        exit();


    /* ----------------------------------------
       UPDATE POST
    ---------------------------------------- */
    case 'update':
        if (!empty($_POST['id']) && !empty($_POST['title']) && !empty($_POST['content'])) {

            $id      = $_POST['id'];           // RAW
            $title   = trim($_POST['title']);  // RAW
            $content = trim($_POST['content']); // RAW

            if (update_post($id, $title, $content)) {
                header("Location: blog.php?status=post_updated");
                exit();
            }

            header("Location: blog.php?error=update_failed");
            exit();
        }

        header("Location: blog.php?error=missing_fields");
        exit();


    /* ----------------------------------------
       UNKNOWN ACTION
    ---------------------------------------- */
    default:
        header("Location: blog.php?error=unknown_action");
        exit();
}
