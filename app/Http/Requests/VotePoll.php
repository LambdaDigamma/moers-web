<?php

namespace App\Http\Requests;

use App\Rules\CheckPollHasOption;
use App\Rules\SatisfiesPollOptionsMaxCheck;
use Illuminate\Foundation\Http\FormRequest;

class VotePoll extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $poll = $this->route('poll');
        return $poll->canUserVote();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $poll = $this->route('poll');
        return [
            'options' => ['required', 'array', 'min:1', new SatisfiesPollOptionsMaxCheck($poll)],
            'options.*' => ['required', 'integer', 'exists:poll_options,id', new CheckPollHasOption($poll)]
        ];
    }
}
