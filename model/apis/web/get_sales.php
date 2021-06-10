<?php
require "../users/root.php";
require "../utils/user_validation.php";

if (!isset($_POST["offset"])
    || !isset($_POST["limit"])
    ) {
    $mi0->abort(-1, NULL);
}

$mi0->begin();

$admin_id = $ci0->getSession("user_data")["pk_usuario"];
$offset = $_POST["offset"];
if ($offset < 0) {
    $offset = 0;
}
$max_limit = 15;
$limit = $_POST["limit"];
if ($limit > $max_limit) {
    $limit = $max_limit;
} else if ($limit <= 0) {
    $limit = 1;
}
$double_limit = $limit * 2;

$mi0->query("
    SELECT
        renta.pk_renta,
        renta.costo,
        renta.fk_conductor,
        renta.fk_auto,
        reporte_devolucion.pk_reporte_devolucion
    FROM
        renta
    LEFT JOIN
        (usuario_foto, reporte_devolucion)
    ON
        (renta.pk_renta = reporte_devolucion.fk_renta)
    WHERE conductor.fk_administrador = ? AND conductor.despedido = '0' AND $nombre_sql
        AND $apellido_sql
    ORDER BY usuario.pk_usuario ASC
    LIMIT $offset, $double_limit",
    $admin_id
);
if ($mi0->result->num_rows === 0) {
    $mi0->end("rollback", -2, NULL);
}

$data = array(
    "sales" => $mi0->result->fetch_all(MYSQLI_ASSOC)
);

$data["are_they_all"] = ($mi0->result->num_rows > $limit)
    ? FALSE : TRUE;

$count = 0;
while ($row = $mi0->result->fetch_assoc()) {
    if (++$count > $limit) {
        break;
    }
    array_push($data["sales"], $row);
}

$mi0->end("commit", 0, $data);