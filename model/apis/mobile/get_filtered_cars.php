<?php
require "../users/root.php";
require "../utils/user_validation.php";

if (!isset($_REQUEST["securitykey"])
    && !$mi0->checkHash($ci0->getSecuritykey(), $_REQUEST["securitykey"]) 
    ) {
    $mi0->abort(-1, NULL);
} else if (!isset($_REQUEST["offset"])
    || !isset($_REQUEST["limit"])
    || !isset($_REQUEST["minprice"])
    || !isset($_REQUEST["maxprice"])
    || !isset($_REQUEST["startlocation_latitude"])
    || !isset($_REQUEST["startlocation_longitude"])
    || !isset($_REQUEST["startdatetime"])
    || !isset($_REQUEST["endlocation_latitude"])
    || !isset($_REQUEST["endlocation_longitude"])
    || !isset($_REQUEST["enddatetime"])
    ) {
    $mi0->abort(-2, NULL);
}

$MAX_DISTANCE_TORELANCE = .2;

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
$double_limit = $limit * 2;

$minprice = $_REQUEST["minprice"];
$minprice_sql = (strlen($_REQUEST["minprice"]) > 0) ? "auto.precio >= $minprice" : "TRUE";

$maxprice = $_REQUEST["maxprice"];
$maxprice_sql = (strlen($_REQUEST["maxprice"]) > 0) ? "auto.precio <= $maxprice" : "TRUE";

$slocation_la = $_REQUEST["startlocation_latitude"];
$slocation_la_sql = "TRUE";

$slocation_lo = $_REQUEST["startlocation_longitude"];
$slocation_lo_sql = "TRUE";

$startdatetime = $_REQUEST["startdatetime"];

$elocation_la = $_REQUEST["endlocation_latitude"];
$elocation_la_sql = "TRUE";

$elocation_lo = $_REQUEST["endlocation_longitude"];
$elocation_lo_sql = "TRUE";

$enddatetime = $_REQUEST["enddatetime"];

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
        auto_marca.nombre as marca_nombre,
        administrador.longitud_empresa,
        administrador.latitud_empresa
    FROM
        auto
    LEFT JOIN
        (auto_imagen, auto_modelo, auto_marca, administrador)
    ON
        (auto_imagen.fk_auto = auto.pk_auto AND auto_imagen.portada = '1'
            AND auto_modelo.pk_auto_modelo = auto.fk_auto_modelo
            AND auto_modelo.fk_auto_marca = auto_marca.pk_auto_marca
            AND administrador.fk_usuario = auto.fk_administrador)
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
    LIMIT $offset, $double_limit",
    $startdatetime, $enddatetime, $startdatetime, $enddatetime
);
if ($mi0->result->num_rows === 0) {
    $mi0->end("rollback", -3, NULL);
}

$data = array(
    "cars" => array()
);

$data["are_they_all"] = ($mi0->result->num_rows > $limit)
    ? FALSE : TRUE;

function get_linear_points_distance($a_x, $a_y, $b_x, $b_y) {
    $distance = 0;
    $smaller = NULL;
    $bigger = NULL;
    $c_1 = NULL;
    $c_2 = NULL;
    $axis = ($a_x == $b_x) ? "y" : "x";

    if ($axis == "y") {
        $c_1 = $a_y;
        $c_2 = $b_y;
    } else {
        $c_1 = $a_x;
        $c_2 = $b_x;
    }

    if ($c_1 == $c_2) {
        return $distance;
    } else if ($c_1 > $c_2) {
        $bigger = $c_1;
        $smaller = $c_2;
    } else {
        $bigger = $c_2;
        $smaller = $c_1;
    }

    for ($i = $smaller; $i < $bigger; $i++) {
        if (($i + 1) > $bigger) {
            $distance += ($bigger - $i);
        } else {
            $distance++;
        }
        break;
    }

    return $distance;
}

function get_complex_points_distance($a_x, $a_y, $b_x, $b_y) {
    $c_x = $a_x;
    $c_y = $b_y;

    $ac = get_linear_points_distance($a_x, $a_y, $c_x, $c_y);
    $bc = get_linear_points_distance($b_x, $b_y, $c_x, $c_y);

    $distance = sqrt(($ac**2) + ($bc**2));
    return $distance;
}

$count = 0;
while ($row = $mi0->result->fetch_assoc()) {
    if (++$count > $limit) {
        break;
    }
    $current_distance = get_complex_points_distance(doubleval($slocation_lo), doubleval($slocation_la), 
    doubleval($row["longitud_empresa"]), doubleval($row["latitud_empresa"]));
    if ($current_distance < $MAX_DISTANCE_TORELANCE) {
        array_push($data["cars"], $row);
    }
}

if (count($data["cars"]) === 0) {
    $mi0->end("rollback", -4, NULL);
}

$mi0->end("commit", 0, $data);