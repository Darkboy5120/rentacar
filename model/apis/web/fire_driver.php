<?php
require "../users/root.php";
require "../utils/user_validation.php";

if ($ci0->getSession("securitykey") !== $ci0->getSecuritykey()
    ) {
    $mi0->abort(-1, NULL);
} else if (!isset($_POST["driver"])
    || !isset($_POST["new_fired"])) {
    $mi0->abort(-2, NULL);
}

$mi0->begin();

$admin_id = $ci0->getSession("user_data")["pk_usuario"];
$driver_id = $_POST["driver"];
$new_fired = $_POST["new_fired"];

$mi0->query("
    UPDATE conductor
    SET despedido = ?
    WHERE fk_usuario = ? AND fk_administrador = ?",
    $new_fired, $driver_id, $admin_id
);
if ($mi0->result === TRUE) {
    $mi0->end("commit", 0, NULL);
} else {
    $mi0->end("rollback", -3, NULL);
}
