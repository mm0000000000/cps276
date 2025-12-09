<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// require a logged in user
function checkAccess($roleRequired = null) {
    if (!isset($_SESSION['status'])) {
        header("Location: index.php?page=login");
        exit;
    }

    if ($roleRequired !== null && $_SESSION['status'] !== $roleRequired) {
        header("Location: index.php?page=welcome");
        exit;
    }
}

function isLoggedIn() {
    return isset($_SESSION['status']);
}

function isAdmin() {
    return isset($_SESSION['status']) && $_SESSION['status'] === 'admin';
}
