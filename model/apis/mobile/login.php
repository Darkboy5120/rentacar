<?php
require "../users/root.php";

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
        pk_usuario, contraseña, nombre, tipo
    FROM
        usuario
    WHERE correo = ? AND tipo = '1' OR tipo = '2'",
    $correo
);
if ($mi0->result->num_rows > 0) {
    $user_data = $mi0->result->fetch_all(MYSQLI_ASSOC)[0];
    if ($mi0->checkHash($contraseña, $user_data["contraseña"])) {
        $user_final_data = array(
            "pk_usuario" => $user_data["pk_usuario"],
            "tipo" => $user_data["tipo"]
        );
        $mi0->end("commit", 0, $user_final_data);
    }
    $mi0->end("rollback", -3, NULL);
} else {
    $mi0->end("rollback", -4, NULL);
}