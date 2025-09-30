<?php
function addClearNames(): string {
    // get the current list of names from the textarea
    $current = $_POST['namelist'] ?? '';

    if (isset($_POST['clear_btn'])) {
        return "";
    }

    if (isset($_POST['add_btn'])) {

        // convert the textarea string into an array of names
        $names = explode("\n", $current);

        $full = trim($_POST['fullname']);

        // split into first and last name
        [$first, $last] = explode(' ', $full);

        // add the new formatted last, first to the array
        $names[] = "$last, $first";

        // sort the names alphabetically
        sort($names, SORT_STRING);

        // turn the array back into one string with newlines
        return implode("\n", $names);
    }

    return $current;
}