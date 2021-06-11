<?php
require "../users/root.php";
require "../utils/user_validation.php";

if (!isset($_REQUEST["fk_auto"])
    || !isset($_REQUEST["fk_arrendatario"])
    || !isset($_REQUEST["puntuacion"])
    || !isset($_REQUEST["comentarios"])
    ) {
    $mi0->abort(-1, NULL);
}

$fk_auto = $_REQUEST["fk_auto"];
$fk_arrendatario = $_REQUEST["fk_arrendatario"];
$puntuacion = $_REQUEST["puntuacion"];
$comentarios = $_REQUEST["comentarios"];

$mi0->begin();

$mi0->query("
    SELECT
        (fk_auto)
    FROM
        auto_puntuacion
    WHERE fk_auto = ? AND fk_arrendatario = ?",
    $fk_auto, $fk_arrendatario
);
if ($mi0->result->num_rows === 1) {

    $mi0->query("
        UPDATE
            auto_puntuacion    
        SET
            puntuacion = ?, comentarios = ?
        WHERE fk_auto = ? AND fk_arrendatario = ?",
        $puntuacion, $comentarios, $fk_auto, $fk_arrendatario
    );
    if ($mi0->result === TRUE) {
        $mi0->end("commit", 0, NULL);
    } else {
        $mi0->end("rollback", -3, NULL);
    }

}

$mi0->query("
    INSERT INTO auto_puntuacion
        (fk_auto, fk_arrendatario, puntuacion, comentarios)
        VALUES (?, ?, ?, ?)",
    $fk_auto, $fk_arrendatario, $puntuacion, $comentarios
);
if ($mi0->result === TRUE) {
    $mi0->end("commit", 0, NULL);
} else {
    $mi0->end("rollback", -2, NULL);
}
