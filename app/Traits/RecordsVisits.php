<?php


namespace App\Traits;


trait RecordsVisits
{

    public function visit()
    {
        $this->increment($this->visitsColumnName());
    }

    protected function visitsColumnName(): string
    {
        return 'visits';
    }
}
