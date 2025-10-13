<?php
class Directories {

    private $base_dir;

    public function __construct() {
        // when we construct this class set our base directory
        $this->base_dir = __DIR__ . "/../directories";
    }

    public function createDirectory($folder_name, $file_text) {
        // set the dir path
        $dir_path = $this->base_dir . "/" . $folder_name;

        // if we already have the dir just return that it exists
        if (is_dir($dir_path)) {
            return ["status" => "exists"];
        }

        // make the dir, if we can't return that we failed
        if (!mkdir($dir_path, 0777, true)) {
            return ["status" => "error", "message" => "Unable to create directory."];
        }

        // create the readme, if we fail return that
        $file_path = $dir_path . "/readme.txt";
        $file = fopen($file_path, "w");

        if (!$file) {
            return ["status" => "error", "message" => "Unable to create file."];
        }

        // write our text to that file
        fwrite($file, $file_text);
        fclose($file);

        // return the relative path to the file and success
        $relative_path = "directories/" . $folder_name . "/readme.txt";
        return ["status" => "success", "path" => $relative_path];
    }
}
?>
