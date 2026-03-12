<?php

namespace Modules\Core\Observers;

use Illuminate\Database\Eloquent\Model;

class CascadeSoftDeleteObserver
{
    public function deleting(Model $model)
    {
        if (property_exists($model, 'cascadeDeletes')) {
            foreach ($model->cascadeDeletes as $relation) {
                foreach ($model->$relation as $related) {
                    $related->delete();
                }
            }
        }
    }

    public function restoring(Model $model)
    {
        if (request()->input('restore_cascade', 0) == 1) {
            if (property_exists($model, 'cascadeDeletes')) {
                foreach ($model->cascadeDeletes as $relation) {
                    $model->$relation()
                            ->onlyTrashed()
                            ->get()
                            ->each(function ($related) {
                                $related->restore();
                            });
                }
            }
        }
    }
}
