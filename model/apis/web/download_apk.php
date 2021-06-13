<?php
require "../users/root.php";
require "../utils/user_validation.php";

$response = array("code" => 0, "data" => NULL);

$url = "../utils/lastest_version.apk";
if(file_exists($url)) {

    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($url).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($url));
    readfile($url);
} else {
    $reponse["code"] = -1;
}
exit;
//echo json_encode($response);