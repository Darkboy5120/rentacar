<?php
require "guest_validation.php";

$THROTTLE_LIMIT = 2;
$THROTTLE_SECONDS = 5;

if (!$ci0->existSession("user_device_id")) {
    $mi0->end('rollback', -102, NULL);
}
$device_id = $ci0->getSession("user_device_id");

$mi0->begin();

$mi0->query("
    SELECT
        fk_dispositivo
    FROM
        dispositivo_peticion
    WHERE fk_dispositivo = ? AND fecha_hora > (CURRENT_TIMESTAMP() - $THROTTLE_SECONDS)",
    $device_id
);
if ($mi0->result->num_rows > $THROTTLE_LIMIT) {
    $mi0->end('rollback', -103, NULL);
}

$mi0->query("
    INSERT INTO
        dispositivo_peticion
        (fk_dispositivo)
    VALUES (?)",
    $device_id
);
if ($mi0->result !== TRUE) {
    $mi0->end('rollback', -104, NULL);
}