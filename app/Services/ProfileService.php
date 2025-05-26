<?php

namespace App\Services;

use App\Models\Profile;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;

class ProfileService
{
    /**
     * Convert height to meters based on unit
     *
     * @param float $height
     * @param int $unit
     * @return float
     */
    protected function convertHeightToMeters(float $height, int $unit): float
    {
        return match ($unit) {
            1 => $height / 100, // cm to meters
            2 => $height * 0.3048, // ft to meters
            default => $height / 100, // default to cm
        };
    }

    /**
     * Convert weight to kg based on unit
     *
     * @param float $weight
     * @param int $unit
     * @return float
     */
    protected function convertWeightToKg(float $weight, int $unit): float
    {
        return match ($unit) {
            1 => $weight, // already in kg
            2 => $weight * 0.453592, // lb to kg
            default => $weight, // default to kg
        };
    }

    /**
     * Calculate BMI based on weight and height
     *
     * @param float|null $weight
     * @param float|null $height
     * @param int|null $weightUnit
     * @param int|null $heightUnit
     * @return float|null
     */
    protected function calculateBMI(?float $weight, ?float $height, ?int $weightUnit, ?int $heightUnit): ?float
    {
        if (!$weight || !$height || !$weightUnit || !$heightUnit) {
            return null;
        }

        // Convert weight to kg
        $weightInKg = $this->convertWeightToKg($weight, $weightUnit);

        // Convert height to meters
        $heightInMeters = $this->convertHeightToMeters($height, $heightUnit);

        // Calculate BMI: weight (kg) / (height (m) * height (m))
        return round($weightInKg / ($heightInMeters * $heightInMeters), 2);
    }

    /**
     * Get all profiles with pagination
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getAllProfiles(int $perPage = 10): LengthAwarePaginator
    {
        return Profile::with('user')->latest()->paginate($perPage);
    }

    /**
     * Get profile by ID
     *
     * @param int $id
     * @return Profile
     * @throws Exception
     */
    public function getProfileById(int $id): Profile
    {
        $profile = Profile::with('user')->findOrFail($id);
        if (!$profile) {
            throw new Exception('Profile not found');
        }
        return $profile;
    }

    /**
     * Handle avatar upload
     *
     * @param UploadedFile|null $file
     * @param string|null $oldAvatar
     * @return string|null
     */
    protected function handleAvatarUpload(?UploadedFile $file, ?string $oldAvatar = null): ?string
    {
        if (!$file) {
            return $oldAvatar;
        }

        // Delete old avatar if exists
        if ($oldAvatar) {
            Storage::disk('public')->delete($oldAvatar);
        }

        // Store new avatar
        $path = $file->store('avatars', 'public');
        return $path;
    }

    /**
     * Create new profile
     *
     * @param array $data
     * @return Profile
     * @throws Exception
     */
    public function createProfile(array $data): Profile
    {
        try {
            // Set user_id from authenticated user
            $data['user_id'] = Auth::id();

            // Handle avatar upload if present
            if (isset($data['avatar']) && $data['avatar'] instanceof UploadedFile) {
                $data['avatar'] = $this->handleAvatarUpload($data['avatar']);
            }

            // Calculate BMI if weight and height are provided
            if (
                isset($data['weight']) && isset($data['height']) &&
                isset($data['weight_unit']) && isset($data['height_unit'])
            ) {
                $data['bmi'] = $this->calculateBMI(
                    $data['weight'],
                    $data['height'],
                    $data['weight_unit'],
                    $data['height_unit']
                );
            }

            return Profile::create($data);
        } catch (Exception $e) {
            throw new Exception('Failed to create profile: ' . $e->getMessage());
        }
    }

    /**
     * Update profile
     *
     * @param int $id
     * @param array $data
     * @return Profile
     * @throws Exception
     */
    public function updateProfile(int $id, array $data): Profile
    {
        try {
            $profile = Profile::findOrFail($id);

            // Handle avatar upload if present
            if (isset($data['avatar']) && $data['avatar'] instanceof UploadedFile) {
                $data['avatar'] = $this->handleAvatarUpload($data['avatar'], $profile->avatar);
            }

            // Calculate BMI if weight or height is updated
            if (
                isset($data['weight']) || isset($data['height']) ||
                isset($data['weight_unit']) || isset($data['height_unit'])
            ) {
                $weight = $data['weight'] ?? $profile->weight;
                $height = $data['height'] ?? $profile->height;
                $weightUnit = $data['weight_unit'] ?? $profile->weight_unit;
                $heightUnit = $data['height_unit'] ?? $profile->height_unit;

                $data['bmi'] = $this->calculateBMI($weight, $height, $weightUnit, $heightUnit);
            }

            $profile->update($data);
            return $profile->fresh(['user']);
        } catch (Exception $e) {
            throw new Exception('Failed to update profile: ' . $e->getMessage());
        }
    }

    /**
     * Delete profile
     *
     * @param int $id
     * @return bool
     * @throws Exception
     */
    public function deleteProfile(int $id): bool
    {
        try {
            $profile = Profile::findOrFail($id);

            // Delete avatar if exists
            if ($profile->avatar) {
                Storage::disk('public')->delete($profile->avatar);
            }

            return $profile->delete();
        } catch (Exception $e) {
            throw new Exception('Failed to delete profile: ' . $e->getMessage());
        }
    }
}
