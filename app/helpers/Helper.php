<?php

namespace App\Helpers;
class Helper
{


    public function __construct() {}



    /**
     * Solve the dot reference like database.host
     * @param string $key
     * @return mixed
     */
    static function getBYDot(string $key)
    {
        $config = explode(".", $key);
        if (count($config) > 0) {
            $result = include __DIR__ . "/../" . $config[0] . ".php";
            return $result[$config[1]] ?? null;
        }
    }
    
}
