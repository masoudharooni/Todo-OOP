<?php

namespace Utility;

class ApiValidator
{
    private static function isValidTask(array $parameters, string $method): bool
    {
        $sizeOfArray = null;
        $listOfParameter = null;
        switch ($method) {
            case 'create':
                $sizeOfArray = 3;
                $listOfParameter = ['user_id', 'folder_id', "title"];
                break;
            case 'update':
                $sizeOfArray = 2;
                $listOfParameter = ['id', 'title'];
                break;
            case 'delete':
                $sizeOfArray = 2;
                $listOfParameter = ['id'];
        }
        if (sizeof($parameters) != $sizeOfArray)
            return false;
        foreach ($parameters as $key => $parameter)
            if (!in_array($key, $listOfParameter) || is_null($parameter))
                return false;

        if ($method == 'create') {
            if (!is_int($parameters['user_id']) || !is_int($parameters['folder_id']))
                return false;
            return true;
        } else {
            if (!is_int($parameters['id']))
                return false;
            return true;
        }
    }

    public static function isValidTaskForCreate(array $data): bool
    {
        return self::isValidTask($data, 'create');
    }
    public static function isValidTaskForUpdate(array $parameters): bool
    {
        return self::isValidTask($parameters, 'update');
    }
    public static function isValidTaskForDelete(array $parameters): bool
    {
        return self::isValidTask($parameters, 'delete');
    }
}
