<?php

namespace App\Rules;
use FFMpeg;
use Illuminate\Contracts\Validation\Rule;

class VideoDuration implements Rule
{
    protected $duration;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($duration = 60)
    {
        $this->duration = $duration;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $video)
    {
        $media = FFMpeg::fromDisk('local_root')->open($video->path());

        if($media->getDurationInSeconds() > $this->duration)
            return false;

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "The duration must be less than {$this->duration} seconds";
    }
}
