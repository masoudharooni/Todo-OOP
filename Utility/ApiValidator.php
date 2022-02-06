<?php

namespace Utility;

class ApiValidator
{
    public static function isValidTaskForCreate(array $data): bool
    {
        if (sizeof($data) != 3)
            return false;
        foreach ($data as $key => $value)
            if (!in_array($key, ['user_id', 'folder_id', "title"]) || is_null($value))
                return false;
        if (!is_int($data['user_id']) || !is_int($data['folder_id']))
            return false;
        return true;
    }
    public static function isValidTaskForUpdate(array $parameters): bool
    {
        if (sizeof($parameters) != 2)
            return false;
        foreach ($parameters as $key => $parameter)
            if (!in_array($key, ['id', 'title']) || is_null($parameter))
                return false;
        if (!is_int($parameters['id']))
            return false;
        return true;
    }
    public static function isValidTaskForDelete(array $parameters): bool
    {
        if (sizeof($parameters) != 1)
            return false;
        foreach ($parameters as $key => $parameter)
            if (!in_array($key, ['id']) || is_null($parameter))
                return false;
        if (!is_int($parameters['id']))
            return false;
        return true;
    }
}
