<?php
require "../users/root.php";
require "../utils/user_validation.php";

if (FALSE
    ) {
        $mi0->abort(-1, NULL);
}

$user_id = $ci0->getSession("user_data")["pk_usuario"];

$mi0->begin();

$mi0->query("
    SELECT
        notificacion_reporte.fk_reporte_devolucion
    FROM
        notificacion_reporte
    LEFT JOIN
        (notificacion)
    ON
        (notificacion.pk_notificacion = notificacion_reporte.fk_notificacion)
    WHERE notificacion.fk_usuario = ? AND notificacion.visto = '1'",
    $user_id
);
if ($mi0->result->num_rows > 0) {
    $data = $mi0->result->fetch_all(MYSQLI_ASSOC);
    $mi0->end("commit", 0, $data);
} else {
    $mi0->end("rollback", -2, NULL);
}