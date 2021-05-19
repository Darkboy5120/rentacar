<?php
if (!$ci0->existSession("user_device_id")) {
    if (!isset($_SERVER['HTTP_USER_AGENT'])) {
        $mi0->end('rollback', -100, NULL);
    }

    $device_id = $_SERVER['HTTP_USER_AGENT'];

    $mi0->query("
        SELECT
            pk_dispositivo
        FROM
            dispositivo
        WHERE pk_dispositivo = ?",
        $device_id
    );
    if ($mi0->result->num_rows === 0) {
        $mi0->query("
            INSERT INTO
                dispositivo (pk_dispositivo)
            VALUES (?)",
            $device_id
        );
        if ($mi0->result === FALSE) {
            $mi0->end('rollback', -101, NULL);
        } else {
            $ci0->setSession("user_device_id", $device_id);
        }
    } else {
        $ci0->setSession("user_device_id", $device_id);
    }
}