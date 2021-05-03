<?php
require "../users/root.php";
require "../utils/token_validation.php";

$from_web = isset($_REQUEST["securitykey"]);

if ($from_web
    && $ci0->getSession("securitykey") !== $ci0->getSecuritykey()
    ) {
    $mi0->abort(-1, NULL);
} else if (!isset($_REQUEST["car"])
    ) {
    $mi0->abort(-2, NULL);
}

$mi0->begin();

$car_id = $_REQUEST["car"];

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
        auto_modelo.pk_auto_modelo,
        auto_marca.pk_auto_marca,
        auto.fk_auto_color_pintura
    FROM
        auto
    LEFT JOIN
        (auto_imagen, auto_modelo, auto_marca)
    ON
        (auto_imagen.fk_auto = auto.pk_auto AND auto_imagen.portada = '1'
            AND auto_modelo.pk_auto_modelo = auto.fk_auto_modelo
            AND auto_modelo.fk_auto_marca = auto_marca.pk_auto_marca)
    WHERE auto.pk_auto = ?",
    $car_id
);
if ($mi0->result->num_rows === 0) {
    $mi0->end("rollback", -3, NULL);
}

$data = $mi0->result->fetch_all(MYSQLI_ASSOC)[0];

$mi0->query("
    SELECT
        imagen_ruta
    FROM
        auto_imagen
    WHERE fk_auto = ? AND portada = '0'",
    $car_id
);
if ($mi0->result->num_rows > 0) {
    /*$others_images = array();
    while ($image = $mi0->result->fetch_assoc()) {
        array_push($others_images, array(
            "imagen_ruta" => $image["imagen_ruta"],
            "imagen" => base64_encode(file_get_contents($image["imagen_ruta"]))
        ));
    }
    $data["otras_imagenes"] = $others_images;*/
    $data["otras_imagenes"] = $mi0->result->fetch_all(MYSQLI_ASSOC);
    $mi0->end("commit", 0, $data);
} else {
    $mi0->end("rollback", -4, NULL);
}