<?php

namespace App;


use Exception;

class Spam
{

    public function detect($text): bool
    {
        $this->detectInvalidKeywords($text);

        return false;
    }

    /**
     * @throws Exception
     */
    protected function detectInvalidKeywords($text): bool
    {
        $invalidKeywords = [
            'yahoo customer support'
        ];

        foreach ($invalidKeywords as $keyword) {
            if (stripos($text, $keyword) !== false) {
                throw new Exception('The text contains spam.');
            }
        }

        return false;
    }
}
