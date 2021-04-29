<?php


namespace App\Inspections;


use Exception;

class KeyHeldDown
{
    /**
     * @throws Exception
     */
    public function detect($body)
    {
        if (preg_match('/(.)\\1{4,}/', $body)) {
            throw new Exception('The text contains spam.');
        }
    }
}
