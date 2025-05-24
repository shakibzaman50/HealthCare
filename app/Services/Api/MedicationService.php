<?php

namespace App\Services\Api;

use App\Models\Medicine;
use App\Models\MedicineReminder;
use App\Models\ReminderSchedule;
use App\Models\ReminderScheduleTime;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\QueryBuilder;

class MedicationService
{
    public function list(int $profileId = null)
    {
        return QueryBuilder::for(Medicine::class)
            ->with(['profile', 'medicineType', 'medicineUnit'])
            ->allowedFilters(['name', 'type', 'strength', 'unit', 'profile_id'])
            ->defaultSort('-id')
            ->when($profileId, fn($query) => $query->where('profile_id', $profileId))
            ->paginate(request()->get('per_page', 15));
    }

    public function getMedicine(int $id): Medicine
    {
        return Medicine::with(['profile', 'medicineType', 'medicineUnit', 'reminders.schedules.scheduleTimes'])
            ->findOrFail($id);
    }

    public function storeMedicine(array $data): Medicine
    {
        return DB::transaction(function () use ($data) {
            $medicine = Medicine::create([
                'profile_id' => $data['profile_id'],
                'name' => $data['name'],
                'type' => $data['type'],
                'strength' => $data['strength'],
                'unit' => $data['unit'],
                'is_active' => $data['is_active'] ?? true,
                'notes' => $data['notes'] ?? null
            ]);

            if (isset($data['reminders'])) {
                foreach ($data['reminders'] as $reminderData) {
                    $this->createReminder($medicine->id, $reminderData);
                }
            }

            return $medicine->load(['profile', 'medicineType', 'medicineUnit', 'reminders.schedules.scheduleTimes']);
        });
    }

    public function updateMedicine(int $id, array $data): Medicine
    {
        return DB::transaction(function () use ($id, $data) {
            $medicine = Medicine::findOrFail($id);

            $medicine->update([
                'profile_id' => $data['profile_id'] ?? $medicine->profile_id,
                'name' => $data['name'] ?? $medicine->name,
                'type' => $data['type'] ?? $medicine->type,
                'strength' => $data['strength'] ?? $medicine->strength,
                'unit' => $data['unit'] ?? $medicine->unit,
                'is_active' => $data['is_active'] ?? $medicine->is_active,
                'notes' => $data['notes'] ?? $medicine->notes
            ]);

            if (isset($data['reminders'])) {
                // Delete existing reminders and create new ones
                $medicine->reminders()->delete();

                foreach ($data['reminders'] as $reminderData) {
                    $this->createReminder($medicine->id, $reminderData);
                }
            }

            return $medicine->load(['profile', 'medicineType', 'medicineUnit', 'reminders.schedules.scheduleTimes']);
        });
    }

    public function deleteMedicine(int $id): bool
    {
        $medicine = Medicine::findOrFail($id);
        return $medicine->delete();
    }

    public function createReminder(int $medicineId, array $reminderData): MedicineReminder
    {
        return DB::transaction(function () use ($medicineId, $reminderData) {
            $reminder = MedicineReminder::create([
                'medicine_id' => $medicineId,
                'end_date' => $reminderData['end_date'] ?? null,
                'is_repeat' => $reminderData['is_repeat'] ?? false,
                'till_turn_off' => $reminderData['till_turn_off'] ?? false
            ]);

            if (isset($reminderData['schedules'])) {
                foreach ($reminderData['schedules'] as $scheduleData) {
                    $this->createSchedule($reminder->id, $scheduleData);
                }
            }

            return $reminder->load(['schedules.scheduleTimes']);
        });
    }

    public function createSchedule(int $reminderId, array $scheduleData): ReminderSchedule
    {
        return DB::transaction(function () use ($reminderId, $scheduleData) {
            $schedule = ReminderSchedule::create([
                'reminder_id' => $reminderId,
                'schedule_type' => $scheduleData['schedule_type'],
                'how_many_times' => $scheduleData['how_many_times'] ?? null
            ]);

            if (isset($scheduleData['times'])) {
                foreach ($scheduleData['times'] as $timeData) {
                    ReminderScheduleTime::create([
                        'schedule_id' => $schedule->id,
                        'time' => $timeData['time'],
                        'label' => $timeData['label'] ?? null,
                        'is_active' => $timeData['is_active'] ?? true
                    ]);
                }
            }

            return $schedule->load(['scheduleTimes']);
        });
    }

    public function getMedicinesByProfile(int $profileId): Collection
    {
        return Medicine::with(['medicineType', 'medicineUnit', 'reminders.schedules.scheduleTimes'])
            ->where('profile_id', $profileId)
            ->where('is_active', true)
            ->get();
    }

    public function getActiveReminders(int $profileId = null): Collection
    {
        $query = MedicineReminder::with(['medicine.profile', 'schedules.scheduleTimes'])
            ->whereHas('medicine', function ($q) {
                $q->where('is_active', true);
            });

        if ($profileId) {
            $query->whereHas('medicine', function ($q) use ($profileId) {
                $q->where('profile_id', $profileId);
            });
        }

        return $query->get();
    }
}