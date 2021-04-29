<?php

namespace App\Inspections;


class Spam
{
    protected array $inspections = [
        InvalidKeywords::class,
        KeyHeldDown::class
    ];

    public function detect($body): bool
    {
        foreach ($this->inspections as $inspection) {
            app($inspection)->detect($body);
        }

        return false;
    }
}
