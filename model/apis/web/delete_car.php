<?php
require "../users/root.php";
require "../utils/token_validation.php";

$user_agent = strtolower($_SERVER['HTTP_USER_AGENT']);
$is_mobile = is_numeric(strpos($user_agent, "mobile"));

if (!$is_mobile && !isset($_POST["securitykey"])
    && $ci0->getCookie("securitykey") !== $ci0->getSecuritykey()
    ) {
    $mi0->abort(-1, NULL);
} else if (!isset($_POST["car"])) {
    $mi0->abort(-2, NULL);
}

$mi0->begin();

$user_data = $ci0->getCookie("user_data");
$car_id = $_POST["car"];

$mi0->query("
    DELETE FROM auto
    WHERE pk_auto = ? AND fk_administrador = ?",
    $car_id, $user_data["pk_usuario"]
);
if ($mi0->result === TRUE) {
    $mi0->end("commit", 0, NULL);
} else {
    $mi0->end("rollback", -3, NULL);
}