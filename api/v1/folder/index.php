<?php

use Services\Folders;
use Utility\Response;

include "../../../autoload.php";
$requestMethod = $_SERVER['REQUEST_METHOD'];
$folders = new Folders;
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
        echo "POST";
        break;
    case 'PUT':
        echo "PUT";
        break;
    case 'DELETE':
        echo "DELETE";
        break;
    default:
        echo "request method is not valid!";
        break;
}
