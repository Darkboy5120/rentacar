<?php
require "../users/root.php";
require "../utils/token_validation.php";

function dataIsAllRight () {
    global $mi0;
    if (!isset($_REQUEST["nombre"])
        || !isset($_REQUEST["apellido"])
        || !isset($_REQUEST["telefono"])
        || !isset($_REQUEST["correo"])
        || !isset($_REQUEST["contraseña"])
        || !isset($_REQUEST["fecha_nacimiento"])
        || !isset($_REQUEST["codigo_postal"])
        || !isset($_REQUEST["municipio"])
        || !isset($_REQUEST["direccion"])
        || !isset($_REQUEST["licencia_frontal_imagen_contenido"])
        || !isset($_REQUEST["licencia_frontal_imagen_tipo"])
        || !isset($_REQUEST["licencia_posterior_imagen_contenido"])
        || !isset($_REQUEST["licencia_posterior_imagen_tipo"])
    ) {
        return FALSE;
    }
    return TRUE;
}

if (!dataIsAllRight()) {
    $mi0->abort(-1, NULL);
}

$images_path = "../../media/images/user_images/";

$nombre = $_REQUEST["nombre"];
$apellido = $_REQUEST["apellido"];
$telefono = $_REQUEST["telefono"];
$correo = $_REQUEST["correo"];
$contraseña = $mi0->hashString($_REQUEST["contraseña"]);
$fecha_nacimiento = $_REQUEST["fecha_nacimiento"];
$codigo_postal = $_REQUEST["codigo_postal"];
$fk_municipio = $_REQUEST["municipio"];
$direccion = $_REQUEST["direccion"];
$licencia_frontal_imagen_ruta = $images_path . $mi0->getRandString(10) . $_REQUEST["licencia_frontal_imagen_tipo"];
$licencia_frontal_imagen_contenido = $_REQUEST["licencia_frontal_imagen_contenido"];
$licencia_posterior_imagen_ruta = $images_path . $mi0->getRandString(10) . $_REQUEST["licencia_posterior_imagen_tipo"];
$licencia_posterior_imagen_contenido = $_REQUEST["licencia_posterior_imagen_contenido"];

$mi0->begin();

while (TRUE) {
    $new_hash = $mi0->getRandHash(10);
    $mi0->query("
        INSERT INTO usuario
            (token, nombre, apellido, telefono, correo, contraseña)
        VALUES
            (?, ?, ?, ?, ?, ?)",
            $new_hash, $nombre, $apellido, $telefono, $correo, $contraseña
    );
    if ($mi0->result === FALSE) {
        if ($mi0->getErrorName() === "DUPLICATE_KEY") {
            $duplicate_key = explode("'", $mi0->log)[3];
            if ($duplicate_key === "correo") {
                $mi0->end("rollback", -2, NULL);
            }
        }
        $mi0->end("rollback", -3, NULL);
    } else {
        break;
    }
}
$last_user_id = $mi0->link->insert_id;

$mi0->query("
    INSERT INTO arrendatario
        (fk_usuario, fecha_nacimiento, codigo_postal, fk_municipio, direccion, 
            licencia_frontal_imagen_ruta, licencia_posterior_imagen_ruta)
    VALUES
        (?, ?, ?, ?, ?, ?, ?)",
        $last_user_id, $fecha_nacimiento, $codigo_postal, $fk_municipio, $direccion, 
            $licencia_frontal_imagen_ruta, $licencia_posterior_imagen_ruta
);
if ($mi0->result === FALSE) {
    $mi0->end("rollback", -4, NULL);
}

if (file_put_contents($licencia_frontal_imagen_ruta, base64_decode($licencia_frontal_imagen_contenido))
    && file_put_contents($licencia_posterior_imagen_ruta, base64_decode($licencia_posterior_imagen_contenido))
    ) {
    $mi0->end('commit', 0, $last_user_id);
} else {
    $mi0->end('rollback', -5, NULL);
}