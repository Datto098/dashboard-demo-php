<?php
include_once "config/database.php";

if (isset($_GET['id'])) {
    $product = new Product();
    $id = $_GET['id'];
    if ($product->deleteProduct($id)) {
        header("location: ./index.php");
    }
}
