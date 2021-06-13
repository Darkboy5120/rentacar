<?php
require "../users/root.php";
require "../utils/user_validation.php";

if (!isset($_POST["offset"])
    || !isset($_POST["limit"])
    || !isset($_POST["pk_driver"])
    || !isset($_POST["nombre"])
    || !isset($_POST["apellido"])
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

$pk_driver = $_POST["pk_driver"];
$pk_driver_sql = (strlen($pk_driver) > 0)
    ? "conductor.fk_usuario = '$pk_driver'" : "TRUE";
$nombre = $_POST["nombre"];
$nombre_sql = (strlen($nombre) > 0)
    ? "usuario.nombre = '$nombre'" : "TRUE";
$apellido = $_POST["apellido"];
$apellido_sql = (strlen($apellido) > 0)
    ? "usuario.apellido = '$apellido'" : "TRUE";

$mi0->query("
    SELECT
        usuario.pk_usuario,
        usuario.nombre,
        usuario.apellido,
        usuario.telefono,
        usuario.correo,
        usuario_foto.imagen_ruta
    FROM
        usuario
    LEFT JOIN
        (usuario_foto, conductor)
    ON
        (usuario.pk_usuario = usuario_foto.fk_usuario AND conductor.fk_usuario = usuario.pk_usuario)
    WHERE conductor.fk_administrador = ? AND conductor.despedido = '0' AND $nombre_sql
        AND $apellido_sql AND $pk_driver_sql
    ORDER BY usuario.pk_usuario ASC
    LIMIT $offset, $double_limit",
    $admin_id
);
if ($mi0->result->num_rows === 0) {
    $mi0->end("rollback", -2, NULL);
}

$data = array(
    "drivers" => $mi0->result->fetch_all(MYSQLI_ASSOC)
);

$data["are_they_all"] = ($mi0->result->num_rows > $limit)
    ? FALSE : TRUE;

$count = 0;
while ($row = $mi0->result->fetch_assoc()) {
    if (++$count > $limit) {
        break;
    }
    array_push($data["drivers"], $row);
}

$mi0->end("commit", 0, $data);