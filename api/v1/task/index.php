<?php

use Services\Tasks;
use Utility\Response;

include "../../../autoload.php";

$requestMethod = $_SERVER['REQUEST_METHOD'];
$tasks = new Tasks;


switch ($requestMethod) {
    case 'GET':
        $queryStringsParameters = [
            "userId"   => $_GET['user_id'] ?? null,
            "folderId" => $_GET['folder_id'] ?? null,
            "taskId"   => $_GET['task_id'] ?? null,
            "search"   => $_GET['search'] ?? null
        ];
        $checkQueryStringValidation = [
            'userId' => is_numeric($queryStringsParameters['userId']),
            'folderId' => is_numeric($queryStringsParameters['folderId']) || is_null($queryStringsParameters['folderId']),
            'taskId' => is_numeric($queryStringsParameters['taskId']) || is_null($queryStringsParameters['taskId']),
        ];
        if (!$checkQueryStringValidation['userId'])
            Response::respondByDie(['user_id is a require parameter!'], Response::HTTP_NOT_ACCEPTABLE);

        if (!$checkQueryStringValidation['folderId'])
            Response::respondByDie(['folder_id must be an integer!'], Response::HTTP_NOT_ACCEPTABLE);

        if (!$checkQueryStringValidation['taskId'])
            Response::respondByDie(['task_id must be an integer!'], Response::HTTP_NOT_ACCEPTABLE);

        $response = $tasks->get($queryStringsParameters['userId'], $queryStringsParameters['folderId'], $queryStringsParameters['taskId'], $queryStringsParameters['search']);
        Response::respondByDie($response, Response::HTTP_OK);

    case 'POST':
        echo "POST request";
        break;
    case 'PUT':
        echo "PUT request";
        break;
    case 'DELETE':
        echo "DELETE request";
        break;
    default:
        echo "Request method is not valid!";
        break;
}
