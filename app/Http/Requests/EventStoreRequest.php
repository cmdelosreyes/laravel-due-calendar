<?php

namespace App\Http\Requests;

use App\Enums\CarbonDays;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EventStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                'string',
            ],
            'start_at' => [
                'required',
                'date',
                'date_format:Y-m-d',
                'before_or_equal:end_at',
            ],
            'end_at' => [
                'required',
                'date',
                'date_format:Y-m-d',
                'after_or_equal:start_at',
            ],
            'days' => [
                'required',
                'array',
            ],
            'days.*' => [
                'required',
                Rule::in(CarbonDays::all())
            ]
        ];
    }
}
