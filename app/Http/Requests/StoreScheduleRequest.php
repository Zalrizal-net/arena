<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Facility;

class StoreScheduleRequest extends FormRequest
{
    public function authorize(): bool
    {
        if (!auth()->check() || auth()->user()->role !== 'seller') {
            return false;
        }

        $facilityId = $this->input('facility_id');
        $facility = Facility::find($facilityId);

        return $facility && $facility->seller_id === auth()->id();
    }

    public function rules(): array
    {
        return [
            'facility_id' => ['required', 'exists:facilities,id'],
            'day_of_week' => [
                'required', 
                'integer', 
                'between:1,7',
                Rule::unique('schedules')->where(function ($query) {
                    return $query->where('facility_id', $this->facility_id);
                })
            ],
            'open_time' => ['required', 'date_format:H:i'],
            'close_time' => ['required', 'date_format:H:i', 'after:open_time'],
            'slot_duration' => ['required', 'integer', 'min:30'],
            'is_active' => ['boolean'],
        ];
    }
}