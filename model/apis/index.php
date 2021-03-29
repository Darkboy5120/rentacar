<?php
require "../libraries/cookie_interface.php";

$API = NULL;

if ($ci0->getCookie("securitykey") !== $ci0->getSecurityKey()) {
    echo "You are not allowed to use me";exit;
}
if (isset($_POST["api"])) {
    $API = $_POST["api"];
    switch ($API) {
        case "register_admin_step2":
            require "web/register_step2.php";
            break;
        case "login_admin":
            require "web/login.php";
            break;
        case "signout":
            require "web/signout.php";
            break;
        default: echo "That's not a valid api";
    }
}