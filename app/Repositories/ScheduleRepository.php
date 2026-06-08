<?php

namespace App\Repositories;

use App\Models\Schedule;
use App\Repositories\Contracts\ScheduleRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ScheduleRepository implements ScheduleRepositoryInterface
{
    public function getByFacility(int $facilityId): Collection
    {
        return Schedule::where('facility_id', $facilityId)->orderBy('day_of_week', 'asc')->get();
    }

    public function getFacilitySchedules(int $facilityId, int $perPage = 10)
    {
        return Schedule::where('facility_id', $facilityId)
            ->orderBy('day_of_week', 'asc')
            ->paginate($perPage);
    }

    public function getActiveSchedules(int $facilityId): Collection
    {
        return Schedule::where('facility_id', $facilityId)
            ->where('is_active', true)
            ->orderBy('day_of_week', 'asc')
            ->get();
    }

    public function findById(int $id): ?Schedule
    {
        return Schedule::with('facility')->find($id);
    }

    public function create(array $data): Schedule
    {
        return Schedule::create($data);
    }

    public function update(Schedule $schedule, array $data): Schedule
    {
        $schedule->update($data);
        return $schedule;
    }

    public function delete(Schedule $schedule): bool
    {
        return $schedule->delete();
    }

    public function checkDuplicateDay(int $facilityId, int $dayOfWeek, ?int $excludeId = null): bool
    {
        $query = Schedule::where('facility_id', $facilityId)
            ->where('day_of_week', $dayOfWeek);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }

    public function getByFacilityAndDay(int $facilityId, int $dayOfWeek): ?Schedule
    {
        return Schedule::where('facility_id', $facilityId)
            ->where('day_of_week', $dayOfWeek)
            ->where('is_active', true)
            ->first();
    }
}