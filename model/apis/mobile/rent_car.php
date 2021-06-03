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
$fechahora_entrega = $_REQUEST["fechahora_entrega"];
$fechahora_devolucion = $_REQUEST["fechahora_devolucion"];

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

//find available drivers
$mi0->query("
    SELECT
        conductor.fk_usuario
    FROM
        auto
    LEFT JOIN
        (administrador, conductor)
    ON
        (auto.fk_administrador = administrador.fk_usuario
        AND conductor.fk_administrador = administrador.fk_usuario)
    WHERE auto.pk_auto = ? AND conductor.fk_usuario IS NOT NULL
    GROUP BY conductor.fk_usuario
    LIMIT 1",
    $car_id
);
if ($mi0->result->num_rows == 0) {
    $mi0->end("rollback", -3, NULL);
}
$driver_id = $mi0->result->fetch_all(MYSQLI_ASSOC)[0]["fk_usuario"];

$mi0->query("
    INSERT INTO
        renta
    (fk_auto, fk_arrendatario, fk_conductor, punto_entrega_latitud, punto_entrega_longitud,
        punto_devolucion_latitud, punto_devolucion_longitud, fechahora_entrega,
        fechahora_devolucion, costo)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
    $car_id, $user_id, $driver_id, $punto_entrega_latitud, $punto_entrega_longitud,
    $punto_devolucion_latitud, $punto_devolucion_longitud, $fechahora_entrega,
    $fechahora_devolucion, $final_price
);
if ($mi0->result === TRUE) {
    $mi0->end("commit", 0, NULL);
} else {
    $mi0->end("rollback", -4, NULL);
}