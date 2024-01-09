<?php
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "backend1");
define("DB_CHARSET", "utf8mb4");
define("PORT", 3306);
define("BASE_URL", $_SERVER['DOCUMENT_ROOT'] . '/demo/');
spl_autoload_register(function ($className) {
    require_once BASE_URL . "admin/models/$className.php";
});

include_once BASE_URL . "admin/util/util.php";
