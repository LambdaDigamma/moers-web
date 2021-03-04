<?php

namespace App\Http\Requests;

use App\Models\Group;
use Bouncer;
use Illuminate\Foundation\Http\FormRequest;
use Request;

class StorePoll extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Request::get('group_id') != null) {
            $group = Group::find(Request::get('group_id'))->firstOrFail();
            return Bouncer::can('create-poll', $group);
        } else {
            return false;
        }
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
            'group_id' => 'required|integer|exists:groups,id',
            'options' => 'required|array|min:2|max:200',
            'options.*' => 'required|string|min:1|max:255',
            'max_check' => 'required|integer|min:1' // TODO: Make working! 'lt:options'
        ];
    }
}
