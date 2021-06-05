<?php
require "model/libraries/cs_interface.php";

$LANGUAGE = "spanish";
$language_values = array("spanish", "english");
$lang_path = array(
    "spanish" => "view/languages/spanish.php",
    "english" => "view/languages/english.php"
);
$CURRENCY = "mxn";
$currency_values = array("mxn", "usd");

if (!$ci0->existCookie("c")) {
    $ci0->setCookie("c", $CURRENCY);
} else if (!in_array($ci0->getCookie("c"), $currency_values)) {
    $ci0->setCookie("c", $CURRENCY);
}

if (!$ci0->existCookie("l")) {
    $ci0->setCookie("l", $LANGUAGE);
} else if (!array_key_exists($ci0->getCookie("l"), $lang_path)) {
    $ci0->setCookie("l", $LANGUAGE);
} else {
    $LANGUAGE = $ci0->getCookie("l");
}
require $lang_path[$LANGUAGE];

$THEME = "dark";
if (!$ci0->existCookie("t")) {
    $ci0->setCookie("t", $THEME);
}

if (!isset($_GET["p"])) {
    header("Location: ?p=login");
}

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
    case "welcome":
        require "view/pages/main/welcome.php";
        break;
    case "newdriver":
        require "view/pages/main/newdriver.php";
        break;
    default:
        header("Location: ?p=login");
}