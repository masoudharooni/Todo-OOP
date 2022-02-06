<?php

use Services\Tasks;
use Utility\ApiValidator;
use Utility\Response;

include "../../../autoload.php";

$requestMethod = $_SERVER['REQUEST_METHOD'];
$tasks = new Tasks;
$dataOfBodyRequest = json_decode(file_get_contents("php://input"), true);

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
        if (!ApiValidator::isValidTaskForCreate($dataOfBodyRequest))
            Response::respondByDie(['Your parameters is not valid for create a new task!'], Response::HTTP_NOT_ACCEPTABLE);
        $newTaskId = $tasks->add($dataOfBodyRequest);
        $response  = $tasks->get(user_id: $dataOfBodyRequest['user_id'], id: $newTaskId);
        Response::respondByDie($response, Response::HTTP_CREATED);
    case 'PUT':
        if (!ApiValidator::isValidTaskForUpdate($dataOfBodyRequest))
            Response::respondByDie(['Your parameters is not valid for update a task!'], Response::HTTP_NOT_MODIFIED);
        $updateStatus = $tasks->update($dataOfBodyRequest);
        Response::respondByDie([$updateStatus], Response::HTTP_OK);
    case 'DELETE':
        if (!ApiValidator::isValidTaskForDelete($dataOfBodyRequest))
            Response::respondByDie(['parameter is not valid for delete a task!'], Response::HTTP_NOT_ACCEPTABLE);
        $response = $tasks->delete($dataOfBodyRequest['id']);
        Response::respondByDie([$response], Response::HTTP_OK);
    default:
        echo "Request method is not valid!";
        break;
}
