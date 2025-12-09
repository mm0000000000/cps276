<?php
require_once 'includes/security.php';

$links = '';

if (isLoggedIn()) {
    // staff + admin both get contact links
    $links .= '<li class="nav-item">
        <a class="nav-link" href="index.php?page=addContact">Add Contact</a>
    </li>';
    $links .= '<li class="nav-item">
        <a class="nav-link" href="index.php?page=deleteContacts">Delete Contact(s)</a>
    </li>';

    // admin gets extra links
    if (isAdmin()) {
        $links .= '<li class="nav-item">
            <a class="nav-link" href="index.php?page=addAdmin">Add Admin</a>
        </li>';
        $links .= '<li class="nav-item">
            <a class="nav-link" href="index.php?page=deleteAdmins">Delete Admin(s)</a>
        </li>';
    }

    // logout for all logged-in users
    $links .= '<li class="nav-item">
        <a class="nav-link" href="logout.php">Logout</a>
    </li>';
}

$nav = <<<HTML
<nav>
    <ul class="nav">
        $links
    </ul>
</nav>
HTML;
