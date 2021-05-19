<?php
require "../users/root.php";
require "../utils/user_validation.php";

function dataIsAllRight () {
    global $mi0;
    if (!isset($_POST["nombre"])
        || !isset($_POST["apellido"])
        || !isset($_POST["telefono"])
        || !isset($_POST["correo"])
        || !isset($_POST["contraseña"])
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
$nombre = $_POST["nombre"];
$apellido = $_POST["apellido"];
$telefono = $_POST["telefono"];
$correo = $_POST["correo"];
$contraseña = $mi0->hashString($_POST["contraseña"]);
$tipo = "2";

$mi0->begin();

while (TRUE) {
    $new_hash = $mi0->getRandHash(10);
    $mi0->query("
        INSERT INTO usuario
            (token, nombre, apellido, telefono, correo, contraseña, tipo)
        VALUES
            (?, ?, ?, ?, ?, ?, ?)",
            $new_hash, $nombre, $apellido, $telefono, $correo, $contraseña, $tipo
    );
    if ($mi0->result === FALSE) {
        if ($mi0->getErrorName() === "DUPLICATE_KEY") {
            $duplicate_key = explode("'", $mi0->log)[3];
            switch ($duplicate_key) {
                case "correo": $mi0->end("rollback", -3, NULL);break;
                case "telefono": $mi0->end("rollback", -4, NULL);break;
            }
        }
        $mi0->end("rollback", -5, NULL);
    } else {
        break;
    }
}
$last_user_id = $mi0->link->insert_id;

$mi0->query("
    INSERT INTO conductor
        (fk_usuario, fk_administrador)
    VALUES
        (?, ?)",
    $last_user_id, $user_data["pk_usuario"]
);
if ($mi0->result === FALSE) {
    $mi0->end("rollback", -6, NULL);
}

$images_path = "../../media/images/user_images/";
$last_car_id = $mi0->link->insert_id;
foreach ($_FILES as $name => $file) {
    while (TRUE) {
        $new_image_path = $images_path . $mi0->getRandString(10) . "." . substr($file["type"], 6);
        $mi0->query("
            INSERT INTO usuario_foto
                (fk_usuario, imagen_ruta)
            VALUES
                (?, ?)",
            $last_user_id, $new_image_path
        );
        if ($mi0->result === FALSE) {
            if ($mi0->getErrorName() === "DUPLICATE_KEY") {
                continue;
            }
            $mi0->end("rollback", -7, NULL);
        }
        break;
    }
    if (!move_uploaded_file($file["tmp_name"], $new_image_path)) {
        $mi0->end("rollback", -8, NULL);
    }
}
$mi0->end("commit", 0, NULL);