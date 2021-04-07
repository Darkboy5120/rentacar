<?php
require "../users/root.php";
require "../utils/token_validation.php";

if ($ci0->getCookie("securitykey") !== $ci0->getSecuritykey()
    ) {
    $mi0->abort(-1, NULL);
} else if (!isset($_POST["firstname"])
    || !isset($_POST["lastname"])
    ) {
    $mi0->abort(-2, NULL);
}

$admin_id = $ci0->getCookie("user_data")["pk_usuario"];
$nombre = $_POST["firstname"];
$apellido = $_POST["lastname"];

$mi0->begin();

$mi0->query("
    UPDATE
        usuario
    SET
        nombre = ?, apellido = ?
    WHERE pk_usuario = ?",
    $nombre, $apellido, $admin_id    
);
if ($mi0->result === TRUE) {
    $mi0->end("commit", 0, NULL);
} else {
    $mi0->end("rollback", -3, NULL);
}