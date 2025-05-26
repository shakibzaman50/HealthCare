<?php

namespace App\Services\Api;

use App\Http\Resources\Medicine\MedicineResource;
use App\Models\Medicine;
use App\Models\MedicineReminder;
use App\Models\ReminderSchedule;
use App\Models\ReminderScheduleTime;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\QueryBuilder;
use App\Models\MedicineType;
use App\Models\MedicineUnit;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Service class for handling medication-related operations
 */
class MedicationService
{
    /**
     * Get paginated list of medications
     *
     * @param int|null $profileId
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function list(?int $profileId = null)
    {
        return MedicineResource::collection(QueryBuilder::for(Medicine::class)
            ->with(['medicineType', 'medicineUnit', 'frequencies.times'])
            ->when($profileId, function ($query) use ($profileId) {
                $query->where('profile_id', $profileId);
            })
            ->paginate(request()->get('per_page', 15)
        ));
    }

    /**
     * Create a new medication
     *
     * @param array $data
     * @return Medicine
     */
    public function create(array $data): Medicine
    {
        return Medicine::create($data);
    }

    /**
     * Get a specific medication
     *
     * @param int $id
     * @return Medicine
     * @throws NotFoundHttpException
     */
    public function view(int $id): Medicine
    {
        $medication = Medicine::with(['medicineType', 'medicineUnit'])->find($id);

        if (!$medication) {
            throw new NotFoundHttpException('Medication not found');
        }

        return $medication;
    }

    /**
     * Update a medication
     *
     * @param int $id
     * @param array $data
     * @return Medicine
     * @throws NotFoundHttpException
     */
    public function update(int $id, array $data): Medicine
    {
        $medication = Medicine::find($id);

        if (!$medication) {
            throw new NotFoundHttpException('Medication not found');
        }

        $medication->update($data);
        return $medication->fresh();
    }

    /**
     * Delete a medication
     *
     * @param int $id
     * @return bool
     * @throws NotFoundHttpException
     */
    public function delete(int $id): bool
    {
        $medication = Medicine::find($id);

        if (!$medication) {
            throw new NotFoundHttpException('Medication not found');
        }

        return $medication->delete();
    }

    /**
     * Get all medication types
     *
     * @return Collection
     */
    public function types(): Collection
    {
        return MedicineType::select('id', 'name')
            ->where('is_active', true)
            ->get();
    }

    /**
     * Get all medication units
     *
     * @return Collection
     */
    public function units(): Collection
    {
        return MedicineUnit::select('id', 'name')
            ->where('is_active', true)
            ->get();
    }
}