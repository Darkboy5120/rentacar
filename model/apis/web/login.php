<?php
require "../users/root.php";

if (!isset($_POST["correo"])
    || !isset($_POST["contraseña"])
    ) {
    $mi0->abort(-1, NULL);
} else if ($ci0->getCookie("securitykey") !== $mi0->getSecuritykey()) {
    $mi0->abort(-2, NULL);
}

$correo = $_POST["correo"];
$contraseña = $_POST["contraseña"];

$mi0->begin();

$mi0->query("
    SELECT
        pk_usuario, contraseña, nombre
    FROM
        usuario
    WHERE correo = ?",
    $correo
);
if ($mi0->result->num_rows > 0) {
    $user_data = $mi0->result->fetch_all(MYSQLI_ASSOC)[0];
    if (password_verify($contraseña, $user_data["contraseña"])) {
        $ci0->setCookie("user_data", array(
            "pk_usuario" => $user_data["pk_usuario"],
            "nombre" => $user_data["nombre"]
        ));
        $mi0->end("commit", 0, NULL);
    }
    $mi0->end("rollback", -3, NULL);
} else {
    $mi0->end("rollback", -4, NULL);
}