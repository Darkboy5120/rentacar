<?php
require "../users/root.php";
require "../utils/user_validation.php";

if (!isset($_REQUEST["user_id"])
    || !isset($_REQUEST["car_id"])
    || !isset($_REQUEST["final_price"])
    || !isset($_REQUEST["punto_entrega_latitud"])
    || !isset($_REQUEST["punto_entrega_longitud"])
    || !isset($_REQUEST["punto_devolucion_latitud"])
    || !isset($_REQUEST["punto_devolucion_longitud"])
    || !isset($_REQUEST["fechahora_entrega"])
    || !isset($_REQUEST["fechahora_devolucion"])
    ) {
    $mi0->abort(-1, NULL);
}

$user_id = $_REQUEST["user_id"];
$car_id = $_REQUEST["car_id"];
$final_price = $_REQUEST["final_price"];
$punto_entrega_latitud = $_REQUEST["punto_entrega_latitud"];
$punto_entrega_longitud = $_REQUEST["punto_entrega_longitud"];
$punto_devolucion_latitud = $_REQUEST["punto_devolucion_latitud"];
$punto_devolucion_longitud = $_REQUEST["punto_devolucion_longitud"];
$fechahora_entrega = str_replace("/", "-", $_REQUEST["fechahora_entrega"]);
$fechahora_devolucion = str_replace("/", "-", $_REQUEST["fechahora_devolucion"]);

$mi0->begin();

$mi0->query("
    SELECT
        pk_renta
    FROM
        renta
    WHERE fk_auto = ? AND ((fechahora_entrega <= ? AND fechahora_devolucion >= ?)
        OR (fechahora_entrega >= ? AND fechahora_devolucion <= ?))",
    $car_id, $fechahora_entrega, $fechahora_devolucion, $fechahora_entrega, $fechahora_devolucion
);
if ($mi0->result->num_rows > 0) {
    $mi0->end("rollback", -2, NULL);
}

$mi0->query("
    INSERT INTO
        renta
    (fk_auto, fk_conductor, punto_entrega_latitud, punto_entrega_longitud,
        punto_devolucion_latitud, punto_devolucion_longitud, fechahora_entrega,
        fechahora_devolucion, costo)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)",
    $car_id, $user_id, $punto_entrega_latitud, $punto_entrega_longitud,
    $punto_devolucion_latitud, $punto_devolucion_longitud, $fechahora_entrega,
    $fechahora_devolucion, $final_price
);
if ($mi0->result === TRUE) {
    $mi0->end("commit", 0, NULL);
} else {
    $mi0->end("rollback", -3, NULL);
}