<?php
require "../users/root.php";
require "../utils/user_validation.php";

if ((!$from_web && !isset($_POST["admin"]))
    || !isset($_POST["offset"])
    || !isset($_POST["limit"])
    || !isset($_POST["marca"])
    || !isset($_POST["modelo"])
    || !isset($_POST["color_pintura"])
    ) {
    $mi0->abort(-2, NULL);
}

$admin_id = ($from_web) ? $ci0->getSession("user_data")["pk_usuario"] : $_POST["admin"];
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

$marca = $_POST["marca"];
$marca_sql = (strlen($marca) > 0)
    ? "auto_modelo.fk_auto_marca = $marca" : "TRUE";
$modelo = $_POST["modelo"];
$modelo_sql = (strlen($modelo) > 0)
    ? "auto.fk_auto_modelo = $modelo" : "TRUE";
$color_pintura = $_POST["color_pintura"];
$color_pintura_sql = (strlen($color_pintura) > 0)
    ? "auto.fk_auto_color_pintura = $color_pintura" : "TRUE";

$mi0->begin();

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
        auto_modelo.nombre as modelo_nombre,
        auto_modelo.fk_auto_marca
    FROM
        auto
    LEFT JOIN
        (auto_imagen, auto_modelo)
    ON
        (auto_imagen.fk_auto = auto.pk_auto AND auto_imagen.portada = '1'
            AND auto_modelo.pk_auto_modelo = auto.fk_auto_modelo)
    WHERE auto.fk_administrador = ? AND $marca_sql AND $modelo_sql AND $color_pintura_sql
    LIMIT $offset, $double_limit",
    $admin_id
);
if ($mi0->result->num_rows === 0) {
    $mi0->end("rollback", -3, NULL);
}

$data = array(
    "cars" => array()
);

$data["are_they_all"] = ($mi0->result->num_rows > $limit)
    ? FALSE : TRUE;

$count = 0;
while ($row = $mi0->result->fetch_assoc()) {
    if (++$count > $limit) {
        break;
    }
    array_push($data["cars"], $row);
}

$mi0->end("commit", 0, $data);