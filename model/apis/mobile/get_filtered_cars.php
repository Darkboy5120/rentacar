<?php
require "../users/root.php";
require "../utils/user_validation.php";

if (!isset($_POST["securitykey"])
    && !$mi0->checkHash($ci0->getSecuritykey(), $_POST["securitykey"]) 
    ) {
    $mi0->abort(-1, NULL);
} else if (!isset($_REQUEST["offset"])
    || !isset($_REQUEST["limit"])
    || !isset($_REQUEST["minprice"])
    || !isset($_REQUEST["maxprice"])
    || !isset($_REQUEST["startlocation_latitude"])
    || !isset($_REQUEST["startlocation_longitude"])
    || !isset($_REQUEST["startdate"])
    || !isset($_REQUEST["starttime"])
    || !isset($_REQUEST["endlocation_latitude"])
    || !isset($_REQUEST["endlocation_longitude"])
    || !isset($_REQUEST["enddate"])
    || !isset($_REQUEST["endtime"])
    ) {
    $mi0->abort(-2, NULL);
}

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

$minprice = $_POST["minprice"];
$minprice_sql = (strlen($_POST["minprice"]) > 0) ? "auto.precio >= $minprice" : "TRUE";

$maxprice = $_POST["maxprice"];
$maxprice_sql = (strlen($_POST["maxprice"]) > 0) ? "auto.precio <= $maxprice" : "TRUE";

$slocation_la = $_POST["startlocation_latitude"];
$slocation_la_sql = "TRUE";

$slocation_lo = $_POST["startlocation_longitude"];
$slocation_lo_sql = "TRUE";

$startdate = $_POST["startdate"];
$startdate_sql = "TRUE";

$starttime = $_POST["starttime"];
$starttime_sql = "TRUE";

$elocation_la = $_POST["endlocation_latitude"];
$elocation_la_sql = "TRUE";

$elocation_lo = $_POST["endlocation_longitude"];
$elocation_lo_sql = "TRUE";

$enddate = $_POST["enddate"];
$enddate_sql = "TRUE";

$endtime = $_POST["endtime"];
$endtime_sql = "TRUE";

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
        auto_modelo.nombre as modelo_nombre
    FROM
        auto
    LEFT JOIN
        (auto_imagen, auto_modelo)
    ON
        (auto_imagen.fk_auto = auto.pk_auto AND auto_imagen.portada = '1'
            AND auto_modelo.pk_auto_modelo = auto.fk_auto_modelo)
    WHERE TRUE && $minprice_sql AND $maxprice_sql AND $slocation_la_sql && $slocation_lo_sql AND
        $startdate_sql AND $starttime_sql AND $elocation_la_sql AND $elocation_lo_sql AND 
        $enddate_sql && $endtime_sql
    LIMIT $offset, $limit"
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
    WHERE TRUE && $minprice_sql AND $maxprice_sql AND $slocation_la_sql && $slocation_lo_sql AND
        $startdate_sql AND $starttime_sql AND $elocation_la_sql AND $elocation_lo_sql AND 
        $enddate_sql && $endtime_sql
    LIMIT $next_offset, $limit"
);
$data["are_they_all"] = ($mi0->result->num_rows > 0)
    ? FALSE : TRUE;

$mi0->end("commit", 0, $data);