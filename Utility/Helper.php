<?php

namespace Utility;

class Helper
{
    public static function getCurrentUserId(): ?int
    {
        return $_SESSION['login']->id ?? null;
    }
}
