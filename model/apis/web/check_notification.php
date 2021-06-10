<?php
require "../users/root.php";
require "../utils/user_validation.php";

if (!isset($_POST["pk_notificacion"])
    ) {
        $mi0->abort(-1, NULL);
}

$user_id = $ci0->getSession("user_data")["pk_usuario"];
$pk_notificacion = $_POST["pk_notificacion"];

$mi0->begin();

$mi0->query("
    UPDATE
        notificacion
    SET
        visto = '1'
    WHERE pk_notificacion = ?",
    $pk_notificacion
);
if ($mi0->result === TRUE) {
    $mi0->end("commit", 0, NULL);
} else {
    $mi0->end("rollback", -2, NULL);
}