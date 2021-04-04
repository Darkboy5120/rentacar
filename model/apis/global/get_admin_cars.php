<?php
require "../users/root.php";
require "../utils/token_validation.php";

$user_agent = strtolower($_SERVER['HTTP_USER_AGENT']);
$is_mobile = is_numeric(strpos($user_agent, "mobile"));

if (!$is_mobile && !isset($_POST["securitykey"])
    && $ci0->getCookie("securitykey") !== $ci0->getSecuritykey()
    ) {
    $mi0->abort(-1, NULL);
} else if (($is_mobile && !isset($_POST["admin"]))
    || !isset($_POST["offset"])
    || !isset($_POST["limit"])) {
    $mi0->abort(-2, NULL);
}

$mi0->begin();

$user_data = $ci0->getCookie("user_data");
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
$next_offset = $offset+$limit;

$mi0->query("
    SELECT
        auto.pk_auto,
        auto.fk_administrador,
        auto.fk_auto_modelo,
        auto.fk_auto_color_pintura,
        auto.precio,
        auto.tipo,
        auto.tipo_motor,
        auto.asientos,
        auto.puertas,
        auto.capacidad_cajuela,
        auto.seguro,
        auto.unidad_consumo,
        auto.caballos_fuerza,
        auto.capacidad_combustible,
        auto.transmicion,
        auto.repuesto,
        auto.caja_herramientas,
        auto.aire_acondicionado,
        auto.gps,
        auto.vidrios_polarizados,
        auto_imagen.imagen_ruta,
        auto_modelo.nombre as modelo_nombre
    FROM
        auto
    LEFT JOIN
        (auto_imagen, auto_modelo)
    ON
        (auto_imagen.fk_auto = auto.pk_auto AND auto_imagen.portada = '1'
            AND auto_modelo.pk_auto_modelo = auto.fk_auto_modelo)
    WHERE auto.fk_administrador = ?
    LIMIT $offset, $limit",
    $user_data["pk_usuario"]
);
if ($mi0->result->num_rows === 0) {
    $mi0->end("rollback", -3, NULL);
}

$data = array(
    "cars" => $mi0->result->fetch_all(MYSQLI_ASSOC)
);

$mi0->query("
    SELECT
        auto.pk_auto,
        auto.fk_administrador,
        auto.fk_auto_modelo,
        auto.fk_auto_color_pintura,
        auto.precio,
        auto.tipo,
        auto.tipo_motor,
        auto.asientos,
        auto.puertas,
        auto.capacidad_cajuela,
        auto.seguro,
        auto.unidad_consumo,
        auto.caballos_fuerza,
        auto.capacidad_combustible,
        auto.transmicion,
        auto.repuesto,
        auto.caja_herramientas,
        auto.aire_acondicionado,
        auto.gps,
        auto.vidrios_polarizados,
        auto_imagen.imagen_ruta,
        auto_modelo.nombre as modelo_nombre
    FROM
        auto
    LEFT JOIN
        (auto_imagen, auto_modelo)
    ON
        (auto_imagen.fk_auto = auto.pk_auto AND auto_imagen.portada = '1'
            AND auto_modelo.pk_auto_modelo = auto.fk_auto_modelo)
    WHERE auto.fk_administrador = ?
    LIMIT $next_offset, $limit",
    $user_data["pk_usuario"]
);
$data["are_they_all"] = ($mi0->result->num_rows > 0)
    ? FALSE : TRUE;

$mi0->end("commit", 0, $data);