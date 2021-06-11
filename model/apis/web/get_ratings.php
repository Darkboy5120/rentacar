<?php
require "../users/root.php";
require "../utils/user_validation.php";

if (!isset($_POST["pk_auto"])
    ) {
    $mi0->abort(-1, NULL);
}

$mi0->begin();

$admin_id = $ci0->getSession("user_data")["pk_usuario"];
$pk_auto = $_POST["pk_auto"];

$mi0->query("
    SELECT
        auto_puntuacion.puntuacion,
        auto_puntuacion.comentarios
    FROM
        auto_puntuacion
    LEFT JOIN
        (auto)
    ON
        (auto_puntuacion.fk_auto = auto.pk_auto)
    WHERE auto.fk_administrador = ? AND auto_puntuacion.fk_auto = ?",
    $admin_id, $pk_auto
);
if ($mi0->result->num_rows === 0) {
    $mi0->end("rollback", -2, NULL);
} else {
    $data = $mi0->result->fetch_all(MYSQLI_ASSOC);
    $mi0->end("commit", 0, $data);
}