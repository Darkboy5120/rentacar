<?php
require "../users/root.php";
require "../utils/user_validation.php";

if (FALSE
    ) {
        $mi0->abort(-1, NULL);
}

$user_id = $ci0->getSession("user_data")["pk_usuario"];

$mi0->begin();

$mi0->query("
    SELECT
        "
);