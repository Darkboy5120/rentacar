<?php
$LANGUAGE = "spanish";
$lang_path = array(
    "spanish" => "view/languages/spanish.php",
    "english" => "view/languages/english.php"
);
if (isset($_COOKIE["l"]) && array_key_exists($LANGUAGE, $lang_path)) {
    $LANGUAGE = $_COOKIE["l"];
}
require $lang_path[$LANGUAGE];

switch ($_GET["p"]) {
    case "carview":
        require "view/pages/main/carview.php";
        break;
    case "login":
        require "view/pages/main/login.php";
        break;
    case "register":
        require "view/pages/main/register.php";
        break;
    case "home":
        require "view/pages/main/home.php";
        break;
    case "signout":
        require "model/libraries/cookie_interface.php";
        $ci0->destroy();
        header("Location: ?p=login");
        break;
    case "profile":
        require "view/pages/main/profile.php";
        break;
    case "sales":
        require "view/pages/main/sales.php";
        break;
    case "drivers":
        require "view/pages/main/drivers.php";
        break;
    case "newcar":
        require "view/pages/main/newcar.php";
        break;
    case "editcar":
        require "view/pages/main/editcar.php";
        break;
    default:
        header("Location: ?p=login");
}