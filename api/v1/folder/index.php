<?php

use Services\Folders;
use Utility\ApiValidator;
use Utility\Response;

include "../../../autoload.php";
$requestMethod = $_SERVER['REQUEST_METHOD'];
$folders = new Folders;
$dataOfBodyRequest = json_decode(file_get_contents('php://input'), true);
switch ($requestMethod) {
    case 'GET':
        $queryStringParameter = [
            'userId' => $_GET['user_id'] ?? null,
            'folderId' => $_GET['id'] ?? null
        ];
        $checkQueryStringValidation = [
            'userId' => is_numeric($queryStringParameter['userId']),
            'folderId' => is_numeric($queryStringParameter['folderId']) || is_null($queryStringParameter['folderId'])
        ];
        if (!$checkQueryStringValidation['userId'])
            Response::respondByDie(["user_id parameter is required!"], Response::HTTP_NOT_ACCEPTABLE);
        if (!$checkQueryStringValidation['folderId'])
            Response::respondByDie(["id parameter should be an interger!"], Response::HTTP_NOT_ACCEPTABLE);
        $respons = $folders->get($queryStringParameter['userId'], $queryStringParameter['folderId']);
        Response::respondByDie($respons, Response::HTTP_OK);

    case 'POST':
        if (!ApiValidator::isValidFolderForCreate($dataOfBodyRequest))
            Response::respondByDie(['Parameters are not valid!'], Response::HTTP_NOT_ACCEPTABLE);
        $respons = $folders->add($dataOfBodyRequest);
        Response::respondByDie([$respons], Response::HTTP_CREATED);
    case 'PUT':
        if (!ApiValidator::isValidParametersForUpdateFolder($dataOfBodyRequest))
            Response::respondByDie(['Parameters is not valid'], Response::HTTP_NOT_MODIFIED);
        $response = $folders->update($dataOfBodyRequest);
        Response::respondByDie([$response], Response::HTTP_OK);
    case 'DELETE':
        echo "DELETE";
        break;
    default:
        echo "request method is not valid!";
        break;
}
