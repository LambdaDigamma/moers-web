<?php

namespace App\Rules;

use App\Poll;
use Illuminate\Contracts\Validation\Rule;

class SatisfiesPollOptionsMaxCheck implements Rule
{

    private $poll;

    /**
     * Create a new rule instance.
     *
     * @param Poll $poll
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
        return count($value) == $this->poll->max_check;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The number of provided selected options does not match the required number that this poll requires.';
    }
}
