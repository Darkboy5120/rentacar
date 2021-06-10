<?php
require "../users/root.php";
require "../utils/user_validation.php";

function dataIsAllRight () {
    if (!isset($_REQUEST["fk_renta"])
        || !isset($_REQUEST["todo_bien"])
        || !isset($_REQUEST["descripcion"])
    ) {
        return FALSE;
    }

    //files dont have empty type att when come from mobile, this needs to be fixed
    
    return TRUE;
}

if (!dataIsAllRight()) {
    $mi0->abort(-1, NULL);
}

$images_path = "../../media/images/report_images/";
$images_type = ".jpg";

$fk_renta = $_REQUEST["fk_renta"];
$todo_bien = $_REQUEST["todo_bien"];
$descripcion = $_REQUEST["descripcion"];

$mi0->begin();

$mi0->query("
    INSERT INTO reporte_devolucion
        (fk_renta, todo_bien, descripcion)
    VALUES
        (?, ?, ?)",
        $fk_renta, $todo_bien, $descripcion
);
if ($mi0->result !== TRUE) {
    $mi0->end("rollback", -2, NULL);
}
$last_report_id = $mi0->link->insert_id;

$mi0->query("
    SELECT
        auto.fk_administrador
    FROM
        renta
    LEFT JOIN
        (auto)
    ON
        (renta.fk_auto = auto.pk_auto)
    WHERE renta.pk_renta = ?",
    $fk_renta
);
if ($mi0->result->num_rows != 1) {
    $mi0->end("rollback", -6, NULL);
}

$fk_administrador = $mi0->result->fetch_all(MYSQLI_ASSOC)[0]["fk_administrador"];

$mi0->query("
    INSERT INTO notificacion
        (fk_usuario)
    VALUES
        (?)",
    $fk_administrador
);
if ($mi0->result !== TRUE) {
    $mi0->end("rollback", -7, NULL);
}
$last_notification_id = $mi0->link->insert_id;

$mi0->query("
    INSERT INTO notificacion_reporte
        (fk_notificacion, fk_reporte_devolucion)
    VALUES
        (?, ?)",
    $last_notification_id, $last_report_id
);
if ($mi0->result !== TRUE) {
    $mi0->end("rollback", -8, NULL);
}

if ($todo_bien == "0") {
    $mi0->end("commit", 0, NULL);
}

$there_are_file = false;

foreach ($_FILES as $name => $file) {
    $there_are_file = true;

    $imagen_ruta = $images_path . $mi0->getRandString(10) . $images_type;
    
    $mi0->query("
        INSERT INTO reporte_devolucion_imagen
            (fk_reporte_devolucion, fk_penalizacion, imagen_ruta)
        VALUES
            (?, ?, ?)",
            $last_report_id, $file["name"], $imagen_ruta
    );
    if ($mi0->result === FALSE) {
        $mi0->end("rollback", -3, NULL);
    }

    if (!move_uploaded_file($file["tmp_name"], $imagen_ruta)
        ) {
        $mi0->end('rollback', -4, NULL);
    }
}

if ($there_are_file) {
    $mi0->end('commit', 0, NULL);
} else {
    $mi0->end('rollback', -5, NULL);
}
