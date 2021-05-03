<?php
require "../users/root.php";
require "../utils/token_validation.php";

$from_web = isset($_REQUEST["securitykey"]);

if ($from_web
    && $ci0->getSession("securitykey") !== $ci0->getSecuritykey()
    ) {
    $mi0->abort(-1, NULL);
} else if ((!$from_web && !isset($_REQUEST["user"]))
    || !isset($_REQUEST["passold"])
    || !isset($_REQUEST["passnew"])
    ) {
    $mi0->abort(-2, NULL);
}

$user_id = ($from_web) ? $ci0->getSession("user_data")["pk_usuario"] : $_REQUEST["user"];
$pass_old = $_REQUEST["passold"];
$pass_new = $_REQUEST["passnew"];

$mi0->begin();

$mi0->query("
    SELECT
        contraseña
    FROM
        usuario
    WHERE pk_usuario = ?",
    $user_id
);
if ($mi0->result->num_rows > 0) {
    $current_pass_hash = $mi0->result->fetch_all(MYSQLI_ASSOC)[0]["contraseña"];
    if (!$mi0->checkHash($pass_old, $current_pass_hash)) {
        $mi0->end("rollback", -3, NULL);
    }
} else {
    $mi0->end("rollback", -4, NULL);
}

$mi0->query("
    UPDATE
        usuario
    SET
        contraseña = ?
    WHERE pk_usuario = ?",
    $mi0->hashString($pass_new), $user_id    
);
if ($mi0->result === TRUE) {
    $mi0->end("commit", 0, NULL);
} else {
    $mi0->end("rollback", -5, NULL);
}