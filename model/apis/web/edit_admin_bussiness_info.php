<?php
require "../users/root.php";
require "../utils/token_validation.php";

if ($ci0->getSession("securitykey") !== $ci0->getSecuritykey()
    ) {
    $mi0->abort(-1, NULL);
} else if (!isset($_POST["name"])
    || !isset($_POST["phone"])
    ) {
    $mi0->abort(-2, NULL);
}

$admin_id = $ci0->getSession("user_data")["pk_usuario"];
$nombre_empresa = $_POST["name"];
$telefono = $_POST["phone"];

$mi0->begin();

$mi0->query("
    UPDATE
        usuario
    SET
        telefono = ?
    WHERE pk_usuario = ?",
    $telefono, $admin_id
);
if ($mi0->result === FALSE) {
    $duplicate_key = explode("'", $mi0->log)[3];
    switch ($duplicate_key) {
        case "telefono": $mi0->end("rollback", -3, NULL);break;
    }
    $mi0->end("rollback", -4, NULL);
}

$mi0->query("
    UPDATE
        administrador
    SET
        nombre_empresa = ?
    WHERE fk_usuario = ?",
    $nombre_empresa, $admin_id
);
if ($mi0->result === TRUE) {
    $mi0->end("commit", 0, NULL);
} else {
    if ($mi0->getErrorName() === "DUPLICATE_KEY") {
        $duplicate_key = explode("'", $mi0->log)[3];
        switch ($duplicate_key) {
            case "nombre_empresa": $mi0->end("rollback", -5, NULL);break;
        }
    }
    $mi0->end("rollback", -6, NULL);
}