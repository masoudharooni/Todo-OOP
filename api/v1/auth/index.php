<?php

use Services\Auth;
use Utility\ApiValidator;
use Utility\Response;

include "../../../autoload.php";
$requestMethod = $_SERVER['REQUEST_METHOD'];
$dataOfBodyRequest = json_decode(file_get_contents('php://input'), true);
$auth = new Auth;
switch ($requestMethod) {
    case 'POST':
        if (!ApiValidator::authDataValidator($dataOfBodyRequest))
            Response::respondByDie(['parameters are not valid!'], Response::HTTP_NOT_ACCEPTABLE);
        if ($dataOfBodyRequest['action'] == "login") {
            $response = $auth->login($dataOfBodyRequest);
            Response::respondByDie([$response], Response::HTTP_OK);
        } elseif ($dataOfBodyRequest['action'] == "signup") {
            $response = $auth->signup($dataOfBodyRequest);
            Response::respondByDie(['status' => $response['bool'], 'message' => $response['message']], Response::HTTP_OK);
        }
    default:
        echo "Request method is not valid!";
        break;
}
