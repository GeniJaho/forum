<?php


namespace App\Traits;


use App\Models\Activity;

trait RecordsActivity
{

    protected static function bootRecordsActivity()
    {
        if (auth()->guest()) {
            return;
        }

        foreach (self::getActivitiesToRecord() as $event) {
            static::$event(function ($model) use ($event) {
                $model->recordActivity($event);
            });
        }
    }

    protected static function getActivitiesToRecord(): array
    {
        return ['created'];
    }

    protected function recordActivity($event): void
    {
        $this->activity()->create([
            'user_id' => auth()->id(),
            'type' => $this->getActivityType($event),
        ]);
    }

    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject');
    }

    /**
     * @param $event
     * @return string
     */
    protected function getActivityType($event): string
    {
        $type = strtolower(class_basename(static::class));

        return "{$event}_{$type}";
    }
}
