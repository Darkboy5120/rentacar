<?php
require "../libraries/cs_interface.php";

$API = NULL;

if (isset($_REQUEST["api"])) {
    $API = $_REQUEST["api"];
    switch ($API) {
        case "register_admin_step1":
            require "web/register_step1.php";
            break;
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
        case "get_states_cities":
            require "global/get_states_cities.php";
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
        case "validate_l_register_step2":
            require "mobile/validate_l_register_step2.php";
            break;
        case "signup_l_register":
            require "mobile/signup_l_register_step3.php";
            break;
        case "login_lessee":
            require "mobile/login.php";
            break;
        case "create_driver":
            require "web/create_driver.php";
            break;
        case "get_drivers":
            require "web/get_drivers.php";
            break;
        case "set_fire_driver":
            require "web/fire_driver.php";
            break;
        case "get_filtered_cars":
            require "mobile/get_filtered_cars.php";
            break;
        case "rent_car":
            require "mobile/rent_car.php";
            break;
        case "get_requested_cars":
            require "mobile/get_requested_cars.php";
            break;
        case "update_rent_phase":
            require "mobile/update_rent_phase.php";
            break;
        case "get_penalties":
            require "mobile/get_penalties.php";
            break;
        case "upload_penalties":
            require "mobile/upload_penalties.php";
            break;
        default: echo json_encode("That's not a valid api");
    }
}