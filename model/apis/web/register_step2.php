<?php
require "../users/root.php";

if ($ci0->getSession("securitykey") !== $ci0->getSecuritykey()) {
    $mi0->abort(-1, NULL);
} else if (!isset($_POST["nombre"])
    || !isset($_POST["apellido"])
    || !isset($_POST["telefono"])
    || !isset($_POST["correo"])
    || !isset($_POST["contraseña"])
    || !isset($_POST["nombre_empresa"])
    ) {
    $mi0->abort(-2, NULL);
}

$nombre = $_POST["nombre"];
$apellido = $_POST["apellido"];
$telefono = $_POST["telefono"];
$correo = $_POST["correo"];
$contraseña = $mi0->hashString($_POST["contraseña"]);
$nombre_empresa = $_POST["nombre_empresa"];
$tipo = "0";

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
            }
        }
        $mi0->end("rollback", -4, NULL);
    } else {
        break;
    }
}
$last_user_id = $mi0->link->insert_id;

$mi0->query("
    INSERT INTO administrador
        (fk_usuario, nombre_empresa)
    VALUES
        (?, ?)",
        $last_user_id, $nombre_empresa
);
if ($mi0->result === TRUE) {
    $mi0->query("
        SELECT
            nombre
        FROM
            usuario
        WHERE pk_usuario = ?",
        $last_user_id
    );
    if ($mi0->result->num_rows > 0) {
        $user_data = $mi0->result->fetch_all(MYSQLI_ASSOC)[0];
        $ci0->setSession("user_data", array(
            "pk_usuario" => $last_user_id,
            "nombre" => $user_data["nombre"]
        ));
        $mi0->end("commit", 0, NULL);
    }
    $mi0->end("rollback", -5, NULL);
} else {
    if ($mi0->getErrorName() === "DUPLICATE_KEY") {
        $duplicate_key = explode("'", $mi0->log)[3];
        switch ($duplicate_key) {
            case "nombre_empresa": $mi0->end("rollback", -6, NULL);break;
        }
    }
    $mi0->end("rollback", -7, NULL);
}