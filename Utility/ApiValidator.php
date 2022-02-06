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
        return true;
    }
    public static function isValidTaskForUpdate(array $parameters): bool
    {
        if (sizeof($parameters) != 2)
            return false;
        foreach ($parameters as $key => $parameter)
            if (!in_array($key, ['id', 'title']) || is_null($parameter))
                return false;
        return true;
    }
}
