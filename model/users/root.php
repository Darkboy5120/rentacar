<?php
$posible_path = array(
    "../libraries/mysql_interface.php",
    "model/libraries/mysql_interface.php",
);

foreach ($posible_path as &$path) {
    if (file_exists($path)) {
        require $path;
        break;
    }
}

$mi0 = new MysqlInterface(
    "localhost",
    "root",
    "",
    "rentacar"
);