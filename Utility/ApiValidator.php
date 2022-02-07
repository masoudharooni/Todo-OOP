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

    // folder validation
    private static function isValidFolderParameters(array $parameters, string $method): bool
    {
        $sizeOfArray = null;
        $listOfParameter = null;
        $checkParameterDataType = null;
        switch ($method) {
            case 'create':
                $sizeOfArray = 2;
                $listOfParameter = ['user_id', 'title'];
                $checkParameterDataType = 'user_id';
                break;

            case 'update':
                $sizeOfArray = 2;
                $listOfParameter = ['id', 'title'];
                $checkParameterDataType = "id";
                break;

            case 'delete':
                $sizeOfArray = 1;
                $listOfParameter = ['id'];
                $checkParameterDataType = "id";
        }

        if (sizeof($parameters) != $sizeOfArray)
            return false;
        foreach ($parameters as $key => $value)
            if (!in_array($key, $listOfParameter) || is_null($value))
                return false;
        if (!is_int($parameters[$checkParameterDataType]))
            return false;
        return true;
    }

    public static function isValidFolderForCreate(array $parameters): bool
    {
        return self::isValidFolderParameters($parameters, 'create');
    }
    public static function isValidParametersForUpdateFolder(array $parameters): bool
    {
        return self::isValidFolderParameters($parameters, 'update');
    }
    public static function isValidParameterForDeleteFolder(array $parameters): bool
    {
        return self::isValidFolderParameters($parameters, 'delete');
    }

    # athentication data validation
    public static function authDataValidator(array $data): bool
    {
        if (sizeof($data) != 3)
            return false;
        foreach ($data as $key => $value)
            if (!in_array($key, ['action', 'email', 'password']) || is_null($value))
                return false;
        if (!in_array($data['action'], ['login', 'signup']))
            return false;
        return true;
    }
}
