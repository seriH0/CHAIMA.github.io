document.addEventListener("DOMContentLoaded", () => {
     // this one is for autosaveing
    // Grab the form elements we care about.
    // (They only exist on blog_add.php, so the checks below avoid errors.)
    const titleInput = document.querySelector("#title");
    const contentInput = document.querySelector("#content");
    const form = document.querySelector("#add-post-form");

    // -----------------------------
    // 1. Load any saved draft data
    // -----------------------------
    // If the user typed something before and didn't submit,
    // we refill the boxes so they can continue writing.
    if (titleInput) {
        const savedTitle = localStorage.getItem("draft_blog_title");
        titleInput.value = savedTitle || "";
    }

    if (contentInput) {
        const savedContent = localStorage.getItem("draft_blog_content");
        contentInput.value = savedContent || "";
    }

    // --------------------------------
    // 2. Save draft while user types
    // --------------------------------
    // Every keystroke = updated storage.
    if (titleInput) {
        titleInput.addEventListener("input", () => {
            localStorage.setItem("draft_blog_title", titleInput.value);
        });
    }

    if (contentInput) {
        contentInput.addEventListener("input", () => {
            localStorage.setItem("draft_blog_content", contentInput.value);
        });
    }

    // ---------------------------------------------------
    // 3. Wipe saved draft as soon as the post is submitted
    // ---------------------------------------------------
    // This prevents old drafts from reappearing after saving.
    if (form) {
        form.addEventListener("submit", () => {
            localStorage.removeItem("draft_blog_title");
            localStorage.removeItem("draft_blog_content");
        });
    }
});
