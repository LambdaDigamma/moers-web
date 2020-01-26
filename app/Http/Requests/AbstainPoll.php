<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AbstainPoll extends FormRequest
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
        return [

        ];
    }
}
