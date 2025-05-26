<?php

namespace App\Http\Resources\Profile;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'name' => $this->name,
            'avatar_url' => $this->avatar_url,
            'age' => $this->age,
            'weight' => $this->weight,
            'weight_unit' => $this->weightUnit?->name,
            'height_unit' => $this->heightUnit?->name,
            'height' => $this->height,
            'birth_year' => $this->birth_year,
            'bmi' => $this->bmi,
            'bmi_status' => $this->getBmiStatus(),
            'gender' => $this->gender,
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
            'user' => $this->whenLoaded('user', function () {
                return [
                    'id' => $this->user->id,
                    'name' => $this->user->name,
                    'email' => $this->user->email,
                ];
            }),
        ];
    }

    /**
     * Get BMI status based on BMI value
     *
     * @return string
     */
    private function getBmiStatus(): string
    {
        $bmi = $this->bmi;

        if ($bmi === null) {
            return 'Not Calculated';
        }

        if ($bmi < 18.5) {
            return 'Underweight';
        } elseif ($bmi >= 18.5 && $bmi < 25) {
            return 'Normal weight';
        } elseif ($bmi >= 25 && $bmi < 30) {
            return 'Overweight';
        } else {
            return 'Obese';
        }
    }
}
