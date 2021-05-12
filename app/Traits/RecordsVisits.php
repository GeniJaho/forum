<?php


namespace App\Traits;


trait RecordsVisits
{

    public function visit()
    {
        $this->increment('visits');
    }
}
