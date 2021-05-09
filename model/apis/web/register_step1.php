<?php
require "../users/root.php";

if ($ci0->getSession("securitykey") !== $ci0->getSecuritykey()) {
    $mi0->abort(-1, NULL);
} else if (!isset($_POST["correo"])
    ) {
    $mi0->abort(-2, NULL);
}

$correo = $_POST["correo"];

$mi0->begin();

$mi0->query("
    SELECT
        pk_usuario
    FROM
        usuario
    WHERE correo = ?",
    $correo
);
if ($mi0->result->num_rows === 0) {
    $mi0->end("commit", 0, NULL);
} else {
    $mi0->end("rollback", -3, NULL);
}
