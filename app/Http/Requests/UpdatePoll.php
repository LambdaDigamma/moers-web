<?php

namespace App\Http\Requests;

use App\Poll;
use Bouncer;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePoll extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $poll = Poll::find($this->route('poll'))->first();
        return Bouncer::can('edit', $poll);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'question' => 'required|string|min:3|max:500',
            'description' => 'required|string|min:3',
        ];
    }
}
