<?php
require "../users/root.php";
require "../utils/token_validation.php";

$from_web = $ci0->existSession("securitykey");

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
        pk_auto_color_pintura, nombre
    FROM
        auto_color_pintura"
);
if ($mi0->result->num_rows > 0) {
    $data = $mi0->result->fetch_all(MYSQLI_ASSOC);
    $mi0->end("commit", 0, $data);
} else {
    $mi0->end("rollback", -3, NULL);
}