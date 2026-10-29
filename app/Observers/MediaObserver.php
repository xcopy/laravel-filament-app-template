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
            ->event("media.$event")
            ->log(__(':event the file ":name"', [
                'event' => __($event),
                'name' => "$media->name.$media->extension",
            ]));
    }
}
