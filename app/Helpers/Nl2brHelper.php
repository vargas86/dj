<?php

namespace App\Helpers;

class Nl2brHelper
{
    public static function instance()
    {
        return new Nl2brHelper();
    }

    public function print($old)
    {
        $positionsOld = $this->positions($old);

        if (strpos($old, "\r\n")) {
            $newArray = str_split($old);
            foreach ($positionsOld as $key) {
                $newArray[$key] = '&';
                $newArray[$key + 1] = '#';
                $newArray[$key + 2] = '1';
                $newArray[$key + 3] = '0';
                $newArray[$key + 4] = ';';
            }
            $new = implode($newArray);
            dd($new);
        } else {
        }
    }

    private function positions($string)
    {
        $lastPos = 0;
        $positions = array();
        while (($lastPos = strpos($string, "\r\n", $lastPos)) !== false) {
            $positions[] = $lastPos;
            $lastPos = $lastPos + strlen("\r\n");
        }
        return $positions;
    }
}
