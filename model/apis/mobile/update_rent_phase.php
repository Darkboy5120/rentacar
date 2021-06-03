<?php
require "../users/root.php";
require "../utils/user_validation.php";

if (!isset($_REQUEST["pk_renta"])
    || !isset($_REQUEST["fk_arrendatario"])) {
    $mi0->abort(-1, NULL);
}

$pk_renta = $_REQUEST["pk_renta"];
$fk_arrendatario = $_REQUEST["fk_arrendatario"];

$mi0->begin();

$mi0->query("
    SELECT
        fase
    FROM
        renta
    WHERE pk_renta = ? AND fk_arrendatario = ?",
    $pk_renta, $fk_arrendatario
);
if ($mi0->result->num_rows != 1) {
    $mi0->end("rollback", -2, NULL);
}

$fase = $mi0->result->fetch_all(MYSQLI_ASSOC)[0]["fase"];

if ($fase == "0" || $fase == "2" || $fase == "4") {
    $mi0->end("rollback", -3, NULL);
}

$fase = $intval($fase) + 1;

$mi0->query("
    UPDATE
        renta
    SET
        fase = ?
    WHERE pk_renta = ?",
    $fase, $pk_renta
);
if ($mi0->result !== TRUE) {
    $mi0->end("rollback", -4, NULL);
}
$mi0->end("commit", 0, NULL);
