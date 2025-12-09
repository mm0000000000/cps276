<?php
require_once 'includes/security.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'login';

switch ($page) {
    case 'login':
        // if already logged in, go to welcome instead of showing login
        if (isLoggedIn()) {
            header("Location: index.php?page=welcome");
            exit;
        }
        require_once 'views/loginForm.php';
        break;

    case 'welcome':
        checkAccess();
        require_once 'views/welcome.php';
        break;

    case 'addContact':
        checkAccess();
        require_once 'views/addContactForm.php';
        break;

    case 'deleteContacts':
        checkAccess();
        require_once 'views/deleteContactsTable.php';
        break;

    case 'addAdmin':
        checkAccess('admin');
        require_once 'views/addAdminForm.php';
        break;

    case 'deleteAdmins':
        checkAccess('admin');
        require_once 'views/deleteAdminsTable.php';
        break;

    default:
        // default back to login
        header("Location: index.php?page=login");
        exit;
}
