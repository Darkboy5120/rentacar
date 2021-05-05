<?php
require "../users/root.php";
require "../utils/token_validation.php";

$from_web = isset($_REQUEST["securitykey"]);

if ($from_web
    && $ci0->getSession("securitykey") !== $ci0->getSecuritykey()
    ) {
    $mi0->abort(-1, NULL);
} else if (!TRUE) {
    $mi0->abort(-2, NULL);
}

$mi0->begin();

$mi0->query("
    SELECT
        pk_estado, nombre
    FROM
        estado"
);
if ($mi0->result->num_rows > 0) {
    $data = $mi0->result->fetch_all(MYSQLI_ASSOC);
    for ($i = 0; $i < count($data); $i++) {
        $mi0->query("
            SELECT
                pk_municipio, nombre
            FROM
                municipio
            WHERE fk_estado = ?",
            $data[$i]["pk_estado"]
        );
        if ($mi0->result->num_rows === 0) {
            $mi0->end("rollback", -3, NULL);
        }
        $cities = $mi0->result->fetch_all(MYSQLI_ASSOC);
        $data[$i]["cities"] = $cities;
    }
    $mi0->end("commit", 0, $data);
} else {
    $mi0->end("rollback", -4, NULL);
}