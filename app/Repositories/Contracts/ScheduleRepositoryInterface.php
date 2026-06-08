<?php

namespace App\Repositories\Contracts;

use App\Models\Schedule;
use Illuminate\Database\Eloquent\Collection;

interface ScheduleRepositoryInterface
{
    public function getByFacility(int $facilityId): Collection;
    public function getFacilitySchedules(int $facilityId, int $perPage = 10);
    public function getActiveSchedules(int $facilityId): Collection;
    public function findById(int $id): ?Schedule;
    public function create(array $data): Schedule;
    public function update(Schedule $schedule, array $data): Schedule;
    public function delete(Schedule $schedule): bool;
    public function checkDuplicateDay(int $facilityId, int $dayOfWeek, ?int $excludeId = null): bool;
    public function getByFacilityAndDay(int $facilityId, int $dayOfWeek): ?Schedule;
}