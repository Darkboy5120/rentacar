<?php
$response = array(
    "code" => 0,
    "log" => ""
);
try {
    $ci0->destroy();
} catch (Exception $e) {
    $response["code"] = -1;
    $response["log"] = "Something went wrong";
}
echo json_encode($response);