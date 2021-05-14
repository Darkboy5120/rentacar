<?php
require "../users/root.php";
require "../utils/token_validation.php";

function dataIsAllRight () {
    global $mi0;
    $tinyint_opt = array("regex" => "/[^0-9]+/", "min" => 1, "max" => 3);
    $smallint_opt = array("regex" => "/[^0-9]+/", "min" => 1, "max" => 5);
    $onedigit_opt = array("regex" => "/[^0-9]+/", "min" => 1, "max" => 1);
    if (!isset($_POST["car"])
        || $mi0->analyze($_POST["modelo"], $smallint_opt)
        || $mi0->analyze($_POST["precio"], $smallint_opt)
        || $mi0->analyze($_POST["puertas"], $onedigit_opt)
        || $mi0->analyze($_POST["asientos"], $onedigit_opt)
        || $mi0->analyze($_POST["unidad_consumo"], $tinyint_opt)
        || $mi0->analyze($_POST["caballos_fuerza"], $tinyint_opt)
        || $mi0->analyze($_POST["capacidad_combustible"], $tinyint_opt)
        || $mi0->analyze($_POST["aire_acondicionado"], $onedigit_opt)
        || $mi0->analyze($_POST["gps"], $onedigit_opt)
        || $mi0->analyze($_POST["vidrios_polarizados"], $onedigit_opt)
        || $mi0->analyze($_POST["repuesto"], $onedigit_opt)
        || $mi0->analyze($_POST["caja_herramientas"], $onedigit_opt)
        || $mi0->analyze($_POST["tipo"], $onedigit_opt)
        || $mi0->analyze($_POST["color_pintura"], $tinyint_opt)
        || $mi0->analyze($_POST["capacidad_cajuela"], $onedigit_opt)
        || $mi0->analyze($_POST["transmicion"], $onedigit_opt)
        || $mi0->analyze($_POST["seguro"], $onedigit_opt)
        || $mi0->analyze($_POST["tipo_motor"], $onedigit_opt)
        || !isset($_POST["same_files"])
    ) {
        return FALSE;
    }
    foreach ($_FILES as $name => $file) {
        if (preg_match("/image.*/", $file["type"]) === 0) {
            return FALSE;
        }
    }
    return TRUE;
}

if ($ci0->getSession("securitykey") !== $ci0->getSecuritykey()
    ) {
    $mi0->abort(-1, NULL);
} else if (!dataIsAllRight()) {
    $mi0->abort(-2, NULL);
}

$user_data = $ci0->getSession("user_data");
$car_id = $_POST["car"];
$modelo = $_POST["modelo"];
$precio = $_POST["precio"];
$puertas = $_POST["puertas"];
$asientos = $_POST["asientos"];
$unidad_consumo = $_POST["unidad_consumo"];
$caballos_fuerza = $_POST["caballos_fuerza"];
$capacidad_combustible = $_POST["capacidad_combustible"];
$aire_acondicionado = $_POST["aire_acondicionado"];
$gps = $_POST["gps"];
$vidrios_polarizados = $_POST["vidrios_polarizados"];
$repuesto = $_POST["repuesto"];
$caja_herramientas = $_POST["caja_herramientas"];
$tipo = $_POST["tipo"];
$color_pintura = $_POST["color_pintura"];
$capacidad_cajuela = $_POST["capacidad_cajuela"];
$transmicion = $_POST["transmicion"];
$seguro = $_POST["seguro"];
$tipo_motor = $_POST["tipo_motor"];
$same_files = $_POST["same_files"];

$mi0->begin();

$mi0->query("
    SELECT
        pk_auto
    FROM
        auto
    WHERE pk_auto = ? AND fk_administrador = ?",
    $car_id, $user_data["pk_usuario"]
);
if ($mi0->result->num_rows === 0) {
    $mi0->end("rollback", -3, NULL);
}

$mi0->query("
    UPDATE auto
    SET
        fk_administrador = ?, fk_auto_modelo = ?, precio = ?, puertas = ?, asientos = ?, unidad_consumo = ?,
            caballos_fuerza = ?, capacidad_combustible = ?, aire_acondicionado = ?, gps = ?,
            vidrios_polarizados = ?, repuesto = ?, caja_herramientas = ?, tipo = ?,
            fk_auto_color_pintura = ?, capacidad_cajuela = ?, transmicion = ?, seguro = ?, tipo_motor = ?
        WHERE pk_auto = ?",
    $user_data["pk_usuario"], $modelo, $precio, $puertas, $asientos, $unidad_consumo, $caballos_fuerza, $capacidad_combustible,
        $aire_acondicionado, $gps, $vidrios_polarizados, $repuesto, $caja_herramientas,
        $tipo, $color_pintura, $capacidad_cajuela, $transmicion, $seguro, $tipo_motor, $car_id
);
if ($mi0->result === FALSE) {
    $mi0->end("rollback", -4, NULL);
}

if ($same_files === "1") {
    $mi0->end("commit", 0, $same_files);
}

$mi0->query("
    SELECT
        imagen_ruta
    FROM
        auto_imagen
    WHERE fk_auto = ?",
    $car_id
);
if ($mi0->result->num_rows === 0) {
    $mi0->end("rollback", -4, NULL);
}
while ($image = $mi0->result->fetch_assoc()) {
    unlink($image["imagen_ruta"]);
}

$mi0->query("
    DELETE FROM auto_imagen
    WHERE fk_auto = ?",
    $car_id
);
if ($mi0->result === FALSE) {
    $mi0->end("rollback", -5, NULL);
}

$images_path = "../../media/images/car_images/";
foreach ($_FILES as $name => $file) {
    while (TRUE) {
        $is_thumbnail = ($file["tmp_name"] === $_FILES["auto_imagen_portada"]["tmp_name"])
            ? "1" : "0";
        $new_image_path = $images_path . $mi0->getRandString(10) . "." . substr($file["type"], 6);
        $mi0->query("
            INSERT INTO auto_imagen
                (fk_auto, portada, imagen_ruta)
            VALUES
                (?, ?, ?)",
            $car_id, $is_thumbnail, $new_image_path
        );
        if ($mi0->result === FALSE) {
            if ($mi0->getErrorName() === "DUPLICATE_KEY") {
                continue;
            }
            $mi0->end("rollback", -6, NULL);
        }
        break;
    }
    if (!move_uploaded_file($file["tmp_name"], $new_image_path)) {
        $mi0->end("rollback", -7, NULL);
    }
}
$mi0->end("commit", 0, NULL);