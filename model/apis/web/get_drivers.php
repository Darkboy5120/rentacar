<?php
require "../users/root.php";
require "../utils/user_validation.php";

if ($ci0->getSession("securitykey") !== $ci0->getSecuritykey()
    ) {
    $mi0->abort(-1, NULL);
} else if (!isset($_REQUEST["offset"])
    || !isset($_REQUEST["limit"])) {
    $mi0->abort(-2, NULL);
}

$mi0->begin();

$admin_id = $ci0->getSession("user_data")["pk_usuario"];
$offset = $_REQUEST["offset"];
if ($offset < 0) {
    $offset = 0;
}
$max_limit = 15;
$limit = $_REQUEST["limit"];
if ($limit > $max_limit) {
    $limit = $max_limit;
} else if ($limit <= 0) {
    $limit = 1;
}
$next_offset = $offset+$limit;

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
    WHERE conductor.fk_administrador = ? AND despedido = '0'
    ORDER BY usuario.pk_usuario ASC
    LIMIT $offset, $limit",
    $admin_id
);
if ($mi0->result->num_rows === 0) {
    $mi0->end("rollback", -3, NULL);
}

$data = array(
    "drivers" => $mi0->result->fetch_all(MYSQLI_ASSOC)
);

$mi0->query("
    SELECT
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
    WHERE conductor.fk_administrador = ? AND despedido = '0'
    LIMIT $next_offset, $limit",
    $admin_id
);
$data["are_they_all"] = ($mi0->result->num_rows > 0)
    ? FALSE : TRUE;

$mi0->end("commit", 0, $data);