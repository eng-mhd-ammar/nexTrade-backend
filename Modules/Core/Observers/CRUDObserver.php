<?php

namespace Modules\Core\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class CRUDObserver
{
    protected string $channel;

    protected function logAction(string $action, Model $model)
    {
        // $this->channel = property_exists($model, 'LOG_CHANNEL') && !empty($model::$LOG_CHANNEL)
        //     ? $model::$LOG_CHANNEL
        //     : 'default';

        // $modelName = class_basename($model);
        // Log::channel($this->channel)->info("{$modelName} {$action}: ", $model->toArray());
    }


    public function created(Model $model)
    {
        $this->logAction('created', $model);
    }

    public function updated(Model $model)
    {
        $this->logAction('updated', $model);
    }

    public function deleted(Model $model)
    {
        $this->logAction('deleted', $model);
    }

    public function restored(Model $model)
    {
        $this->logAction('restored', $model);
    }

    public function forceDeleted(Model $model)
    {
        $this->logAction('force deleted', $model);
    }
}
