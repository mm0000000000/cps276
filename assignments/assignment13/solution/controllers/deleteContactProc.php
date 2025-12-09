<?php
require_once '../classes/Pdo_methods.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['chkbx']) && is_array($_POST['chkbx'])) {
        $pdo = new PdoMethods();
        $successful = true;

        // go over each checkbox and bind
        foreach ($_POST['chkbx'] as $id) {
            $sql = "DELETE FROM contacts WHERE id = :id";
            $bindings = [[':id', $id, 'int']];
            $result = $pdo->otherBinded($sql, $bindings);
            if ($result === 'error') {
                $successful = false;
            }
        }

        if ($successful) {
            header("Location: ../index.php?page=deleteContacts&msg=deleted");
            exit;
        } else {
            header("Location: ../index.php?page=deleteContacts&msg=error");
            exit;
        }
    }

    header("Location: ../index.php?page=deleteContacts");
    exit;
}

header("Location: ../index.php?page=deleteContacts");
exit;
