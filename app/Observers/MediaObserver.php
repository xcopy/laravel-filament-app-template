<?php

namespace App\Observers;

use App\Models\Media;

class MediaObserver
{
    public function created(Media $media): void
    {
        $this->logActivity($media, __FUNCTION__);
    }

    public function deleted(Media $media): void
    {
        $this->logActivity($media, __FUNCTION__);
    }

    private function logActivity(Media $media, string $event): void
    {
        activity()
            ->performedOn($media->model)
            ->causedBy($media->creator)
            // TODO:
            // The "media." prefix identifies the subject and helps distinguish these
            // from other activity types that might also be called "created" or "deleted".
            // Using event($event) would work, but would store only the generic label.
            ->event("media.$event")
            ->log(__(':event the file ":name"', [
                'event' => __($event),
                'name' => "$media->name.$media->extension",
            ]));
    }
}
