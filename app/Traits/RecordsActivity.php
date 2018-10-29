<?php

namespace App\Traits;

use App\Activity;
use ReflectionClass;

trait RecordsActivity
{
    protected static function bootRecordsActivity()
    {
        foreach (static::getModelEvents() as $event) {
            static::$event(function ($model) use ($event) {
                $model->recordActivity($event, null, null, false);
            });
        }
    }

    public function recordActivity($event, $sub_type = null, $user_id = null, $custom = true, $read = false)
    {
        if (!is_array($user_id)) {
            return $this->createActivity($event, $sub_type, $user_id, $custom, $read);
        }

        foreach ($user_id as $id) {
            $this->createActivity($event, $sub_type, $id, $custom, $read);
        }

        return;
    }

    protected function createActivity($event, $sub_type, $user_id, $custom, $read)
    {
        Activity::create([
            'activitable_id' => $this->id,
            'activitable_type' => get_class($this),
            'type' => $custom ? $event : $this->getActivityName($this, $event),
            'sub_type' => $sub_type,
            'user_id' => $user_id ?: $this->user_id ?: $this->id,
            'read' => $read
        ]);
    }

    protected function getActivityName($model, $action)
    {
        $name = strtolower(snake_case((new ReflectionClass($model))->getShortName()));

        return "{$action}_{$name}";
    }

    protected static function getModelEvents()
    {
        if (isset(static::$recordEvents)) {
            return static::$recordEvents;
        }

        return ['created', 'deleted', 'updated'];
    }
}