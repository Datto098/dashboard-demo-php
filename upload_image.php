<?php
// target dir
// filename
// filetype

if (isset($_FILES["fileUpload"])) {

    var_dump($_FILES['fileUpload']);
    $target_dir = "images/";
    $filename = time() . basename($_FILES['fileUpload']['name']);
    $target_file = $target_dir . $filename;

    if (move_uploaded_file($_FILES["fileUpload"]["tmp_name"], $target_file)) {
        echo "Upload successfully";
    }
}
