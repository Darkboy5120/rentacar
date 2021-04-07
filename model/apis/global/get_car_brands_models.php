<?php
require "../users/root.php";
require "../utils/token_validation.php";

$from_web = !isset($_POST["securitykey"]);

if ($from_web
    && $ci0->getCookie("securitykey") !== $ci0->getSecuritykey()
    ) {
    $mi0->abort(-1, NULL);
} else if (!TRUE) {
    $mi0->abort(-2, NULL);
}

$mi0->begin();

$mi0->query("
    SELECT
        pk_auto_marca, nombre
    FROM
        auto_marca"
);
if ($mi0->result->num_rows > 0) {
    $data = $mi0->result->fetch_all(MYSQLI_ASSOC);
    for ($i = 0; $i < count($data); $i++) {
        $mi0->query("
            SELECT
                pk_auto_modelo, nombre
            FROM
                auto_modelo
            WHERE fk_auto_marca = ?",
            $data[$i]["pk_auto_marca"]
        );
        if ($mi0->result->num_rows === 0) {
            $mi0->end("rollback", -3, NULL);
        }
        $models = $mi0->result->fetch_all(MYSQLI_ASSOC);
        $data[$i]["models"] = $models;
    }
    $mi0->end("commit", 0, $data);
} else {
    $mi0->end("rollback", -4, NULL);
}