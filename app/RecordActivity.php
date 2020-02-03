<?php


namespace App;


use ReflectionClass;

trait RecordActivity
{

    protected static function bootRecordActivity()
    {
        if (auth()->guest()) return;
        static::created(function ($thread) {
            $thread->recordActivity('created');
        });
    }

    protected function recordActivity($event)
    {
        Activity::create([
            'user_id' => auth()->id(),
            'type' => $this->getStr($event),
            'subject_id' => $this->id,
            'subject_type' => get_class($this),
        ]);
    }

    protected function getStr($event): string
    {
        return $event . '_' . strtolower((new ReflectionClass($this))->getShortName());
    }

}
