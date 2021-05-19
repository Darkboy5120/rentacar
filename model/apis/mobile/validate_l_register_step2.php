<?php
require "../users/root.php";
require "../utils/user_validation.php";

if (!isset($_REQUEST["correo"])
    ) {
    $mi0->abort(-1, NULL);
}

$correo = $_REQUEST["correo"];

$mi0->begin();

$mi0->query("
    SELECT
        pk_usuario
    FROM
        usuario
    WHERE correo = ?",
    $correo
);
if ($mi0->result->num_rows > 0) {
    $mi0->end("rollback", -2, NULL);
} else {
    $mi0->end("commit", 0, NULL);
}