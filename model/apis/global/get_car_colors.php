<?php
require "../users/root.php";
require "../utils/token_validation.php";

$user_agent = strtolower($_SERVER['HTTP_USER_AGENT']);
$is_mobile = is_numeric(strpos($user_agent, "mobile"));

if (!$is_mobile && !isset($_POST["securitykey"])
    && $ci0->getCookie("securitykey") !== $ci0->getSecuritykey()
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