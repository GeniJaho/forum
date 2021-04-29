<?php


namespace App\Inspections;


use Exception;

class InvalidKeywords
{
    private array $keywords = [
        'yahoo customer support'
    ];

    /**
     * @throws Exception
     */
    public function detect($body)
    {
        foreach ($this->keywords as $keyword) {
            if (stripos($body, $keyword) !== false) {
                throw new Exception('The text contains spam.');
            }
        }
    }
}
