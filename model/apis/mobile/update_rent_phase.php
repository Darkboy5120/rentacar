<?php
require "../users/root.php";
require "../utils/user_validation.php";

if (!isset($_REQUEST["pk_renta"])
    || !isset($_REQUEST["user_id"])) {
    $mi0->abort(-1, NULL);
}

$pk_renta = $_REQUEST["pk_renta"];
$user_id = $_REQUEST["user_id"];
$user_id_sql = null;

$mi0->begin();

$mi0->query("
    SELECT
        tipo
    FROM
        usuario
    WHERE pk_usuario = ?",
    $user_id
);
if ($mi0->result->num_rows != 1) {
    $mi0->end("rollback", -2, NULL);
}

$user_type = $mi0->result->fetch_all(MYSQLI_ASSOC)[0]["tipo"];
$user_id_sql = ($user_type == "1") ? "renta.fk_arrendatario"
    : "renta.fk_conductor";

$mi0->query("
    SELECT
        fase
    FROM
        renta
    WHERE pk_renta = ? AND $user_id_sql = ?",
    $pk_renta, $user_id
);
if ($mi0->result->num_rows != 1) {
    $mi0->end("rollback", -3, NULL);
}

$fase = $mi0->result->fetch_all(MYSQLI_ASSOC)[0]["fase"];

if (($fase == "0" || $fase == "2" || $fase == "4") && $user_type == "1"
    || ($fase == "1" || $fase == "3") && $user_type == "2"
    ) {
    $mi0->end("rollback", -4, NULL);
}

$fase = intval($fase) + 1;

$mi0->query("
    UPDATE
        renta
    SET
        fase = ?
    WHERE pk_renta = ?",
    $fase, $pk_renta
);
if ($mi0->result !== TRUE) {
    $mi0->end("rollback", -5, NULL);
}
$mi0->end("commit", 0, NULL);
