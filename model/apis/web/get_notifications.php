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
        notificacion_reporte.fk_reporte_devolucion,
        reporte_devolucion.todo_bien,
        notificacion.pk_notificacion,
        notificacion.fecha_hora
    FROM
        notificacion_reporte
    LEFT JOIN
        (notificacion, reporte_devolucion)
    ON
        (notificacion.pk_notificacion = notificacion_reporte.fk_notificacion
            AND reporte_devolucion.pk_reporte_devolucion = notification_reporte.fk_reporte_devolucion)
    WHERE notificacion.fk_usuario = ? AND notificacion.visto = '1'",
    $user_id
);
if ($mi0->result->num_rows > 0) {
    $data = $mi0->result->fetch_all(MYSQLI_ASSOC);
    $mi0->end("commit", 0, $data);
} else {
    $mi0->end("rollback", -2, NULL);
}