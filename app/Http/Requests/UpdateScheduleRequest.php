<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateScheduleRequest extends FormRequest
{
    public function authorize(): bool
    {
        if (!auth()->check() || auth()->user()->role !== 'seller') {
            return false;
        }

        $scheduleId = $this->route('id');
        
        $schedule = \App\Models\Schedule::with('facility')->find($scheduleId);
        
        if (!$schedule) {
            return false; 
        }

        return $schedule->facility->seller_id === auth()->id();
    }

    public function rules(): array
    {
        $scheduleId = $this->route('id');
        $schedule = \App\Models\Schedule::find($scheduleId);
        $facilityId = $schedule ? $schedule->facility_id : null;

        return [
            'day_of_week' => [
                'required', 
                'integer', 
                'between:1,7',
                Rule::unique('schedules')->where(function ($query) use ($facilityId) {
                    return $query->where('facility_id', $facilityId);
                })->ignore($scheduleId)
            ],
            'open_time' => ['required', 'date_format:H:i'],
            'close_time' => ['required', 'date_format:H:i', 'after:open_time'],
            'slot_duration' => ['required', 'integer', 'min:30'],
            'is_active' => ['boolean'],
        ];
    }
}