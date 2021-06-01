<?php
require "../users/root.php";
require "../utils/user_validation.php";

if (!isset($_POST["securitykey"])
    && !$mi0->checkHash($ci0->getSecuritykey(), $_POST["securitykey"]) 
    ) {
    $mi0->abort(-1, NULL);
} else if (!isset($_POST["offset"])
    || !isset($_POST["limit"])
    || !isset($_POST["minprice"])
    || !isset($_POST["maxprice"])
    || !isset($_POST["startlocation_latitude"])
    || !isset($_POST["startlocation_longitude"])
    || !isset($_POST["startdatetime"])
    || !isset($_POST["endlocation_latitude"])
    || !isset($_POST["endlocation_longitude"])
    || !isset($_POST["enddatetime"])
    ) {
    $mi0->abort(-2, NULL);
}

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

$minprice = $_POST["minprice"];
$minprice_sql = (strlen($_POST["minprice"]) > 0) ? "auto.precio >= $minprice" : "TRUE";

$maxprice = $_POST["maxprice"];
$maxprice_sql = (strlen($_POST["maxprice"]) > 0) ? "auto.precio <= $maxprice" : "TRUE";

$slocation_la = $_POST["startlocation_latitude"];
$slocation_la_sql = "TRUE";

$slocation_lo = $_POST["startlocation_longitude"];
$slocation_lo_sql = "TRUE";

$startdatetime = $_POST["startdatetime"];

$elocation_la = $_POST["endlocation_latitude"];
$elocation_la_sql = "TRUE";

$elocation_lo = $_POST["endlocation_longitude"];
$elocation_lo_sql = "TRUE";

$enddatetime = $_POST["enddatetime"];

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
        auto_modelo.nombre as modelo_nombre,
        auto_marca.nombre as marca_nombre
    FROM
        auto
    LEFT JOIN
        (auto_imagen, auto_modelo, auto_marca)
    ON
        (auto_imagen.fk_auto = auto.pk_auto AND auto_imagen.portada = '1'
            AND auto_modelo.pk_auto_modelo = auto.fk_auto_modelo
            AND auto_modelo.fk_auto_marca = auto_marca.pk_auto_marca)
    WHERE TRUE AND $minprice_sql AND $maxprice_sql AND $slocation_la_sql AND $slocation_lo_sql
        AND $elocation_la_sql AND $elocation_lo_sql
        AND (
            SELECT
                fk_auto
            FROM
                renta
            WHERE fk_auto = auto.pk_auto AND ((fechahora_entrega <= ? AND fechahora_devolucion >= ?)
                OR (fechahora_entrega >= ? AND fechahora_devolucion <= ?)) AND renta.fase = '0'
        ) IS NULL
    LIMIT $offset, $limit",
    $startdatetime, $enddatetime, $startdatetime, $enddatetime
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
        auto_modelo.nombre as modelo_nombre,
        auto_modelo.nombre as modelo_nombre,
        auto_marca.nombre as marca_nombre
    FROM
        auto
    LEFT JOIN
        (auto_imagen, auto_modelo, auto_marca)
    ON
        (auto_imagen.fk_auto = auto.pk_auto AND auto_imagen.portada = '1'
            AND auto_modelo.pk_auto_modelo = auto.fk_auto_modelo
            AND auto_modelo.fk_auto_marca = auto_marca.pk_auto_marca)
    WHERE TRUE AND $minprice_sql AND $maxprice_sql AND $slocation_la_sql AND $slocation_lo_sql
        AND $elocation_la_sql AND $elocation_lo_sql
        AND (
            SELECT
                fk_auto
            FROM
                renta
            WHERE fk_auto = auto.pk_auto AND ((fechahora_entrega <= ? AND fechahora_devolucion >= ?)
                OR (fechahora_entrega >= ? AND fechahora_devolucion <= ?)) AND renta.fase = '0'
        ) IS NULL
    LIMIT $next_offset, $limit",
    $startdatetime, $enddatetime, $startdatetime, $enddatetime
);
$data["are_they_all"] = ($mi0->result->num_rows > 0)
    ? FALSE : TRUE;

$mi0->end("commit", 0, $data);