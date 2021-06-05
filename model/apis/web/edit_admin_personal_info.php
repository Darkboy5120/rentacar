<?php
require "../users/root.php";
require "../utils/user_validation.php";

if ($ci0->getSession("securitykey") !== $ci0->getSecuritykey()
    ) {
    $mi0->abort(-1, NULL);
} else if (!isset($_POST["firstname"])
    || !isset($_POST["lastname"])
    ) {
    $mi0->abort(-2, NULL);
}

$admin_id = $ci0->getSession("user_data")["pk_usuario"];
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
    $new_user_data = $ci0->getSession("user_data");
    $new_user_data["nombre"] = $nombre;
    $ci0->setSession("user_data", $new_user_data);
    $mi0->end("commit", 0, NULL);
} else {
    $mi0->end("rollback", -3, NULL);
}