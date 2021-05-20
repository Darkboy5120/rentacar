<?php
require "../users/root.php";
require "../utils/user_validation.php";

if (!isset($_REQUEST["correo"])
    || !isset($_REQUEST["telefono"])
    ) {
    $mi0->abort(-1, NULL);
}

$correo = $_REQUEST["correo"];
$telefono = $_REQUEST["telefono"];

$mi0->begin();

$mi0->query("
    SELECT
        correo
    FROM
        usuario
    WHERE correo = ? OR telefono = ?",
    $correo, $telefono
);
if ($mi0->result->num_rows > 0) {
    $user_data = $mi0->result->fetch_all(MYSQLI_ASSOC)[0];
    if ($user_data["correo"] == $correo) {
        $mi0->end("rollback", -2, NULL);
    }
    $mi0->end("rollback", -3, NULL);
} else {
    $mi0->end("commit", 0, NULL);
}