<?php
require "../users/root.php";
require "../utils/user_validation.php";

if (!TRUE
    ) {
    $mi0->abort(-1, NULL);
} else if (!isset($_REQUEST["correo"])
    || !isset($_REQUEST["contraseña"])
    ) {
    $mi0->abort(-2, NULL);
}

$correo = $_REQUEST["correo"];
$contraseña = $_REQUEST["contraseña"];

$mi0->begin();

$mi0->query("
    SELECT
        pk_usuario, contraseña, nombre
    FROM
        usuario
    WHERE correo = ? AND tipo = '0'",
    $correo
);
if ($mi0->result->num_rows > 0) {
    $user_data = $mi0->result->fetch_all(MYSQLI_ASSOC)[0];
    if ($mi0->checkHash($contraseña, $user_data["contraseña"])) {
        $ci0->setSession("user_data", array(
            "pk_usuario" => $user_data["pk_usuario"],
            "nombre" => $user_data["nombre"]
        ));
        $mi0->end("commit", 0, NULL);
    }
    $mi0->end("rollback", -3, NULL);
} else {
    $mi0->end("rollback", -4, NULL);
}