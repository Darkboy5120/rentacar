<?php
require "../libraries/cookie_interface.php";

$API = NULL;

if (isset($_POST["api"])) {
    $API = $_POST["api"];
    switch ($API) {
        case "register_admin_step2":
            require "web/register_step2.php";
            break;
        case "login_admin":
            require "global/login.php";
            break;
        case "create_car":
            require "web/create_car.php";
            break;
        case "get_car_brands_models":
            require "global/get_car_brands_models.php";
            break;
        case "get_car_colors":
            require "global/get_car_colors.php";
            break;
        case "get_cars":
            require "global/get_admin_cars.php";
            break;
        case "delete_car":
            require "web/delete_car.php";
            break;
        case "get_car_by_id":
            require "global/get_car_by_id.php";
            break;
        case "edit_car":
            require "web/edit_car.php";
            break;
        case "get_admin_info":
            require "global/get_admin_info.php";
            break;
        case "edit_admin_personal_info":
            require "web/edit_admin_personal_info.php";
            break;
        case "edit_admin_bussiness_info":
            require "web/edit_admin_bussiness_info.php";
            break;
        case "edit_user_password":
            require "global/edit_user_password.php";
            break;
        default: echo json_encode("That's not a valid api");
    }
}