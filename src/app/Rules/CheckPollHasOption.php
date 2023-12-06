<?php

namespace App\Rules;

use App\Models\Poll;
use App\Models\PollOption;
use Illuminate\Contracts\Validation\Rule;

class CheckPollHasOption implements Rule
{

    private $poll;

    /**
     * Create a new rule instance.
     *
     * @param \App\Models\Poll $poll
     */
    public function __construct(Poll $poll)
    {
        $this->poll = $poll;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $option = PollOption::find($value);
        if (!is_null($option)) {
            return $this->poll->options->contains($option);
        } else {
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The provided poll does not have this associated option.';
    }
}
