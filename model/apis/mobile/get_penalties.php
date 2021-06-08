<?php
require "../users/root.php";
require "../utils/user_validation.php";

if (FALSE
    ) {
    $mi0->abort(-1, NULL);
}

$mi0->begin();

$mi0->query("
    SELECT
        pk_penalizacion, nombre, precio
    FROM
        penalizacion"
);
if ($mi0->result->num_rows > 0) {
    $mi0->end("commit", 0, $mi0->result->fetch_all(MYSQLI_ASSOC));
} else {
    $mi0->end("rollback", -2, NULL);
}