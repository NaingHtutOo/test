<?php

namespace Helpers;

class HTTP
{
    static $base = "http://localhost/bootstrap_projects/tenkafuma_project";

    static function redirect ( $path, $query = "" )
    {
        $url = static::$base . $path;
        if( $query ) $url .= "?$query";

        header("location: $url");
        exit();
    }
}