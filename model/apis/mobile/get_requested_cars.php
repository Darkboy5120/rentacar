<?php
require "../users/root.php";
require "../utils/user_validation.php";

if (!isset($_REQUEST["user_id"])
    || !isset($_REQUEST["fase"])
    ) {
    $mi0->abort(-1, NULL);
}

$user_id = $_REQUEST["user_id"];
$fase = $_REQUEST["fase"];
$fase_sql = NULL;
switch ($fase) {
    case "0":
        $fase_sql = "('0', '1')";
        break;
    case "1":
        $fase_sql = "('2', '3')";
        break;
    case "2":
        $fase_sql = "('4')";
        break;
}

$mi0->begin();

$mi0->query("
    SELECT
        auto.pk_auto,
        auto.fk_administrador,
        auto_imagen.imagen_ruta,
        auto_modelo.nombre as modelo_nombre,
        auto_modelo.nombre as modelo_nombre,
        auto_marca.nombre as marca_nombre,
        renta.pk_renta,
        renta.costo,
        renta.fase,
        renta.fechahora_entrega,
        renta.fechahora_devolucion
    FROM
        auto
    LEFT JOIN
        (auto_imagen, auto_modelo, auto_marca, renta)
    ON
        (auto_imagen.fk_auto = auto.pk_auto AND auto_imagen.portada = '1'
            AND auto_modelo.pk_auto_modelo = auto.fk_auto_modelo
            AND auto_modelo.fk_auto_marca = auto_marca.pk_auto_marca
            AND auto.pk_auto = renta.fk_auto)
    WHERE renta.fk_arrendatario = ? AND renta.fase IN $fase_sql",
    $user_id
);
if ($mi0->result->num_rows > 0) {
    $data = array(
        "cars" => $mi0->result->fetch_all(MYSQLI_ASSOC)
    );
    $mi0->end("commit", 0, $data);
} else {
    $mi0->end("rollback", -2, NULL);
}